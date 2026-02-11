<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\View\View;

abstract class BaseWidget
{
    /**
     * Get the widget title.
     */
    abstract public function getTitle(): string;

    /**
     * Get the widget description.
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * Get the widget form settings fields.
     */
    public function getSettingsSchema(): array
    {
        return [];
    }

    /**
     * Render the widget view.
     */
    abstract public function render(array $settings = []): View;
}
