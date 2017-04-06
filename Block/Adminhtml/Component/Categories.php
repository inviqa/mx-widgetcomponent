<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Multiselect;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

/**
 * @package MX\WidgetComponent\Block\Adminhtml\Component
 */
class Categories extends Base
{
    /**
     * @var boolean
     */
    protected $unsetValueAfterInit = true;
    
    /**
     * @var CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @param Context           $context
     * @param Factory           $elementFactory
     * @param CollectionFactory $categoryCollectionFactory
     * @param array             $data
     */
    public function __construct(
        Context $context,
        Factory $elementFactory,
        CollectionFactory $categoryCollectionFactory,
        $data = []
    ) {
        parent::__construct($context, $elementFactory, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     */
    public function getComponentHtml(AbstractElement $element)
    {
        $multiselect = $this->createMultiselectElement($element);

        return $multiselect->getElementHtml();
    }

    /**
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createMultiselectElement(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('level');
        
        $values = [];
        foreach ($collection as $category) {
            $indent = str_repeat('--', $category->getLevel());
            $values[] = array(
               'label' => $indent . $category->getName(),
               'value' => $category->getId()
            );
        }

        $checkbox = $this->elementFactory->create(Multiselect::class, ['data' => $baseElement->getData()]);
        $checkbox->setValues($values);
        $checkbox->setId($baseElement->getId());
        $checkbox->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $checkbox->addClass('required-entry');
        }

        return $checkbox;
    }
}
