<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use MX\WidgetComponent\Form\Component\ImagePicker\Image\Preview;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\UrlInterface;

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
class ImagePicker extends Base
{
    const DEFAULT_CHOOSE_LABEL = 'Select Image...';

    /**
     * @param AbstractElement $baseElement
     *
     * @return string
     */
    protected function getComponentHtml(AbstractElement $baseElement)
    {
        $button = $this->createChooseButton($baseElement);
        $image = $this->createPreviewImage($baseElement);
        $input = $this->createHiddenElement($baseElement);

        return $input->getElementHtml() . $image->getElementHtml() . $button->toHtml();
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
     *
     * @return Button
     */
    protected function createChooseButton(AbstractElement $baseElement)
    {
        $config = $this->_getData('config');

        $label = self::DEFAULT_CHOOSE_LABEL;
        if (!empty($config['button']['open'])) {
            $label = $config['button']['open'];
        }

        $sourceUrl = $this->buildUrl($baseElement->getId());
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        $button = $this->getLayout()->createBlock(Button::class)
            ->setType('button')
            ->setId($baseElement->getId() . '_button')
            ->setClass('btn-chooser ' . self::CSS_CLASS_HAS_JS)
            ->setLabel($label)
            ->setDisabled($baseElement->getReadonly())
            ->setDataAttribute(
                [
                    'mage-init' => [
                        'MXWidgetComponentImagePicker' => [
                            'url' => $sourceUrl,
                            'targetId' => $baseElement->getId(),
                            'baseMediaUrl' => $mediaUrl
                        ]
                    ]
                ]
            );

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
