<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\View\View;

class CustomHtmlWidget extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Custom HTML';
    }

    public function render(array $settings = []): View
    {
        return view('widgets.custom_html', compact('settings'));
    }
}
