<?php

namespace MX\WidgetComponent\Block\Widget;

use MX\WidgetComponent\Block\Widget\Link;

class ImageLink extends Link
{
    public function getImage()
    {
        return $this->renderWidget($this->getData('image'));
    }
}
