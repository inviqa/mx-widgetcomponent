<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\ImagePicker;

use Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Content as ContentParent;

/**
 * Wysiwyg Images content block
 */
class Content extends ContentParent
{
    /**
     * Files action source URL
     *
     * @return string
     */
    public function getContentsUrl()
    {
        return $this->getUrl('cms/wysiwyg_images/contents', ['type' => $this->getRequest()->getParam('type')]);
    }

    /**
     * New directory action target URL
     *
     * @return string
     */
    public function getNewfolderUrl()
    {
        return $this->getUrl('cms/wysiwyg_images/newFolder');
    }

    /**
     * Delete directory action target URL
     *
     * @return string
     */
    protected function getDeletefolderUrl()
    {
        return $this->getUrl('cms/wysiwyg_images/deleteFolder');
    }

    /**
     * Description goes here...
     *
     * @return string
     */
    public function getDeleteFilesUrl()
    {
        return $this->getUrl('cms/wysiwyg_images/deleteFiles');
    }

    /**
     * New directory action target URL
     *
     * @return string
     */
    public function getOnInsertUrl()
    {
        return $this->getUrl('widgetcomponent/*/onInsert', $this->getRequest()->getParams());
    }
}
