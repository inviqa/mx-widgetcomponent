<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Framework\Data\Form\Element\AbstractElement;
use MX\WidgetComponent\Form\Component\Textarea as TextareaComponent;

/**
 * Textarea optional configuration
 *
 * <data>
 *     <item name="cols" xsi:type="string"></item>
 *     <item name="rows" xsi:type="string"></item>
 *     <item name="maxlength" xsi:type="string"></item>
 * </data>
 *
 * Date formats: Zend_Date
 *
 */
class Textarea extends Base
{
    protected $unsetValueAfterInit = true;
    
    /**
     * @param  AbstractElement $baseElement
     *
     * @return string
     */
    public function getComponentHtml(AbstractElement $element)
    {
        $textarea = $this->createTextareaElement($element);

        return $textarea->getElementHtml();
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createTextareaElement(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $textarea = $this->elementFactory->create(TextareaComponent::class, ['data' => $baseElement->getData()]);
        $textarea->setId($baseElement->getId());
        $textarea->setForm($baseElement->getForm());
        $textarea->setClass(self::CSS_CLASS_HAS_JS);
        if ($baseElement->getRequired()) {
            $textarea->addClass('required-entry');
        }

        if (!empty($config['cols'])) {
            $textarea->setData('cols', $config['cols']);
        }

        if (!empty($config['rows'])) {
            $textarea->setData('rows', $config['rows']);
        }

        if (!empty($config['maxlength'])) {
            $textarea->setData('maxlength', $config['maxlength']);
        }

        return $textarea;
    }
}
