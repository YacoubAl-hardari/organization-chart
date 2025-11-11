<?php

namespace YacoubAlhaidari\OrganizationChart;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OrganizationChartServiceProvider extends PackageServiceProvider
{
    public static string $name = 'organization-chart';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Livewire::component('organization-chart-widget', OrganizationChartWidget::class);

        FilamentAsset::register([
            AlpineComponent::make('organization-chart', __DIR__ . '/../resources/dist/organization-chart.js'),
            Css::make('organization-chart-styles', __DIR__ . '/../resources/dist/organization-chart.css')
                ->loadedOnRequest(),
        ], package: 'yacoubalhaidari/organization-chart');
    }
}
