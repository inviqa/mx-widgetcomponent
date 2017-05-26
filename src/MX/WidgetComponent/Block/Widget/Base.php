<?php

namespace MX\WidgetComponent\Block\Widget;

use MX\WidgetComponent\Helper\Image as ImageHelper;
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
     * @var ImageHelper
     */
    private $imageHelper;
    
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
     */
    public function __construct(
        Context $context,
        UrlHelper $urlHelper,
        ImageHelper $imageHelper,
        WidgetHelper $widgetHelper,
        array $data = []
    ) {
        $this->urlHelper = $urlHelper;
        $this->imageHelper = $imageHelper;
        $this->widgetHelper = $widgetHelper;
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
        return $this->imageHelper->getImageUrl($imagePath);
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
