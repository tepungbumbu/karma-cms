<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;

abstract class InstallController extends Controller
{
    /**
     * Check if a step is accessible.
     */
    protected function checkStepAccess(string $step): void
    {
        // To be implemented: Check session/file status to ensure steps are followed in order
    }
}
