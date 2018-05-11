<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\VideoPicker;

use Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Tree as TreeParent;

/**
 * Wysiwyg Videos tree block
 */
class Tree extends TreeParent
{
    /**
     * Json source URL
     *
     * @return string
     */
    public function getTreeLoaderUrl()
    {
        return $this->getUrl('cms/wysiwyg_images/treeJson');
    }
}
