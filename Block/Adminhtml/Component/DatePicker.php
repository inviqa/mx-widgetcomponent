<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;
use MX\WidgetComponent\Form\Component\DatePicker\Date;

/**
 * Date picker optional configuration
 *
 * <data>
 *     <item name="dateFormat" xsi:type="number">3</item> \IntlDateFormatter
 *     <item name="timeFormat" xsi:type="number">3</item> \IntlDateFormatter
 *     <item name="image" xsi:type="string"></item>
 *     <item name="disabled" xsi:type="boolean">1</item>
 * </data>
 *
 */
class DatePicker extends Template
{
    const DEFAULT_DATE_LABEL = 'Select Date';
    const DEFAULT_DISABLED = 0;

    /**
     * @var Factory
     */
    protected $elementFactory;



    /**
     * @param Context $context
     * @param Factory $elementFactory
     * @param array   $data
     */
    public function __construct(Context $context, Factory $elementFactory, $data = [])
    {
        $this->elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $date = $this->createDateElement($element);

        $element->setData(
            'after_element_html',
            $date->getElementHtml()
        );

        return $element;
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createDateElement(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        if (!empty($config['dateFormat'])) {
            $dateFormat = $config['dateFormat'];
        }

        $timeFormat = $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT);
        if (!empty($config['timeFormat'])) {
            $timeFormat = $config['timeFormat'];
        }

        $disabled = self::DEFAULT_DISABLED;
        if (!empty($config['disabled'])) {
            $disabled = $config['disabled'];
        }

        $image = '';
        if (!empty($config['image'])) {
            $image = $config['image'];
        }

        $date = $this->elementFactory->create(Date::class, ['data' => $baseElement->getData()]);
        $date->setDateFormat($dateFormat);
        $date->setTimeFormat($timeFormat);
        $date->setDisabled($disabled);
        $date->setImage($image);

        $date->setId($baseElement->getId());
        $date->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $date->addClass('required-entry');
        }

        return $date;
    }
}