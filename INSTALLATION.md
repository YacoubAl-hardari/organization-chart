# Organization Chart Plugin - Installation & Setup Guide

## Quick Installation

### 1. Add to Composer

In your main `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/organization-chart",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "yacoubalhaidari/organization-chart": "@dev"
    }
}
```

### 2. Install Package

```bash
composer update yacoubalhaidari/organization-chart
```

### 3. Build Assets

```bash
cd packages/organization-chart
npm install
npm run build
cd ../..
php artisan filament:assets
```

### 4. Create Your Widget

```bash
php artisan make:filament-widget CompanyChart
```

### 5. Configure Widget

Edit `app/Filament/Widgets/CompanyChart.php`:

```php
<?php

namespace App\Filament\Widgets;

use YacoubAlhaidari\OrganizationChart\OrganizationChartWidget;
use YacoubAlhaidari\OrganizationChart\OrganizationChartBuilder;

class CompanyChart extends OrganizationChartWidget
{
    protected string $view = 'organization-chart::widget-without-description';

    public function mount(): void
    {
        $builder = OrganizationChartBuilder::make()
            ->title('Company Structure')
            ->height(700)

            ->executiveLevel([
                ['CEO', 'CTO'],
                ['CEO', 'CFO'],
            ])

            ->executiveNodes([
                ['id' => 'CEO', 'name' => 'Your Name', 'title' => 'CEO'],
                ['id' => 'CTO', 'name' => 'Tech Lead', 'color' => '#3b82f6'],
                ['id' => 'CFO', 'name' => 'Finance Lead', 'color' => '#10b981'],
            ])

            ->departments([
                ['CTO', 'Engineering'],
                ['CFO', 'Finance'],
            ])

            ->departmentNodes([
                ['id' => 'Engineering', 'name' => 'Engineering Dept'],
                ['id' => 'Finance', 'name' => 'Finance Dept'],
            ])

            ->teams([
                ['Engineering', 'Frontend'],
                ['Engineering', 'Backend'],
            ])

            ->teamNodes([
                ['id' => 'Frontend', 'name' => 'Frontend Team'],
                ['id' => 'Backend', 'name' => 'Backend Team'],
            ]);

        $this->builder($builder);
    }
}
```

### 6. Register in Panel

Edit `app/Providers/Filament/AdminPanelProvider.php`:

```php
->widgets([
    \App\Filament\Widgets\CompanyChart::class,
])
```

## Done!

Visit your Filament admin panel and see your organization chart in action!

## Troubleshooting

### Chart not showing?

-   Clear caches: `php artisan optimize:clear`
-   Rebuild assets: `php artisan filament:assets`
-   Check browser console for errors

### Missing nodes error?

-   Use `$builder->validate()` to find missing nodes
-   Ensure all IDs in relationships have matching nodes

### Need help?

-   Check `README.md` for full documentation
-   Review example in `app/Filament/Widgets/FluentOrgChart.php`
