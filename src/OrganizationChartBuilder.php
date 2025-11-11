<?php

namespace YacoubAlhaidari\OrganizationChart;

class OrganizationChartBuilder
{
    protected array $executiveLevel = [];
    protected array $departments = [];
    protected array $teams = [];
    protected array $nodes = [];
    protected array $executiveNodes = [];
    protected array $departmentNodes = [];
    protected array $teamNodes = [];
    protected string $title = 'Organization Chart';
    protected int $height = 700;
    protected bool $inverted = true;
    
    public static function make(): static
    {
        return new static();
    }
    
    public function executiveLevel(array $relationships): static
    {
        $this->executiveLevel = $relationships;
        return $this;
    }
    
    public function departments(array $relationships): static
    {
        $this->departments = $relationships;
        return $this;
    }
    
    public function teams(array $relationships): static
    {
        $this->teams = $relationships;
        return $this;
    }
    
    public function nodes(array $nodes): static
    {
        $this->nodes = $nodes;
        return $this;
    }
    
    public function executiveNodes(array $nodes): static
    {
        $this->executiveNodes = $nodes;
        return $this;
    }
    
    public function departmentNodes(array $nodes): static
    {
        $this->departmentNodes = $nodes;
        return $this;
    }
    
    public function teamNodes(array $nodes): static
    {
        $this->teamNodes = $nodes;
        return $this;
    }
    
    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }
    
    public function height(int $height): static
    {
        $this->height = $height;
        return $this;
    }
    
    public function inverted(bool $inverted = true): static
    {
        $this->inverted = $inverted;
        return $this;
    }
    
    public function getChartData(): array
    {
        return array_merge(
            $this->executiveLevel,
            $this->departments,
            $this->teams
        );
    }
    
    public function getChartNodes(): array
    {
        if (!empty($this->executiveNodes) || !empty($this->departmentNodes) || !empty($this->teamNodes)) {
            return array_merge(
                $this->executiveNodes,
                $this->departmentNodes,
                $this->teamNodes,
                $this->nodes
            );
        }
        
        return $this->nodes;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function getInverted(): bool
    {
        return $this->inverted;
    }
    
    public function getExecutiveKeys(): array
    {
        return array_unique(array_merge(
            array_column($this->executiveLevel, 0),
            array_column($this->executiveLevel, 1)
        ));
    }
    
    public function getExecutiveParents(): array
    {
        return array_unique(array_column($this->executiveLevel, 1));
    }
    
    public function getDepartmentKeys(): array
    {
        return array_unique(array_merge(
            array_column($this->departments, 0),
            array_column($this->departments, 1)
        ));
    }
    
    public function getDepartmentChildren(): array
    {
        return array_unique(array_column($this->departments, 1));
    }
    
    public function getTeamKeys(): array
    {
        return array_unique(array_merge(
            array_column($this->teams, 0),
            array_column($this->teams, 1)
        ));
    }
    
    public function getTeamChildren(): array
    {
        return array_unique(array_column($this->teams, 1));
    }
    
    public function getHierarchyTree(): array
    {
        return [
            'executives' => $this->getExecutiveKeys(),
            'department_managers' => $this->getExecutiveParents(),
            'departments' => $this->getDepartmentChildren(),
            'teams' => $this->getTeamChildren(),
        ];
    }
    
    public function getAllRequiredIds(): array
    {
        return array_unique(array_merge(
            $this->getExecutiveKeys(),
            $this->getDepartmentKeys(),
            $this->getTeamKeys()
        ));
    }
    
    public function getMissingNodes(): array
    {
        $requiredIds = $this->getAllRequiredIds();
        $definedIds = array_column($this->getChartNodes(), 'id');
        
        return array_values(array_diff($requiredIds, $definedIds));
    }
    
    public function validate(): array
    {
        $errors = [];
        
        $missing = $this->getMissingNodes();
        if (!empty($missing)) {
            $errors[] = 'Missing node definitions for: ' . implode(', ', $missing);
        }
        
        if (empty($this->getChartNodes()) && !empty($this->getChartData())) {
            $errors[] = 'No nodes defined but relationships exist';
        }
        
        foreach ($this->getChartNodes() as $node) {
            if (!isset($node['id']) || !isset($node['name'])) {
                $errors[] = 'Node missing required "id" or "name"';
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }
    
    public function getSummary(): array
    {
        return [
            'total_executives' => count($this->getExecutiveKeys()),
            'department_managers' => count($this->getExecutiveParents()),
            'total_departments' => count($this->getDepartmentChildren()),
            'total_teams' => count($this->getTeamChildren()),
            'total_nodes_defined' => count($this->getChartNodes()),
            'total_relationships' => count($this->getChartData()),
            'required_nodes' => count($this->getAllRequiredIds()),
            'missing_nodes' => count($this->getMissingNodes()),
        ];
    }
    
    public function build(): array
    {
        return [
            'data' => $this->getChartData(),
            'nodes' => $this->getChartNodes(),
            'title' => $this->getTitle(),
            'height' => $this->getHeight(),
            'inverted' => $this->getInverted(),
        ];
    }
}
