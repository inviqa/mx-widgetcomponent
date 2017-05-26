<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\SubWidget;

use MX\WidgetComponent\Block\Adminhtml\Component\SubWidget\FormContainer;
use Magento\Widget\Block\Adminhtml\Widget\Options as BaseForm;
use Symfony\Component\Yaml\Yaml;

class Form extends BaseForm
{
    protected function _prepareForm()
    {
        $form = $this->getForm();
        $form->setUseContainer(true);
        $form->setId($this->getTargetElementId() . '_options_form');
        $form->setMethod('post');
        $form->setAction($this->getUrl('widgetcomponent/subwidget/onInsert'));

        $this->addFields();

        $this->getMainFieldset()->addField(
            'parameters[widget_type]',
            'hidden',
            [
                'name' => 'parameters[widget_type]',
                'value' => $this->getWidgetType()
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getWidgetType()
    {
        return $this->getDataContainer()->getWidgetType();
    }

    /**
     * @return array
     */
    public function getWidgetValues()
    {
        return $this->getDataContainer()->getWidgetValues();
    }

    /**
     * @return string
     */
    public function getTargetElementId()
    {
        return $this->getDataContainer()->getTargetElementId();
    }

    /**
     * @return FormContainer
     */
    public function getDataContainer()
    {
        return $this->getParentBlock();
    }
}
