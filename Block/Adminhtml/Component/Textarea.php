<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

class Textarea extends Template
{
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
        $textarea = $this->createTextareaElement($element);

        $element->setData(
            'after_element_html',
            $textarea->getElementHtml()
        );
        $element->setValue(''); // Stop loading the value back for the parent element

        return $element;
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createTextareaElement(AbstractElement $baseElement)
    {
        $textarea = $this->elementFactory->create('textarea', ['data' => $baseElement->getData()]);
        $textarea->setId($baseElement->getId());
        $textarea->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $textarea->addClass('required-entry');
        }

        return $textarea;
    }
}