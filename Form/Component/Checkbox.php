<?php

namespace MX\WidgetComponent\Form\Component;

use Magento\Framework\Data\Form\Element\Checkbox as CheckboxParent;

class Checkbox extends CheckboxParent
{
    const CUSTOM_CHECKBOX_AFTER_CONTAINER = '<div><div></div></div>';

    /**
     * Get the after element html.
     *
     * @return mixed
     */
    public function getAfterElementHtml()
    {
        $html = parent::getAfterElementHtml();

        $html .= self::CUSTOM_CHECKBOX_AFTER_CONTAINER;

        return $html;
    }

    /**
     * Get the Html for the element.
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = '<label>';
        $htmlId = $this->getHtmlId();

        $html .= '<input id="' .
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
            ) . '/>';

        if (($afterElementJs = $this->getAfterElementJs())) {
            $html .= $afterElementJs;
        }

        if (($afterElementHtml = $this->getAfterElementHtml())) {
            $html .= $afterElementHtml;
        }

        $html .= '</label>';

        return $html;
    }
}
