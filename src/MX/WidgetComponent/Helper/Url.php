<?php

namespace MX\WidgetComponent\Helper;

use Magento\Store\Model\StoreManagerInterface;

class Url
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param  string $urlData
     *
     * @return string
     */
    public function renderUrl($urlData)
    {
        return str_replace('%store_url%', $this->getBaseUrl(), $urlData);
    }

    /**
     * @return string
     */
    private function getBaseUrl()
    {
        return rtrim($this->storeManager->getStore()->getBaseUrl(), '/');
    }
}
