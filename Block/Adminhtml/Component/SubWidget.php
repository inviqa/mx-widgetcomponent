<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

class SubWidget extends Template
{
    const DEFAULT_BUTTON_LABEL = 'Configure';
    const CONFIG_KEY_BUTTON_LABEL = 'button-label';
    const CONFIG_KEY_WIDGET_TYPE = 'widget-type-id';

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
        $sourceUrl = $this->buildUrl($element->getId());

        $chooser = $this->createConfigureButton($element, $sourceUrl);
        $input = $this->createHiddenElement($element);

        $requiredJs = '<script>require(["MXWidgetComponentSubWidget"], function(){
            window.subWidgetDialogHandler' . $element->getId() . ' = new SubWidget.DialogHandler(' . $element->getId() . ');
        })</script>';

        // Disable wrapper for the element and the hidden input
        $element->setNoWrapAsAddon(true);

        $element->setData(
            'after_element_html',
            $requiredJs . $input->getElementHtml() . $chooser->toHtml()
        );

        return $element;
    }

    protected function createHiddenElement(AbstractElement $baseElement)
    {
        $hidden = $this->elementFactory->create("text", ['data' => $baseElement->getData()]);
        $hidden->setId($baseElement->getId());
        $hidden->setForm($baseElement->getForm());
        $hidden->addClass('hidden');
        if ($baseElement->getRequired()) {
            $hidden->addClass('required-entry');
        }

        return $hidden;
    }

    /**
     * @param AbstractElement $baseElement
     * @param string $sourceUrl
     *
     * @return Button
     */
    protected function createConfigureButton(AbstractElement $baseElement, $sourceUrl)
    {
        $config = $this->_getData('config');

        $label = self::DEFAULT_BUTTON_LABEL;
        if (!empty($config[self::CONFIG_KEY_BUTTON_LABEL])) {
            $label = $config[self::CONFIG_KEY_BUTTON_LABEL];
        }

        $onClick = 'subWidgetDialogHandler' . $baseElement->getId() . '.openDialog("' . $sourceUrl . '")';

        $button = $this->getLayout()->createBlock(Button::class)
            ->setType('button')
            ->setClass('btn-chooser')
            ->setLabel($label)
            ->setOnClick($onClick)
            ->setDisabled($baseElement->getReadonly());

        return $button;
    }

    protected function buildUrl($targetElementId)
    {
        $config = $this->_getData('config');

        $params = ['target_element_id' => $targetElementId];

        if (empty($config[self::CONFIG_KEY_WIDGET_TYPE])) {
            throw new \Exception('Missing widget type configuration');
        }

        $params['widget_type_id'] = $config[self::CONFIG_KEY_WIDGET_TYPE];

        return $this->getUrl('widgetcomponent/subwidget/index', $params);
    }
}
