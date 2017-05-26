<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

abstract class Base extends Template
{
    const CSS_CLASS_HAS_JS = 'has-js-component';
    const JS_INIT_SCRIPT = '<script type="text/javascript">require([\'jquery\'], function($){$(".has-js-component").trigger(\'contentUpdated\');});</script>';

    protected $unsetValueAfterInit = false;

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
        $element->setNoWrapAsAddon(true);

        $element->setData(
            'after_element_html',
            $this->getComponentHtml($element) . self::JS_INIT_SCRIPT
        );

        if ($this->unsetValueAfterInit) {
            $element->setValue('');
        }

        return $element;
    }

    /**
     * @param  AbstractElement $baseElement
     *
     * @return string
     */
    abstract protected function getComponentHtml(AbstractElement $baseElement);
}
