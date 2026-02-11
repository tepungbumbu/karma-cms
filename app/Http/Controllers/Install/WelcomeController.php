<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;

class WelcomeController extends InstallController
{
    public function index(): View
    {
        return view('installer.welcome');
    }
}
