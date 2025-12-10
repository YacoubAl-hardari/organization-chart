<?php

namespace YacoubAlhaidari\OrganizationChart;

use Filament\Widgets\Widget;

class OrganizationChartWidget extends Widget
{
    protected static string $view = 'organization-chart::widget';
    protected int | string | array $columnSpan = 'full';
    protected ?OrganizationChartBuilder $builder = null;
    protected array $chartData = [];
    protected array $chartNodes = [];
    protected int $chartHeight = 600;
    protected bool $inverted = true;
    protected string $chartTitle = 'Organization Chart';

    public function builder(OrganizationChartBuilder $builder): static
    {
        $this->builder = $builder;
        return $this;
    }

    public function getChartData(): array
    {
        if ($this->builder) {
            return $this->builder->getChartData();
        }
        
        return $this->chartData;
    }

    public function getChartNodes(): array
    {
        if ($this->builder) {
            return $this->builder->getChartNodes();
        }
        
        return $this->chartNodes;
    }

    public function getChartConfig(): array
    {
        if ($this->builder) {
            return [
                'height' => $this->builder->getHeight(),
                'inverted' => $this->builder->getInverted(),
                'title' => $this->builder->getTitle(),
                'data' => $this->builder->getChartData(),
                'nodes' => $this->builder->getChartNodes(),
            ];
        }
        
        return [
            'height' => $this->chartHeight,
            'inverted' => $this->inverted,
            'title' => $this->chartTitle,
            'data' => $this->getChartData(),
            'nodes' => $this->getChartNodes(),
        ];
    }

    public function chartData(array $data): static
    {
        $this->chartData = $data;
        return $this;
    }

    public function chartNodes(array $nodes): static
    {
        $this->chartNodes = $nodes;
        return $this;
    }

    public function chartTitle(string $title): static
    {
        $this->chartTitle = $title;
        return $this;
    }

    public function chartHeight(int $height): static
    {
        $this->chartHeight = $height;
        return $this;
    }

    public function inverted(bool $inverted = true): static
    {
        $this->inverted = $inverted;
        return $this;
    }

    public function columnSpan(int | string | array $span): static
    {
        $this->columnSpan = $span;
        return $this;
    }
}
