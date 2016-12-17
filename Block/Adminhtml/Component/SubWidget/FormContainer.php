<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component\SubWidget;

use Magento\Backend\Block\Widget\Container as BaseFormContainer;
use Magento\Backend\Block\Widget\Context;
use Magento\Widget\Model\Widget as WidgetProvider;
use Symfony\Component\Yaml\Yaml;

class FormContainer extends BaseFormContainer
{
    /**
     * @var string
     */
    protected $_template = 'subwidget/form/container.phtml';
    
    /**
     * @var WidgetProvider
     */
    private $widgetProvider;

    /**
     * @param Context        $context
     * @param array          $data
     * @param WidgetProvider $widgetProvider
     */
    public function __construct(Context $context, WidgetProvider $widgetProvider, array $data = [])
    {
        $this->widgetProvider = $widgetProvider;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->addButton(
            'save',
            [
                'label' => __('Save'),
                'class' => 'save primary add-widget',
                'id' => 'insert_button',
                'region' => 'footer',
                'onclick' => $this->getFormHandlerJsObj() . '.insertWidget()'
            ],
            1
        );
    }

    /**
     * @return string
     */
    public function getFormHandlerJsObj()
    {
        return 'subWidgetFormHandler' . $this->getTargetElementId();
    }

    /**
     * @return string
     */
    public function getWidgetType()
    {
        $typeId = $this->getRequest()->getParam('widget_type_id');
        $result = $this->widgetProvider->getWidgets();
        
        if (!isset($result[$typeId])) {
            throw new \Exception($typeId . ' widget is not found');
        }

        return $result[$typeId]['@']['type'];
    }

    /**
     * @return array
     */
    public function getWidgetValues()
    {
        return Yaml::parse($this->getRequest()->getParam('widget_values'));
    }

    /**
     * @return string
     */
    public function getTargetElementId()
    {
        return $this->getRequest()->getParam('target_element_id');
    }

    /**
     * @return string
     */
    public function getFormHtml()
    {
        return $this->getChildHtml('form');
    }
}
