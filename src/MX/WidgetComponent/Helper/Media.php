<?php

namespace MX\WidgetComponent\Helper;

use Magento\Catalog\Helper\Data as DataHelper;
use Magento\Framework\Filter\Template;

class Media
{
    /**
     * @var Template
     */
    private $templateProcessor;

    /**
     * @param DataHelper $catalogHelper
     */
    public function __construct(DataHelper $catalogHelper)
    {
        $this->templateProcessor = $catalogHelper->getPageTemplateProcessor();
    }

    /**
     * @param  string $mediaPath
     *
     * @return string
     */
    public function getMediaUrl($mediaPath)
    {
        if (empty($mediaPath) || $this->isUrl($mediaPath)) {
            return $mediaPath;
        }

        return $this->templateProcessor->filter(sprintf("{{media url='%s'}}", $mediaPath));
    }

    /**
     * @param  string  $mediaPath
     *
     * @return boolean
     */
    private function isUrl($mediaPath)
    {
        return strpos($mediaPath, 'http') === 0;
    }
}
