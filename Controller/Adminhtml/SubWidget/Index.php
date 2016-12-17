<?php

namespace MX\WidgetComponent\Controller\Adminhtml\SubWidget;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class Index extends Action
{
    protected $_publicActions = ['index'];

    /**
     * @var LayoutFactory
     */
    private $resultLayoutFactory;

    /**
     * @param Context           $context
     * @param LayoutFactory     $resultLayoutFactory
     */
    public function __construct(
        Context $context,
        LayoutFactory $resultLayoutFactory
    ) {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();

        return $resultLayout;
    }
}
