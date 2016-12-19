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
}
