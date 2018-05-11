<?php

namespace MX\WidgetComponent\Form\Component\MediaPicker\Video;

use MX\WidgetComponent\Helper\Media as MediaHelper;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;
use Magento\Framework\View\Asset\Repository;

class Preview extends AbstractElement
{
    const DIV_TAG = '<div style="float: left; margin-right: 10px">%s</div>';
    const A_TAG = '<a href="javascript:void(0)" class="preview-video" data-video-src="%s">%s</a>';
    const IMG_TAG = '<img id="%s" src="%s" width="36" height="23" class="v-middle" data-img-src="%s" />';

    /**
     * @var Repository
     */
    protected $assetRepo;

    /**
     * @var MediaHelper
     */
    protected $mediaHelper;

    /**
     * @param Factory           $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper           $escaper
     * @param MediaHelper       $mediaHelper
     * @param array             $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        MediaHelper $mediaHelper,
        Repository $assetRepo,
        $data = []
    ) {
        $this->mediaHelper = $mediaHelper;
        $this->assetRepo = $assetRepo;
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
        $videoId = $this->getHtmlId();
        $videoUrl = $this->getVideoUrl();
        $imageUrl = $this->assetRepo->getUrl($this->getSrc());

        return $this->createDivTag($this->createATag($videoUrl, $this->createImageTag($videoId, $imageUrl)));
    }

    /**
     * @return string
     */
    private function getVideoUrl()
    {
        return $this->mediaHelper->getMediaUrl($this->getValue());
    }

    /**
     * @param  string $videoId
     * @param  string $imageUrl
     *
     * @return string
     */
    private function createImageTag($videoId, $imageUrl)
    {
        return sprintf(self::IMG_TAG, $videoId, $imageUrl, $imageUrl);
    }

    /**
     * @param  string $content
     * @param  string $videoUrl
     *
     * @return string
     */
    private function createATag($videoUrl, $content)
    {
        return sprintf(self::A_TAG, $videoUrl, $content);
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
