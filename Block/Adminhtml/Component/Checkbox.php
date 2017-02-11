<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Framework\Data\Form\Element\AbstractElement;
use MX\WidgetComponent\Form\Component\Checkbox as CheckboxComponent;

/**
 * Checkbox - useful for replacing Select boolean
 *
 * <data>
 *     <item name="value" xsi:type="string">value</item>
 * </data>
 *
 * @package MX\WidgetComponent\Block\Adminhtml\Component
 */
class Checkbox extends Base
{
    const DEFAULT_VALUE = 1;

    protected $unsetValueAfterInit = true;

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     */
    public function getComponentHtml(AbstractElement $element)
    {
        $checkbox = $this->createCheckboxElement($element);

        return $checkbox->getElementHtml();
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

        $checkbox = $this->elementFactory->create(CheckboxComponent::class, ['data' => $baseElement->getData()]);
        $checkbox->setValue($value);
        $checkbox->setIsChecked($checked);
        $checkbox->setId($baseElement->getId());
        $checkbox->setForm($baseElement->getForm());
        $checkbox->addClass('ios-switch');
        if ($baseElement->getRequired()) {
            $checkbox->addClass('required-entry');
        }

        return $checkbox;
    }
}
