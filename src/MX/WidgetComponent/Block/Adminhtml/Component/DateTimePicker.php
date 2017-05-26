<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Date time picker optional configuration
 *
 * <data>
 *     <item name="dateFormat" xsi:type="string"></item>
 *     <item name="timeFormat" xsi:type="string"></item>
 *     <item name="image" xsi:type="string"></item>
 *     <item name="disabled" xsi:type="boolean"></item>
 * </data>
 *
 * Date formats: Zend_Date
 *
 */
class DateTimePicker extends DatePicker
{
    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createDateElement(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $timeFormat = $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT);
        if (!empty($config['timeFormat'])) {
            $timeFormat = $config['timeFormat'];
        }

        $date = parent::createDateElement($baseElement);
        $date->setTimeFormat($timeFormat);

        return $date;
    }
}