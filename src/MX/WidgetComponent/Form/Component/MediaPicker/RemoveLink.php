<?php

namespace MX\WidgetComponent\Form\Component\MediaPicker;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;

class RemoveLink extends AbstractElement
{
    const DIV_TAG = '<div style="margin-top: 10px">%s</div>';
    const A_TAG = '<a href="javascript:void(0)" class="remove-media" data-target="%s" style="display:none">Remove media</a>';

    /**
     * @param Factory           $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper           $escaper
     * @param array             $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        $data = []
    ) {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('link');
    }

    /**
     * Return element html code
     *
     * @return string
     */
    public function getElementHtml()
    {
        $inputId = $this->getHtmlId();

        return $this->createDivTag($this->createATag($inputId));
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function createATag($id)
    {
        return sprintf(self::A_TAG, $id);
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
