<?php

namespace MX\WidgetComponent\Form\Component\DatePicker;

use Magento\Framework\Data\Form\Element\Date as DateParent;

class Date extends DateParent
{
    /**
     *
     * @return string
     */
    public function getAfterElementHtml()
    {
        // Workaround for initialising the calendar date picker script
        return '<script type="text/javascript">' .
            'jQuery("#' . $this->getHtmlId() . '").trigger(\'contentUpdated\');' .
            '</script>';
    }
}
