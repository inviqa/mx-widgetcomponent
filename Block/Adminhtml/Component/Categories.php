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
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('level');

        if ($this->shouldOnlyShowActiveCategories()) {
            $collection->addFieldToFilter('is_active', ['eq' => 1]);
        }
        
        $values = [];
        foreach ($collection as $category) {
            $indent = str_repeat('--', $category->getLevel() - 1);
            $values[] = array(
                'label' => $indent . $category->getName(),
                'value' => $category->getId(),
                'disabled' => intval($category->getLevel()) === 1
            );
        }

        $multiselect = $this->elementFactory->create(Multiselect::class, ['data' => $baseElement->getData()]);
        $multiselect->setValues($values);
        $multiselect->setId($baseElement->getId());
        $multiselect->setForm($baseElement->getForm());
        if ($baseElement->getRequired()) {
            $multiselect->addClass('required-entry');
        }

        return $multiselect;
    }

    /**
     * @return bool
     */
    private function shouldOnlyShowActiveCategories()
    {
        $config = $this->_getData('config');

        return isset($config['only_active']) && 'true' === $config['only_active'];
    }
}
