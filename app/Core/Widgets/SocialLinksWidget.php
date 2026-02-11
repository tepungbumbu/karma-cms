<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\View\View;

class SocialLinksWidget extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Social Links';
    }

    public function render(array $settings = []): View
    {
        return view('widgets.social_links', compact('settings'));
    }
}
