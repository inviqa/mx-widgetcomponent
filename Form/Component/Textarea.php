<?php

namespace MX\WidgetComponent\Form\Component;

use Magento\Framework\Data\Form\Element\Textarea as TextareaParent;

class Textarea extends TextareaParent
{
    /**
     * Return the HTML attributes
     *
     * @return string[]
     */
    public function getHtmlAttributes()
    {
        $attributes = parent::getHtmlAttributes();

        return array_merge($attributes, ['maxlength']);
    }

    /**
     * Return the element as HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = parent::getElementHtml();

        if ($this->getData('maxlength')) {
            $html = str_replace('>', " data-mage-init='{\"MXWidgetComponentTextarea\":{}}'>", $html);
        }

        return $html;
    }
}
