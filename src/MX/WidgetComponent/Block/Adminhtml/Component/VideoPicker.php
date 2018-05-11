<?php

namespace MX\WidgetComponent\Block\Adminhtml\Component;

use MX\WidgetComponent\Form\Component\MediaPicker\Video\Preview;
use MX\WidgetComponent\Form\Component\MediaPicker\RemoveLink;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\UrlInterface;

/**
 * Video picker optional configuration
 *
 * <data>
 *     <item name="max-size" xsi:type="string">500000</item>
 *     <item name="button" xsi:type="array">
 *         <item name="open" xsi:type="string">Select Video...</item>
 *    </item>
 * </data>
 *
 */
class VideoPicker extends Base
{
    const DEFAULT_CHOOSE_LABEL = 'Select Video...';
    const PLACEHOLDER_IMAGE_PATH = 'MX_WidgetComponent::images/camera.png';

    /**
     * @param AbstractElement $baseElement
     *
     * @return string
     */
    protected function getComponentHtml(AbstractElement $baseElement)
    {
        $button = $this->createChooseButton($baseElement);
        $preview = $this->createPreviewVideo($baseElement);
        $removeLink = $this->createRemoveVideoLink($baseElement);
        $input = $this->createHiddenElement($baseElement);

        return $input->getElementHtml() . $preview->getElementHtml() . $button->toHtml() . $removeLink->getElementHtml();
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
                        'MXWidgetComponentMediaPicker' => [
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
     * Create preview video
     *
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createPreviewVideo(AbstractElement $baseElement)
    {
        $video = $this->elementFactory->create(Preview::class, ['data' => $baseElement->getData()]);
        $video->setData('src', self::PLACEHOLDER_IMAGE_PATH);
        $video->setId($baseElement->getId() . '_preview_video');
        $video->setForm($baseElement->getForm());

        return $video;
    }

    /**
     * Create remove video link
     *
     * @param AbstractElement $baseElement
     *
     * @return AbstractElement
     */
    protected function createRemoveVideoLink(AbstractElement $baseElement)
    {
        $link = $this->elementFactory->create(RemoveLink::class, ['data' => $baseElement->getData()]);
        $link->setId($baseElement->getId() . '_remove_video');
        $link->setForm($baseElement->getForm());

        return $link;
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

        return $this->getUrl('widgetcomponent/videopicker/index', $params);
    }
}
