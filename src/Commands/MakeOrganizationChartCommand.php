<?php

namespace YacoubAlhaidari\OrganizationChart\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeOrganizationChartCommand extends Command
{
    protected $signature = 'make:organization-chart {name : The name of the widget class}';

    protected $description = 'Create a new organization chart widget';

    public function handle(): int
    {
        $name = $this->argument('name');
        $className = Str::studly($name);
        
        // Ensure it ends with 'Widget' if not already included
        if (!Str::endsWith($className, 'Widget')) {
            $className .= 'Widget';
        }

        $path = app_path("Filament/Widgets/{$className}.php");

        // Check if file already exists
        if (file_exists($path)) {
            $this->error("Widget [{$className}] already exists!");
            return self::FAILURE;
        }

        // Create directory if it doesn't exist
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // Generate the widget content
        $content = $this->getStubContent($className);

        // Write the file
        file_put_contents($path, $content);

        $this->info("Organization Chart Widget [{$className}] created successfully!");
        $this->newLine();
        $this->info("Location: {$path}");
        $this->newLine();
        $this->comment("Don't forget to register your widget in your Panel Provider:");
        $this->line("  ->widgets([");
        $this->line("      \\App\\Filament\\Widgets\\{$className}::class,");
        $this->line("  ])");

        return self::SUCCESS;
    }

    protected function getStubContent(string $className): string
    {
        return <<<PHP
<?php

namespace App\Filament\Widgets;

use YacoubAlhaidari\OrganizationChart\OrganizationChartWidget;
use YacoubAlhaidari\OrganizationChart\OrganizationChartBuilder;

class {$className} extends OrganizationChartWidget
{
    protected static string \$view = 'organization-chart::widget-without-description';
    
    public function mount(): void
    {
        \$builder = OrganizationChartBuilder::make()
            ->title('Organization Chart')
            ->height(700)
            ->inverted(true);
        
        // Define executive level relationships
        \$builder->executiveLevel([
            ['CEO', 'CTO'],
            ['CEO', 'CFO'],
            ['CEO', 'COO'],
        ]);
        
        // Define executive nodes with details
        \$builder->executiveNodes([
            [
                'id' => 'CEO',
                'title' => 'Chief Executive Officer',
                'name' => 'Your Name',
                'color' => '#6366f1',
                'image' => 'https://ui-avatars.com/api/?name=CEO&size=128',
            ],
            [
                'id' => 'CTO',
                'title' => 'Chief Technology Officer',
                'name' => 'Tech Director',
                'color' => '#3b82f6',
                'image' => 'https://ui-avatars.com/api/?name=CTO&size=128',
            ],
            [
                'id' => 'CFO',
                'title' => 'Chief Financial Officer',
                'name' => 'Finance Director',
                'color' => '#10b981',
                'image' => 'https://ui-avatars.com/api/?name=CFO&size=128',
            ],
            [
                'id' => 'COO',
                'title' => 'Chief Operating Officer',
                'name' => 'Operations Director',
                'color' => '#f59e0b',
                'image' => 'https://ui-avatars.com/api/?name=COO&size=128',
            ],
        ]);
        
        // Optional: Add departments below this line
        /*
        \$builder->departments([
            ['CTO', 'Engineering Dept'],
            ['CFO', 'Finance Dept'],
        ]);
        
        \$builder->departmentNodes([
            ['id' => 'Engineering Dept', 'name' => 'Engineering Department'],
            ['id' => 'Finance Dept', 'name' => 'Finance Department'],
        ]);
        */
        
        // Optional: Add teams below this line
        /*
        \$builder->teams([
            ['Engineering Dept', 'Frontend Team'],
            ['Engineering Dept', 'Backend Team'],
        ]);
        
        \$builder->teamNodes([
            ['id' => 'Frontend Team', 'name' => 'Frontend Developers'],
            ['id' => 'Backend Team', 'name' => 'Backend Developers'],
        ]);
        */
        
        \$this->builder(\$builder);
    }
}

PHP;
    }
}

