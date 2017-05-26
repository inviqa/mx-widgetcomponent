<?php

namespace MX\WidgetComponent\Controller\Adminhtml\SubWidget;

use Magento\Backend\App\Action;
use Symfony\Component\Yaml\Yaml;

class OnInsert extends Action
{
    protected $_publicActions = ['onInsert'];

    public function execute()
    {
        $params = $this->getRequest()->getPost('parameters', []);

        $this->getResponse()->setBody(Yaml::dump($params, 0, 1));
    }
}
