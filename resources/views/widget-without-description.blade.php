@php
    $chartConfig = $this->getChartConfig();
    $uniqueId = 'org-chart-' . uniqid();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .organization-chart-container {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                min-height: 400px;
            }

            .highcharts-figure {
                min-width: 360px;
                max-width: 100%;
                margin: 1em auto;
            }

            @media screen and (max-width: 600px) {
                .organization-chart-container h4 {
                    font-size: 2.3vw;
                    line-height: 3vw;
                }

                .organization-chart-container p {
                    font-size: 2.3vw;
                    line-height: 3vw;
                }
            }
        </style>

        <div x-data="organizationChart(@js($chartConfig), '{{ $uniqueId }}')" x-load="organizationChart"
            x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('organization-chart', 'yacoubalhaidari/organization-chart') }}"
            class="organization-chart-container" wire:ignore>
            <figure class="highcharts-figure">
                <div id="{{ $uniqueId }}" style="min-height: 400px;"></div>
            </figure>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
