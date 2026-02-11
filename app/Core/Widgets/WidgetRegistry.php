<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class WidgetRegistry
{
    protected array $widgets = [];
    protected array $areas = [];

    /**
     * Register a new widget class.
     */
    public function registerWidget(string $alias, string $className): void
    {
        $this->widgets[$alias] = $className;
    }

    /**
     * Register a widget area (sidebar, footer, etc).
     */
    public function registerArea(string $id, string $name): void
    {
        $this->areas[$id] = [
            'id' => $id,
            'name' => $name,
            'widgets' => collect()
        ];
    }

    /**
     * Add a widget to an area.
     */
    public function addWidgetToArea(string $areaId, string $widgetAlias, array $settings = [], int $order = 0): void
    {
        if (isset($this->areas[$areaId])) {
            $this->areas[$areaId]['widgets']->push([
                'alias' => $widgetAlias,
                'settings' => $settings,
                'order' => $order
            ]);
        }
    }

    /**
     * Render all widgets for a given area.
     */
    public function renderArea(string $areaId): string
    {
        if (!isset($this->areas[$areaId])) {
            return '';
        }

        $html = '';
        $widgets = $this->areas[$areaId]['widgets']->sortBy('order');

        foreach ($widgets as $item) {
            $alias = $item['alias'];
            if (isset($this->widgets[$alias])) {
                $widget = app($this->widgets[$alias]);
                $html .= $widget->render($item['settings'])->render();
            }
        }

        return $html;
    }
}
