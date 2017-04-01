<?php

namespace MX\WidgetComponent\Helper;

use Magento\Widget\Model\Widget as WidgetDeclarationGenerator;
use Magento\Widget\Model\Template\Filter as WidgetRenderer;
use Symfony\Component\Yaml\Yaml;

class Widget
{
    /**
     * @var WidgetDeclarationGenerator
     */
    private $widgetDeclarationGenerator;
    
    /**
     * @var WidgetRenderer
     */
    private $widgetRenderer;

    /**
     * @param WidgetDeclarationGenerator $widget
     * @param WidgetRenderer $widgetRenderer
     */
    public function __construct(
        WidgetDeclarationGenerator $widgetDeclarationGenerator,
        WidgetRenderer $widgetRenderer
    ) {
        $this->widgetDeclarationGenerator = $widgetDeclarationGenerator;
        $this->widgetRenderer = $widgetRenderer;
    }

    /**
     * @param string $widgetDataYaml
     * @param array  $additionalData
     *
     * @return string
     */
    public function renderWidget($widgetDataYaml, array $additionalData = [])
    {
        if (empty($widgetDataYaml) || !is_string($widgetDataYaml)) {
            return $widgetDataYaml;
        }

        $widgetData = $this->parseYaml($widgetDataYaml, $additionalData);

        return $this->widgetRenderer->filter($this->generateWidgetDeclaration($widgetData));
    }

    /**
     * @param string $yamlData
     * @param array  $additionalData
     *
     * @return array
     */
    private function parseYaml($yamlData, array $additionalData)
    {
        $widgetData = [];

        $data = Yaml::parse($yamlData);

        $widgetData['type'] = $data['widget_type'];
        $widgetData['parameters'] = array_merge($data, $additionalData);

        unset($widgetData['parameters']['widget_type']);

        return $widgetData;
    }

    /**
     * @param  array  $widgetData
     *
     * @return string
     */
    private function generateWidgetDeclaration(array $widgetData)
    {
        return $this->widgetDeclarationGenerator->getWidgetDeclaration(
            $widgetData['type'],
            $widgetData['parameters'],
            true
        );
    }
}
