<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\ImagePicker;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Content\Uploader as UploaderParent;
use Magento\Cms\Model\Wysiwyg\Images\Storage;
use Magento\Framework\File\Size;

/**
 * Wysiwyg Images uploader block
 */
class Uploader extends UploaderParent
{
    public function __construct(
        Context $context,
        Size $fileSize,
        Storage $imagesStorage,
        array $data = []
    ) {
        parent::__construct($context, $fileSize, $imagesStorage, $data);

        $type = $this->_getMediaType();
        $this->getConfig()->setUrl(
            $this->_urlBuilder->getUrl('cms/wysiwyg_images/upload', ['type' => $type])
        );
    }
}
