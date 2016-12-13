<?php

namespace MX\WidgetComponent\Form\Component\ImagePicker\Image;

use MX\WidgetComponent\Helper\Image as ImageHelper;
use Magento\Cms\Helper\Wysiwyg\Images as CmsImageHelper;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;

class Preview extends AbstractElement
{
    const DIV_TAG = '<div style="float: left; margin-right: 10px" data-mage-init=\'{"MXWidgetComponentImagePicker":{%scriptData%}}\'>%s</div>';
    const A_TAG = '<a href="javascript:void(0)" onclick="imagePreview(\'%s\')">%s</a>';
    const IMG_TAG = '<img id="%s" src="%s" height="36" width="36" class="v-middle"/>';

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var CmsImageHelper
     */
    protected $cmsImageHelper;

    /**
     * @param Factory           $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper           $escaper
     * @param ImageHelper       $imageHelper
     * @param CmsImageHelper    $cmsImageHelper
     * @param array             $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        ImageHelper $imageHelper,
        CmsImageHelper $cmsImageHelper,
        $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->cmsImageHelper = $cmsImageHelper;
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
        // replace data-mage-init
        $div = str_replace(
            '%scriptData%',
            '"baseMediaUrl": "' . $this->cmsImageHelper->getBaseUrl() . '"}}\'',
            self::DIV_TAG
        );

        return sprintf($div, $content);
    }
}
