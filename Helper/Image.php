<?php

namespace MX\WidgetComponent\Helper;

use Magento\Catalog\Helper\Data as DataHelper;
use Magento\Framework\Filter\Template;

class Image
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
     * @param  string $imagePath
     *
     * @return string
     */
    public function getImageUrl($imagePath)
    {
        if (empty($imagePath) || $this->isUrl($imagePath)) {
            return $imagePath;
        }

        return $this->templateProcessor->filter(sprintf("{{media url='%s'}}", $imagePath));
    }

    /**
     * @param  string  $imagePath
     *
     * @return boolean
     */
    private function isUrl($imagePath)
    {
        return strpos($imagePath, 'http') === 0;
    }
}
