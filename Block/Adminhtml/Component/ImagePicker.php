<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use MX\WidgetComponent\Form\Component\ImagePicker\Image\Preview;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

/**
 * Image picker optional configuration
 *
 * <data>
 *     <item name="dimension" xsi:type="array">
 *         <item name="max-width" xsi:type="string">500</item>
 *         <item name="max-height" xsi:type="string">500</item>
 *     </item>
 *     <item name="max-size" xsi:type="string">50000</item>
 *     <item name="button" xsi:type="array">
 *         <item name="open" xsi:type="string">Select Image...</item>
 *    </item>
 * </data>
 *
 */
class ImagePicker extends Template
{
    const DEFAULT_CHOOSE_LABEL = 'Select Image...';

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

        $chooser = $this->createChooseButton($element, $sourceUrl);
        $image = $this->createPreviewImage($element);
        $input = $this->createHiddenElement($element);

        // Disable wrapper for the element and the hidden input
        $element->setNoWrapAsAddon(true);

        $element->setData(
            'after_element_html',
            $input->getElementHtml() . $image->getElementHtml() . $chooser->toHtml()
        );

        return $element;
    }

    /**
     * @param AbstractElement $baseElement
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
     * @param string $sourceUrl
     *
     * @return Button
     */
    protected function createChooseButton(AbstractElement $baseElement, $sourceUrl)
    {
        $config = $this->_getData('config');

        $label = self::DEFAULT_CHOOSE_LABEL;
        if (!empty($config['button']['open'])) {
            $label = $config['button']['open'];
        }

        $button = $this->getLayout()->createBlock(Button::class)
            ->setType('button')
            ->setClass('btn-chooser')
            ->setLabel($label)
            ->setOnClick('MediabrowserUtility.openDialog(\'' . $sourceUrl . '\')')
            ->setDisabled($baseElement->getReadonly());

        return $button;
    }

    /**
     * Create preview image
     *
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createPreviewImage(AbstractElement $baseElement)
    {
        $image = $this->elementFactory->create(Preview::class, ['data' => $baseElement->getData()]);
        $image->setData('src', $baseElement->getValue());
        $image->setId($baseElement->getId() . '_preview_image');
        $image->setForm($baseElement->getForm());

        return $image;
    }

    /**
     * Build params based on the config
     *
     * @param string $targetElementId
     *
     * @return string
     */
    protected function buildUrl($targetElementId)
    {
        $params = ['target_element_id' => $targetElementId];

        $config = $this->_getData('config');
        if (isset($config['max-size'])) {
            $params['max-size'] = $config['max-size'];
        }

        if (isset($config['dimension']['max-width'])) {
            $params['max-width'] = $config['dimension']['max-width'];
        }

        if (isset($config['dimension']['max-height'])) {
            $params['max-height'] = $config['dimension']['max-height'];
        }

        return $this->getUrl('widgetcomponent/imagepicker/index', $params);
    }
}