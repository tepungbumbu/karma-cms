<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\View\View;

class NewsletterWidget extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Newsletter';
    }

    public function render(array $settings = []): View
    {
        return view('widgets.newsletter', compact('settings'));
    }
}
