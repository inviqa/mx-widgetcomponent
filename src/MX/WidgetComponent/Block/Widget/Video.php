<?php

namespace MX\WidgetComponent\Block\Widget;

use MX\WidgetComponent\Block\Widget\Base;

class Video extends Base
{
    /**
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->renderVideoUrl($this->getData('video_url'));
    }
}
