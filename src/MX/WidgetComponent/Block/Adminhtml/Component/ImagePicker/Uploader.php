<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\ImagePicker;

use Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Content\Uploader as UploaderParent;

/**
 * Wysiwyg Images uploader block
 */
class Uploader extends UploaderParent
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\File\Size $fileSize,
        \Magento\Cms\Model\Wysiwyg\Images\Storage $imagesStorage,
        array $data = []
    )
    {
        parent::__construct($context, $fileSize, $imagesStorage, $data);

        $type = $this->_getMediaType();
        $this->getConfig()->setUrl(
            $this->_urlBuilder->addSessionParam()->getUrl('cms/wysiwyg_images/upload', ['type' => $type])
        );
    }
}
