<?php

namespace MX\WidgetComponent\Controller\Adminhtml\ImagePicker;

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
            $this->validateImage($fileAbsolutePath);
        } catch (\Exception $e) {
            $resultRaw->setContents($e->getMessage());
        }

        return $resultRaw;
    }

    /**
     * Validate image size and dimension
     *
     * @param string $imagePath
     * @throws \Exception
     */
    protected function validateImage($imagePath)
    {
        $maxSize = $this->getRequest()->getParam('max-size');
        $maxWidth = $this->getRequest()->getParam('max-width');
        $maxHeight = $this->getRequest()->getParam('max-height');

        list($width, $height) = getimagesize($imagePath);
        $fileSize = filesize($imagePath);

        if (!empty($maxSize) && $fileSize > $maxSize) {
            throw new \Exception("Maximum image file size exceeded. Given: $fileSize, Max: $maxSize");
        }

        if (!empty($maxWidth) && $width > $maxWidth) {
            throw new \Exception("Maximum image width exceeded. Given: $width, Max: $maxWidth");
        }

        if (!empty($maxHeight) && $height > $maxHeight) {
            throw new \Exception("Maximum image height exceeded. Given: $height, Max: $maxHeight");
        }
    }
}
