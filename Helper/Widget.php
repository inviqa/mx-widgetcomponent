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
     * @param  string $widgetDataYaml
     *
     * @return string
     */
    public function renderWidget($widgetDataYaml)
    {
        if (empty($widgetDataYaml) || !is_string($widgetDataYaml)) {
            return $widgetDataYaml;
        }

        return $this->widgetRenderer->filter($this->generateWidgetDeclaration($this->parseYaml($widgetDataYaml)));
    }

    /**
     * @param  string $yamlData
     *
     * @return array
     */
    private function parseYaml($yamlData)
    {
        $widgetData = [];

        $data = Yaml::parse($yamlData);

        $widgetData['type'] = $data['widget_type'];
        $widgetData['parameters'] = $data;
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
