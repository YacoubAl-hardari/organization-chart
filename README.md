# Organization Chart Plugin for Filament

A powerful Filament widget plugin for creating interactive organizational charts using Highcharts.

## Features

-   Interactive hierarchical organization charts
-   Customizable colors and styling
-   Support for employee images
-   Fully responsive design
-   Easy-to-use Fluent Builder API
-   Validation and error checking
-   Multi-language support (English & Arabic included)

## Installation

### Step 1: Add to Composer

Since this is a local package, add it to your main project's `composer.json`:

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

### Step 2: Install Dependencies

```bash
composer update yacoubalhaidari/organization-chart
```

### Step 3: Build Plugin Assets

Navigate to the plugin directory and build the JavaScript/CSS assets:

```bash
cd packages/organization-chart
npm install
npm run build
cd ../..
```

### Step 4: Publish Assets

```bash
php artisan filament:assets
```

## Usage

### Quick Start

Register the widget in your Filament Panel Provider (e.g., `app/Providers/Filament/AdminPanelProvider.php`):

```php
use YacoubAlhaidari\OrganizationChart\OrganizationChartWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->widgets([
            OrganizationChartWidget::class,
        ]);
}
```

### Custom Widget with Builder API (Recommended)

Create a custom widget class:

```php
<?php

namespace App\Filament\Widgets;

use YacoubAlhaidari\OrganizationChart\OrganizationChartWidget;
use YacoubAlhaidari\OrganizationChart\OrganizationChartBuilder;

class CompanyOrgChart extends OrganizationChartWidget
{
    protected string $view = 'organization-chart::widget-without-description';

    public function mount(): void
    {
        $builder = OrganizationChartBuilder::make()
            ->title('Company Structure')
            ->height(700)
            ->inverted(true)

            ->executiveLevel([
                ['Board', 'CEO'],
                ['CEO', 'CTO'],
                ['CEO', 'CFO'],
            ])

            ->executiveNodes([
                ['id' => 'Board', 'name' => 'Board of Directors'],
                [
                    'id' => 'CEO',
                    'title' => 'Chief Executive Officer',
                    'name' => 'Your Name',
                    'image' => 'https://example.com/ceo.jpg',
                ],
                [
                    'id' => 'CTO',
                    'title' => 'CTO',
                    'name' => 'Tech Director',
                    'color' => '#3b82f6',
                ],
                [
                    'id' => 'CFO',
                    'title' => 'CFO',
                    'name' => 'Finance Director',
                    'color' => '#10b981',
                ],
            ])

            ->departments([
                ['CTO', 'Engineering Dept'],
                ['CFO', 'Finance Dept'],
            ])

            ->departmentNodes([
                ['id' => 'Engineering Dept', 'name' => 'Engineering'],
                ['id' => 'Finance Dept', 'name' => 'Finance'],
            ])

            ->teams([
                ['Engineering Dept', 'Frontend Team'],
                ['Engineering Dept', 'Backend Team'],
            ])

            ->teamNodes([
                ['id' => 'Frontend Team', 'name' => 'Frontend Developers'],
                ['id' => 'Backend Team', 'name' => 'Backend Developers'],
            ]);

        $this->builder($builder);
    }
}
```

Then register your custom widget:

```php
->widgets([
    \App\Filament\Widgets\CompanyOrgChart::class,
])
```

## Builder API Reference

### Hierarchy Definition Methods

| Method             | Description                         | Example                                |
| ------------------ | ----------------------------------- | -------------------------------------- |
| `executiveLevel()` | Define top-level executives         | `->executiveLevel([['CEO', 'CTO']])`   |
| `departments()`    | Define departments under executives | `->departments([['CTO', 'Eng Dept']])` |
| `teams()`          | Define teams under departments      | `->teams([['Eng Dept', 'Team']])`      |

### Node Definition Methods (Level-Specific)

| Method              | Description               | Example                                                         |
| ------------------- | ------------------------- | --------------------------------------------------------------- |
| `executiveNodes()`  | Define executive details  | `->executiveNodes([['id' => 'CEO', 'name' => 'John']])`         |
| `departmentNodes()` | Define department details | `->departmentNodes([['id' => 'Eng', 'name' => 'Engineering']])` |
| `teamNodes()`       | Define team details       | `->teamNodes([['id' => 'Team', 'name' => 'Developers']])`       |
| `nodes()`           | Define all nodes at once  | `->nodes([...])`                                                |

### Appearance Methods

| Method       | Description                           | Default              |
| ------------ | ------------------------------------- | -------------------- |
| `title()`    | Set chart title                       | 'Organization Chart' |
| `height()`   | Set height in pixels                  | 700                  |
| `inverted()` | Vertical (true) or horizontal (false) | true                 |

### Helper Methods

| Method                | Description                   | Returns                                |
| --------------------- | ----------------------------- | -------------------------------------- |
| `validate()`          | Check for errors              | `['valid' => bool, 'errors' => array]` |
| `getMissingNodes()`   | Find missing node definitions | `array`                                |
| `getSummary()`        | Get structure statistics      | `array`                                |
| `getAllRequiredIds()` | Get all IDs that need nodes   | `array`                                |

## Node Properties

Each node can have the following properties:

| Property | Required | Description                              |
| -------- | -------- | ---------------------------------------- |
| `id`     | Yes      | Unique identifier matching relationships |
| `name`   | Yes      | Display name                             |
| `title`  | No       | Job title (e.g., "CEO")                  |
| `image`  | No       | URL to profile photo                     |
| `color`  | No       | Hex color (e.g., "#3b82f6")              |
| `column` | No       | Column positioning                       |

## Example: From Database

```php
public function mount(): void
{
    $executives = Employee::where('level', 'executive')->get();

    $builder = OrganizationChartBuilder::make()
        ->executiveLevel(
            $executives->map(fn($e) => [$e->manager->name, $e->name])->toArray()
        )
        ->executiveNodes(
            $executives->map(fn($e) => [
                'id' => $e->name,
                'title' => $e->job_title,
                'name' => $e->full_name,
                'image' => $e->avatar_url,
            ])->toArray()
        );

    $this->builder($builder);
}
```

## Customization

### Hide Description Text

Use the view without description:

```php
protected string $view = 'organization-chart::widget-without-description';
```

### Custom Translations

Publish translations:

```bash
php artisan vendor:publish --tag=organization-chart-translations
```

Edit in `lang/vendor/organization-chart/en/widget.php` or `ar/widget.php`.

## Requirements

-   PHP 8.1+
-   Laravel 10.x or 12.x
-   Filament 3.x or 4.x
-   Node.js & NPM (for building assets)

## Development

### Build Assets

```bash
cd packages/organization-chart
npm run build
```

### Clear Caches

```bash
php artisan optimize:clear
php artisan filament:assets
```

## Structure

```
packages/organization-chart/
├── src/
│   ├── OrganizationChartServiceProvider.php
│   ├── OrganizationChartWidget.php
│   └── OrganizationChartBuilder.php
├── resources/
│   ├── js/organization-chart.js
│   ├── css/organization-chart.css
│   ├── dist/ (compiled assets)
│   ├── views/widget*.blade.php
│   └── lang/
│       ├── en/widget.php
│       └── ar/widget.php
├── composer.json
├── package.json
└── README.md
```

## Credits

-   Built by [Yacoub Al-haidari](mailto:yacoub@yacoubalhaidari.com)
-   Powered by [Highcharts](https://www.highcharts.com/)
-   Built for [Filament](https://filamentphp.com/)

## License

MIT License

## Support

For issues or questions:

-   Check [Filament Documentation](https://filamentphp.com/docs)
-   Review [Highcharts Org Chart Docs](https://www.highcharts.com/docs/chart-and-series-types/organization-chart)
