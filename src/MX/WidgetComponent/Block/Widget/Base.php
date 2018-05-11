<?php

namespace MX\WidgetComponent\Block\Widget;

use Magento\Framework\App\ObjectManager;
use MX\WidgetComponent\Helper\Image as ImageHelper;
use MX\WidgetComponent\Helper\Media as MediaHelper;
use MX\WidgetComponent\Helper\Url as UrlHelper;
use MX\WidgetComponent\Helper\Widget as WidgetHelper;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;

class Base extends Template implements BlockInterface
{
    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var MediaHelper
     */
    private $mediaHelper;
    
    /**
     * @var WidgetHelper
     */
    private $widgetHelper;
    
    /**
     * @param Context      $context
     * @param UrlHelper    $urlHelper
     * @param ImageHelper  $imageHelper
     * @param WidgetHelper $widgetHelper
     * @param array        $data
     * @param MediaHelper  $mediaHelper
     */
    public function __construct(
        Context $context,
        UrlHelper $urlHelper,
        ImageHelper $imageHelper,
        WidgetHelper $widgetHelper,
        array $data = [],
        MediaHelper $mediaHelper = null
    ) {
        $this->urlHelper = $urlHelper;
        $this->mediaHelper = $mediaHelper;
        $this->widgetHelper = $widgetHelper;
        if (is_null($mediaHelper)) {
            $this->mediaHelper = ObjectManager::getInstance()->get(MediaHelper::class);
        }
        parent::__construct($context, $data);
    }

    /**
     * @param  string $urlData
     *
     * @return string
     */
    protected function renderUrl($urlData)
    {
        return $this->urlHelper->renderUrl($urlData);
    }

    /**
     * @param  string $imagePath
     *
     * @return string
     */
    protected function renderImageUrl($imagePath)
    {
        return $this->mediaHelper->getMediaUrl($imagePath);
    }

    /**
     * @param  string $videoPath
     *
     * @return string
     */
    protected function renderVideoUrl($videoPath)
    {
        return $this->mediaHelper->getMediaUrl($videoPath);
    }

    /**
     * @param  string $widgetData
     *
     * @return string
     */
    protected function renderWidget($widgetData)
    {
        return $this->widgetHelper->renderWidget($widgetData);
    }
}
