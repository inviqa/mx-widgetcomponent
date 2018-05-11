<?php

namespace MX\WidgetComponent\Controller\Adminhtml\VideoPicker;

use Magento\Catalog\Helper\Data;
use Magento\Cms\Controller\Adminhtml\Wysiwyg\Images\OnInsert as OnInsertParent;
use Magento\Cms\Helper\Wysiwyg\Images;
use Magento\Framework\Controller\ResultInterface;

class OnInsert extends OnInsertParent
{
    /**
     * Fire when select image
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $helper = $this->_objectManager->get(Images::class);
        $storeId = $this->getRequest()->getParam('store');

        $filename = $this->getRequest()->getParam('filename');
        $filename = $helper->idDecode($filename);

        $this->_objectManager->get(Data::class)->setStoreId($storeId);
        $helper->setStoreId($storeId);

        $fileUrl = $helper->getCurrentUrl() . $filename;
        $mediaBaseUrl = $helper->getBaseUrl();
        $mediaPath = str_replace($mediaBaseUrl, '', $fileUrl);

        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents($mediaPath);

        try {
            $fileAbsolutePath = implode('/', [$helper->getCurrentPath(), $filename]);
            $this->validateVideo($fileAbsolutePath);
        } catch (\Exception $e) {
            $resultRaw->setContents($e->getMessage());
        }

        return $resultRaw;
    }

    /**
     * Validate video size
     *
     * @param string $imagePath
     * @throws \Exception
     */
    protected function validateVideo($imagePath)
    {
        $maxSize = $this->getRequest()->getParam('max-size', '');

        $fileSize = filesize($imagePath);

        if (!empty($maxSize) && $fileSize > $maxSize) {
            throw new \Exception("Maximum media file size exceeded. Given: $fileSize, Max: $maxSize");
        }
    }
}
