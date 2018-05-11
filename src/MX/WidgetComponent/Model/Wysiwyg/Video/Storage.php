<?php

namespace MX\WidgetComponent\Model\Wysiwyg\Video;

use Magento\Cms\Model\Wysiwyg\Images\Storage as StorageParent;

/**
 * Wysiwyg Video uploader block
 */
class Storage extends StorageParent
{
    /**
     * Create thumbnail for image and save it to thumbnails directory
     *
     * @param string $source Image path to be resized
     * @param bool $keepRation Keep aspect ratio or not
     * @return bool|string Resized filepath or false if errors were occurred
     */
    public function resizeFile($source, $keepRation = true)
    {
        return false; // Do nothing for videos
    }
}
