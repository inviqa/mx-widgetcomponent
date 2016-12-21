<?php

namespace MX\WidgetComponent\Form\Component\SubWidget;

use Magento\Framework\Data\Form\Element\Button as ButtonParent;

class Button extends ButtonParent
{
    /**
     * Return the element as HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = '';
        $htmlId = $this->getHtmlId() . '_button';

        if (($beforeElementHtml = $this->getBeforeElementHtml())) {
            $html .= '<label class="addbefore" for="' .
                $htmlId .
                '">' .
                $beforeElementHtml .
                '</label>';
        }

        $html .= '<button id="' .
            $htmlId .
            '" name="' .
            $this->getName() .
            '" ' .
            $this->_getUiId() .
            ' value="' .
            $this->getEscapedValue() .
            '" ' .
            $this->serialize(
                $this->getHtmlAttributes()
            ) . '><span>' . $this->getButtonLabel() . '</span></button>';

        if (($afterElementJs = $this->getAfterElementJs())) {
            $html .= $afterElementJs;
        }

        if (($afterElementHtml = $this->getAfterElementHtml())) {
            $html .= '<label class="addafter" for="' .
                $htmlId .
                '">' .
                $afterElementHtml .
                '</label>';
        }

        $html = str_replace(
            '><span>',
            " data-mage-init='{\"MXWidgetComponentSubWidget\":{\"url\":\"" . $this->getData('url') . "\", \"targetId\":\"" . $this->getHtmlId() . "\"}}'><span>",
            $html
        );

        return $html;
    }

    /**
     *
     * @return string
     */
    public function getAfterElementHtml()
    {
        /**
         * Workaround for initialising the script.
         */
        return '<script type="text/javascript">' .
        'require([\'jquery\'], function($){$("#' . $this->getHtmlId() . '").trigger(\'contentUpdated\');});' .
        '</script>';
    }
}
