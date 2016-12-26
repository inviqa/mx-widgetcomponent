<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SubWidget extends Base
{
    const DEFAULT_BUTTON_LABEL = 'Configure';
    const CONFIG_KEY_BUTTON_LABEL = 'button-label';
    const CONFIG_KEY_WIDGET_TYPE = 'widget-type-id';

    /**
     * @param AbstractElement $baseElement
     *
     * @return string
     */
    protected function getComponentHtml(AbstractElement $baseElement)
    {
        $input = $this->createHiddenElement($baseElement);
        $button = $this->createConfigureButton($baseElement);

        return $input->getElementHtml() . $button->toHtml();
    }

    /**
     * @param  AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createHiddenElement(AbstractElement $baseElement)
    {
        $hidden = $this->elementFactory->create("hidden", ['data' => $baseElement->getData()]);
        $hidden->setId($baseElement->getId());
        $hidden->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $hidden->addClass('required-entry');
        }

        return $hidden;
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return Button
     */
    protected function createConfigureButton(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $label = self::DEFAULT_BUTTON_LABEL;
        if (!empty($config[self::CONFIG_KEY_BUTTON_LABEL])) {
            $label = $config[self::CONFIG_KEY_BUTTON_LABEL];
        }

        $sourceUrl = $this->buildUrl($baseElement->getId());

        $button = $this->getLayout()->createBlock(Button::class)
            ->setType('button')
            ->setId($baseElement->getId() . '_button')
            ->setClass('btn-chooser ' . self::CSS_CLASS_HAS_JS)
            ->setLabel($label)
            ->setDisabled($baseElement->getReadonly())
            ->setDataAttribute(
                [
                    'mage-init' => [
                        'MXWidgetComponentSubWidget' => [
                            'url' => $sourceUrl,
                            'targetId' => $baseElement->getId()
                        ]
                    ]
                ]
            );

        return $button;
    }

    /**
     * @param  string $targetElementId
     *
     * @return string
     */
    protected function buildUrl($targetElementId)
    {
        $config = $this->_getData('config');

        if (empty($config[self::CONFIG_KEY_WIDGET_TYPE])) {
            throw new \Exception('Missing widget type configuration');
        }

        $params = [];
        $params['target_element_id'] = $targetElementId;
        $params['widget_type_id'] = $config[self::CONFIG_KEY_WIDGET_TYPE];

        return $this->getUrl('widgetcomponent/subwidget/index', $params);
    }
}
