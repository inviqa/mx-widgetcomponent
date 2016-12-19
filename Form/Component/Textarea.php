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
     *
     * @return string
     */
    public function getAfterElementHtml()
    {
        $html = '';
        if ($this->getData('maxlength')) {
            $html = '<script type="text/javascript">' .
                '(function($) {' .
                    '$("#' . $this->getHtmlId() . '").keyup(function () {' .
                        'var left = ' . $this->getData('maxlength') . ' - $(this).val().length;' .
                        'if (left < 0) { left = 0; }' .
                        '$("#' . $this->getHtmlId() . '").prev().text("Characters left: " + left); ' .
                    '});' .
                '})(jQuery);' .
            '</script>';
        }

        return $html;
    }
}
