<?php

namespace MX\WidgetComponent\Block\Widget;

use MX\WidgetComponent\Block\Widget\Base;

class Link extends Base
{
    const NEW_WINDOW_HTML = 'target="_blank"';

    /**
     * @return string
     */
    public function getTargetAttribute()
    {
        $targetAttribute = '';

        if ($this->shouldOpenInNewWindow()) {
            $targetAttribute = self::NEW_WINDOW_HTML;
        }

        return $targetAttribute;
    }

    /**
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->renderUrl($this->getData('link_url'));
    }

    /**
     * @return string
     */
    public function getLinkText()
    {
        return $this->getData('link_text');
    }

    /**
     * @return bool
     */
    private function shouldOpenInNewWindow()
    {
        return (bool) $this->getData('open_in_new_window');
    }
}
