@php
    $chartConfig = $this->getChartConfig();
    $uniqueId = 'org-chart-' . md5(json_encode($chartConfig));
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div x-data="organizationChart(@js($chartConfig), @js($uniqueId))" x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('organization-chart', package: 'yacoubalhaidari/organization-chart'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('organization-chart', package: 'yacoubalhaidari/organization-chart'))]"
            class="organization-chart-container">
            <div :id="containerId" class="organization-chart"></div>
            <p class="organization-chart-description">
                {{ __('organization-chart::widget.description') }}
            </p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
