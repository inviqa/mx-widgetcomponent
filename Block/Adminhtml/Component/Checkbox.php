<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

/**
 * Checkbox - useful for replacing Select boolean
 *
 * <data>
 *     <item name="value" xsi:type="string">value</item>
 * </data>
 *
 * @package MX\WidgetComponent\Block\Adminhtml\Component
 */
class Checkbox extends Template
{
    const DEFAULT_VALUE = 1;

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
        $checkbox = $this->createCheckboxElement($element);

        $element->setData(
            'after_element_html',
            $checkbox->getElementHtml()
        );
        $element->setValue(''); // Stop loading the value back for the parent element

        return $element;
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createCheckboxElement(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $checked = false;
        if ($baseElement->getEscapedValue()) {
            $checked = true;
        }

        $value = self::DEFAULT_VALUE;
        if (!empty($config['value'])) {
            $value = $config['value'];
        }

        $checkbox = $this->elementFactory->create('checkbox', ['data' => $baseElement->getData()]);
        $checkbox->setValue($value);
        $checkbox->setIsChecked($checked);
        $checkbox->setId($baseElement->getId());
        $checkbox->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $checkbox->addClass('required-entry');
        }

        return $checkbox;
    }
}