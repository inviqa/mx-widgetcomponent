<?php

namespace MX\WidgetComponent\Form\Component\ImagePicker\Image;

use MX\WidgetComponent\Helper\Image as ImageHelper;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;

class Preview extends AbstractElement
{
    const DIV_TAG = '<div style="float: left; margin-right: 10px">%s</div>';
    const A_TAG = '<a href="javascript:void(0)" onclick="imagePreview(\'%s\')">%s</a>';
    const IMG_TAG = '<img id="%s" src="%s" height="36" width="36" class="v-middle"/>';

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @param Factory           $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper           $escaper
     * @param ImageHelper       $imageHelper
     * @param array             $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        ImageHelper $imageHelper,
        $data = []
    ) {
        $this->imageHelper = $imageHelper;
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('image');
    }

    /**
     * Return element html code
     *
     * @return string
     */
    public function getElementHtml()
    {
        $imageId = $this->getHtmlId();
        $imageUrl = $this->getImageUrl();

        return $this->createDivTag($this->createATag($imageId, $this->createImgTag($imageId, $imageUrl)));
    }

    /**
     * @return string
     */
    private function getImageUrl()
    {
        return $this->imageHelper->getImageUrl($this->getValue());
    }

    /**
     * @param  string $imageId
     * @param  string $imageSrc
     *
     * @return string
     */
    private function createImgTag($imageId, $imageSrc)
    {
        return sprintf(self::IMG_TAG, $imageId, $imageSrc);
    }

    /**
     * @param  string $imageId
     * @param  string $content
     *
     * @return string
     */
    private function createATag($imageId, $content)
    {
        return sprintf(self::A_TAG, $imageId, $content);
    }

    /**
     * @param  string $content
     *
     * @return string
     */
    private function createDivTag($content)
    {
        return sprintf(self::DIV_TAG, $content);
    }
}
