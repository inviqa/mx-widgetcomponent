<?php

namespace MX\WidgetComponent\Block\Widget;

use MX\WidgetComponent\Block\Widget\Base;

class Image extends Base
{
    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->renderImageUrl($this->getData('image_url'));
    }

    /**
     * @return string
     */
    public function getImageAltText()
    {
        return $this->getData('image_alt_text');
    }
}
