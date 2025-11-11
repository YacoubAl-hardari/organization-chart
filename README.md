# Filament Organization Chart Widget

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yacoubalhaidari/organization-chart.svg?style=flat-square)](https://packagist.org/packages/yacoubalhaidari/organization-chart)
[![Total Downloads](https://img.shields.io/packagist/dt/yacoubalhaidari/organization-chart.svg?style=flat-square)](https://packagist.org/packages/yacoubalhaidari/organization-chart)
[![License](https://img.shields.io/packagist/l/yacoubalhaidari/organization-chart.svg?style=flat-square)](https://packagist.org/packages/yacoubalhaidari/organization-chart)

A powerful and elegant Filament widget plugin for creating interactive organizational charts. Built on top of Highcharts, this package provides a fluent API for visualizing your company's hierarchy with style.

![Organization Chart Demo](https://via.placeholder.com/800x400/1e293b/ffffff?text=Interactive+Organization+Chart)

## ✨ Features
- 🎨 **Beautiful & Interactive** - Smooth, responsive charts with hover effects and animations
- 🏗️ **Fluent Builder API** - Intuitive, chainable methods for building complex hierarchies
- 👤 **Employee Profiles** - Support for profile images, titles, and custom styling
- 🎯 **Fully Customizable** - Control colors, layout, height, and orientation
- 📱 **Responsive Design** - Works seamlessly on desktop, tablet, and mobile
- 🌍 **Multi-language** - Built-in support for English and Arabic (easily extensible)
- ✅ **Smart Validation** - Automatic error checking and helpful debugging tools
- 🚀 **Database Ready** - Easily integrate with Eloquent models
- 🎨 **Artisan Command** - Quick scaffold widgets with `make:organization-chart`

---

## 📋 Table of Contents

- [Requirements](#-requirements)
- [Installation](#-installation)
- [Quick Start](#-quick-start)
- [Usage Examples](#-usage-examples)
- [API Reference](#-api-reference)
- [Customization](#-customization)
- [Building from Source](#-building-from-source)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🔧 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.x or 11.x or 12.x
- **Filament**: 3.x or 4.x
- **Composer**: 2.x

---

## 📦 Installation

### Step 1: Install via Composer

```bash
composer require yacoubalhaidari/organization-chart
```

### Step 2: Publish Assets

The package assets are automatically published during installation. If needed, you can republish them:

```bash
php artisan filament:assets
```

### Step 3: Create Your First Widget

Use the artisan command to scaffold a new organization chart widget:

```bash
php artisan make:organization-chart CompanyOrgChart
```

This creates a ready-to-use widget at `app/Filament/Widgets/CompanyOrgChartWidget.php`.

### Step 4: Register the Widget

Add the widget to your Filament Panel Provider (e.g., `app/Providers/Filament/AdminPanelProvider.php`):

```php
use App\Filament\Widgets\CompanyOrgChartWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->widgets([
            CompanyOrgChartWidget::class,
        ]);
}
```

That's it! 🎉 Visit your Filament dashboard to see your organization chart.

---

## 🚀 Quick Start

### Using the Artisan Command (Recommended)

Generate a widget with pre-configured examples:

```bash
php artisan make:organization-chart MyCompany
```

This creates a widget with:

- 4 executive-level positions (CEO, CTO, CFO, COO)
- Profile images and custom colors
- Commented examples for departments and teams
- Best practices and proper structure

### Manual Widget Creation

Alternatively, create a widget manually:

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
            ->inverted(true);

        $builder->executiveLevel([
            ['CEO', 'CTO'],
            ['CEO', 'CFO'],
        ]);

        $builder->executiveNodes([
            [
                'id' => 'CEO',
                'title' => 'Chief Executive Officer',
                'name' => 'Your Name',
                'color' => '#6366f1',
            ],
            [
                'id' => 'CTO',
                'title' => 'Chief Technology Officer',
                'name' => 'Tech Director',
                'color' => '#3b82f6',
            ],
            [
                'id' => 'CFO',
                'title' => 'Chief Financial Officer',
                'name' => 'Finance Director',
                'color' => '#10b981',
            ],
        ]);

        $this->builder($builder);
    }
}
```

---

## 💡 Usage Examples

### Example 1: Simple Hierarchy

```php
public function mount(): void
{
    $builder = OrganizationChartBuilder::make()
        ->title('Our Company')
        ->height(600)
        ->inverted(true)

        ->executiveLevel([
            ['CEO', 'CTO'],
            ['CEO', 'CFO'],
            ['CEO', 'COO'],
        ])

        ->executiveNodes([
            [
                'id' => 'CEO',
                'title' => 'Chief Executive Officer',
                'name' => 'Sarah Johnson',
                'image' => 'https://i.pravatar.cc/150?img=1',
                'color' => '#6366f1',
            ],
            [
                'id' => 'CTO',
                'title' => 'CTO',
                'name' => 'Michael Chen',
                'image' => 'https://i.pravatar.cc/150?img=2',
                'color' => '#3b82f6',
            ],
            [
                'id' => 'CFO',
                'title' => 'CFO',
                'name' => 'Emily Davis',
                'color' => '#10b981',
            ],
            [
                'id' => 'COO',
                'title' => 'COO',
                'name' => 'David Martinez',
                'color' => '#f59e0b',
            ],
        ]);

    $this->builder($builder);
}
```

### Example 2: Multi-Level Organization

```php
public function mount(): void
{
    $builder = OrganizationChartBuilder::make()
        ->title('Complete Organization')
        ->height(800)

        // Executives
        ->executiveLevel([
            ['CEO', 'CTO'],
            ['CEO', 'VP Sales'],
        ])
        ->executiveNodes([
            ['id' => 'CEO', 'name' => 'CEO', 'title' => 'Chief Executive Officer'],
            ['id' => 'CTO', 'name' => 'CTO', 'color' => '#3b82f6'],
            ['id' => 'VP Sales', 'name' => 'VP Sales', 'color' => '#10b981'],
        ])

        // Departments
        ->departments([
            ['CTO', 'Engineering Dept'],
            ['CTO', 'Product Dept'],
            ['VP Sales', 'Sales Dept'],
        ])
        ->departmentNodes([
            ['id' => 'Engineering Dept', 'name' => 'Engineering'],
            ['id' => 'Product Dept', 'name' => 'Product'],
            ['id' => 'Sales Dept', 'name' => 'Sales'],
        ])

        // Teams
        ->teams([
            ['Engineering Dept', 'Frontend Team'],
            ['Engineering Dept', 'Backend Team'],
        ])
        ->teamNodes([
            ['id' => 'Frontend Team', 'name' => 'Frontend'],
            ['id' => 'Backend Team', 'name' => 'Backend'],
        ]);

    $this->builder($builder);
}
```

### Example 3: Database Integration

```php
public function mount(): void
{
    $executives = Employee::where('level', 'executive')
        ->with('manager')
        ->get();

    $builder = OrganizationChartBuilder::make()
        ->title('Company Hierarchy')
        ->height(700)

        ->executiveLevel(
            $executives->map(fn($e) => [
                $e->manager?->name ?? 'Board',
                $e->name
            ])->toArray()
        )

        ->executiveNodes(
            $executives->map(fn($e) => [
                'id' => $e->name,
                'title' => $e->job_title,
                'name' => $e->full_name,
                'image' => $e->avatar_url,
                'color' => $e->department_color,
            ])->toArray()
        );

    $this->builder($builder);
}
```

### Example 4: Horizontal Layout

```php
public function mount(): void
{
    $builder = OrganizationChartBuilder::make()
        ->title('Horizontal Organization')
        ->height(500)
        ->inverted(false) // Horizontal layout

        ->executiveLevel([
            ['Board', 'President'],
            ['President', 'VP Operations'],
            ['President', 'VP Marketing'],
        ])

        ->executiveNodes([
            ['id' => 'Board', 'name' => 'Board of Directors'],
            ['id' => 'President', 'name' => 'President'],
            ['id' => 'VP Operations', 'name' => 'VP Operations'],
            ['id' => 'VP Marketing', 'name' => 'VP Marketing'],
        ]);

    $this->builder($builder);
}
```

---

## 📚 API Reference

### Artisan Commands

| Command                   | Description           | Example                                            |
| ------------------------- | --------------------- | -------------------------------------------------- |
| `make:organization-chart` | Generate a new widget | `php artisan make:organization-chart CompanyChart` |

**Command Usage:**

```bash
# Create a widget named CompanyOrgChartWidget
php artisan make:organization-chart CompanyOrgChart

# Create a widget named TeamStructureWidget
php artisan make:organization-chart TeamStructure

# Widget suffix is added automatically
php artisan make:organization-chart Sales  # Creates SalesWidget.php
```

### Builder Methods

#### Configuration Methods

| Method       | Parameters       | Default                | Description                           |
| ------------ | ---------------- | ---------------------- | ------------------------------------- |
| `title()`    | `string $title`  | `'Organization Chart'` | Set chart title                       |
| `height()`   | `int $pixels`    | `700`                  | Set height in pixels                  |
| `inverted()` | `bool $inverted` | `true`                 | Vertical (true) or horizontal (false) |

**Example:**

```php
$builder->title('My Company')
    ->height(800)
    ->inverted(true);
```

#### Hierarchy Definition Methods

| Method                                 | Description                     | Returns |
| -------------------------------------- | ------------------------------- | ------- |
| `executiveLevel(array $relationships)` | Define top-level relationships  | `self`  |
| `departments(array $relationships)`    | Define department relationships | `self`  |
| `teams(array $relationships)`          | Define team relationships       | `self`  |

**Relationship Format:** `[['parentId', 'childId'], ...]`

**Example:**

```php
$builder->executiveLevel([
    ['CEO', 'CTO'],
    ['CEO', 'CFO'],
])
->departments([
    ['CTO', 'Engineering Dept'],
    ['CFO', 'Finance Dept'],
]);
```

#### Node Definition Methods

| Method                          | Description               | Level      |
| ------------------------------- | ------------------------- | ---------- |
| `executiveNodes(array $nodes)`  | Define executive details  | Executive  |
| `departmentNodes(array $nodes)` | Define department details | Department |
| `teamNodes(array $nodes)`       | Define team details       | Team       |
| `nodes(array $nodes)`           | Define all nodes at once  | All        |

**Node Properties:**

| Property | Type     | Required | Description       | Example                           |
| -------- | -------- | -------- | ----------------- | --------------------------------- |
| `id`     | `string` | ✅ Yes   | Unique identifier | `'CEO'`                           |
| `name`   | `string` | ✅ Yes   | Display name      | `'John Smith'`                    |
| `title`  | `string` | No       | Job title         | `'Chief Executive Officer'`       |
| `image`  | `string` | No       | Profile photo URL | `'https://example.com/photo.jpg'` |
| `color`  | `string` | No       | Hex color         | `'#3b82f6'`                       |
| `column` | `int`    | No       | Column position   | `0`, `1`, `2`                     |

**Example:**

```php
$builder->executiveNodes([
    [
        'id' => 'CEO',
        'name' => 'John Smith',
        'title' => 'Chief Executive Officer',
        'image' => 'https://example.com/ceo.jpg',
        'color' => '#6366f1',
    ],
]);
```

#### Validation Methods

| Method                | Returns | Description          |
| --------------------- | ------- | -------------------- |
| `validate()`          | `array` | Check for errors     |
| `getMissingNodes()`   | `array` | Get missing node IDs |
| `getAllRequiredIds()` | `array` | Get all required IDs |
| `getSummary()`        | `array` | Get statistics       |

**Example:**

```php
$builder = OrganizationChartBuilder::make()
    ->executiveLevel([['CEO', 'CTO']])
    ->executiveNodes([
        ['id' => 'CEO', 'name' => 'CEO'],
    ]);

$validation = $builder->validate();
// Returns: ['valid' => false, 'errors' => ['Missing node: CTO']]

$missing = $builder->getMissingNodes();
// Returns: ['CTO']
```

---

## 🎨 Customization

### Widget Views

Use the alternative view without description:

```php
protected string $view = 'organization-chart::widget-without-description';
```

### Custom Colors

```php
->executiveNodes([
    ['id' => 'CEO', 'name' => 'CEO', 'color' => '#6366f1'], // Indigo
    ['id' => 'CTO', 'name' => 'CTO', 'color' => '#3b82f6'], // Blue
    ['id' => 'CFO', 'name' => 'CFO', 'color' => '#10b981'], // Green
])
```

### Profile Images

```php
->executiveNodes([
    [
        'id' => 'CEO',
        'name' => 'Sarah Johnson',
        'image' => asset('storage/avatars/ceo.jpg'),
    ],
])
```

### Translations

Publish and customize translation files:

```bash
php artisan vendor:publish --tag=organization-chart-translations
```

Edit in:

- `lang/vendor/organization-chart/en/widget.php` (English)
- `lang/vendor/organization-chart/ar/widget.php` (Arabic)

### Widget Column Span

Control widget width:

```php
class CompanyOrgChart extends OrganizationChartWidget
{
    protected int | string | array $columnSpan = 'full'; // Full width

    // Or specific spans:
    // protected int | string | array $columnSpan = 2;
}
```

---

## 🛠️ Building from Source

If you're contributing or want to build assets from source:

### Prerequisites

- Node.js 16.x or higher
- NPM 8.x or higher

### Build Steps

```bash
# Navigate to package directory
cd packages/organization-chart

# Install dependencies
npm install

# Build assets (production)
npm run build

# Or watch for changes (development)
npm run dev
```

### Build Commands

| Command             | Description                     |
| ------------------- | ------------------------------- |
| `npm run build`     | Build CSS and JS for production |
| `npm run build:css` | Build CSS only                  |
| `npm run build:js`  | Build JS only                   |
| `npm run dev`       | Same as build (no watch mode)   |

### After Building

Publish the updated assets to your Filament application:

```bash
# From your Laravel project root
php artisan filament:assets
```

### Project Structure

```
packages/organization-chart/
├── src/
│   ├── Commands/
│   │   └── MakeOrganizationChartCommand.php
│   ├── OrganizationChartServiceProvider.php
│   ├── OrganizationChartWidget.php
│   └── OrganizationChartBuilder.php
├── resources/
│   ├── js/
│   │   └── organization-chart.js         # Source JavaScript
│   ├── css/
│   │   └── organization-chart.css        # Source CSS
│   ├── dist/                             # Compiled assets
│   │   ├── organization-chart.js
│   │   └── organization-chart.css
│   ├── views/
│   │   ├── widget.blade.php
│   │   └── widget-without-description.blade.php
│   └── lang/
│       ├── en/widget.php
│       └── ar/widget.php
├── composer.json
├── package.json
├── build.js                              # esbuild configuration
├── postcss.config.js                     # PostCSS configuration
└── README.md
```

---

## 🐛 Troubleshooting

### Chart Not Displaying

**Problem:** Widget shows but chart is blank.

**Solutions:**

1. Clear cache: `php artisan optimize:clear`
2. Republish assets: `php artisan filament:assets`
3. Check browser console for JavaScript errors
4. Verify Highcharts is loaded

### Missing Nodes Error

**Problem:** Relationships reference undefined IDs.

**Solution:** Use validation to find issues:

```php
$missing = $builder->getMissingNodes();
// Returns array of missing node IDs
```

### Assets Not Loading

**Problem:** Styles or JavaScript not working.

**Solutions:**

1. Re-publish: `php artisan filament:assets --force`
2. Clear browser cache (Ctrl+F5)
3. Check public directory permissions
4. Verify assets exist in `public/js/yacoubalhaidari/` and `public/css/yacoubalhaidari/`

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

### Development Setup

1. Fork the repository
2. Clone your fork
3. Install dependencies: `composer install && npm install`
4. Make your changes
5. Build assets: `npm run build`
6. Test your changes
7. Submit a pull request

### Guidelines

- Follow PSR-12 coding standards
- Write clear commit messages
- Add tests for new features
- Update documentation as needed
- Ensure assets build without errors

### Reporting Issues

Please open an issue on GitHub with:

- Clear description of the problem
- Steps to reproduce
- Expected vs actual behavior
- Environment details (PHP, Laravel, Filament versions)

---

## 📄 License

This package is open-sourced software licensed under the [MIT License](LICENSE).

---

## 👤 Author

**Yacoub Al-haidari**

- Email: yacoub@yacoubalhaidari.com
- GitHub: [@yacoubalhaidari](https://github.com/yacoubalhaidari)

---

## 🙏 Credits

**Built With:**

- [Filament](https://filamentphp.com/) - The elegant admin panel framework
- [Highcharts](https://www.highcharts.com/) - Interactive charting library
- [Laravel](https://laravel.com/) - The PHP framework for web artisans

---

## 🔗 Links

- [Packagist](https://packagist.org/packages/yacoubalhaidari/organization-chart)
- [GitHub Repository](https://github.com/yacoubalhaidari/organization-chart)
- [Filament Documentation](https://filamentphp.com/docs)
- [Highcharts Org Chart Docs](https://www.highcharts.com/docs/chart-and-series-types/organization-chart)

---

## ⭐ Support

If you find this package helpful, please consider:

- ⭐ Starring the repository
- 🐛 Reporting issues
- 💡 Suggesting new features
- 📖 Improving documentation
- 🔀 Contributing code

---

**Made with ❤️ for the Filament community**
