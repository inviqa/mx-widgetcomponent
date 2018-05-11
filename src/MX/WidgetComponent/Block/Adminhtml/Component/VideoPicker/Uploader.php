<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\VideoPicker;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Content\Uploader as UploaderParent;
use Magento\Framework\File\Size;
use MX\WidgetComponent\Model\Wysiwyg\Video\Storage;

/**
 * Wysiwyg Video uploader block
 */
class Uploader extends UploaderParent
{
    public function __construct(
        Context $context,
        Size $fileSize,
        Storage $videoStorage,
        array $data = []
    ) {
        parent::__construct($context, $fileSize, $videoStorage, $data);

        $this->getConfig()->setUrl(
            $this->_urlBuilder->addSessionParam()->getUrl(
                'widgetcomponent/wysiwyg_videos/upload',
                ['type' => 'media']
            )
        );
    }
}
