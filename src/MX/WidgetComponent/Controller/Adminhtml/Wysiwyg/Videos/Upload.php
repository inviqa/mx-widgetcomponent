<?php
namespace MX\WidgetComponent\Controller\Adminhtml\Wysiwyg\Videos;

use MX\WidgetComponent\Model\Wysiwyg\Video\Storage;
use Magento\Cms\Controller\Adminhtml\Wysiwyg\Images\Upload as UploadParent;

/**
 * Upload video.
 */
class Upload extends UploadParent
{
    /**
     * Register storage model and return it
     *
     * @return Storage
     */
    public function getStorage()
    {
        if (!$this->_coreRegistry->registry('storage')) {
            $storage = $this->_objectManager->create(Storage::class);
            $this->_coreRegistry->register('storage', $storage);
        }
        return $this->_coreRegistry->registry('storage');
    }
}
