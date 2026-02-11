<?php

namespace Tests\Unit;

use App\Core\Services\ModuleManager;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ModuleManagerUnitTest extends TestCase
{
    /**
     * Test that the modules directory is created if it doesn't exist.
     */
    public function test_modules_directory_is_created(): void
    {
        $path = base_path('modules');

        // This is handled in constructor
        new ModuleManager();

        $this->assertTrue(File::isDirectory($path));
    }
}
