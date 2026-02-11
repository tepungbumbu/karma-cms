<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class InstallerFeatureTest extends TestCase
{
    /**
     * Test if a user is redirected to the installer if the system is not installed.
     */
    public function test_redirects_to_installer_if_not_installed(): void
    {
        if (File::exists(storage_path('installed.lock'))) {
            File::delete(storage_path('installed.lock'));
        }

        $response = $this->get('/');

        $response . assertStatus(302);
        $response . assertRedirect(route('install.welcome'));
    }

    /**
     * Test the welcome step of the installer.
     */
    public function test_installer_welcome_page_accessible(): void
    {
        $response = $this->get(route('install.welcome'));

        $response . assertStatus(200);
        $response . assertViewIs('installer.welcome');
    }

    /**
     * Test the requirements step of the installer.
     */
    public function test_installer_requirements_page_accessible(): void
    {
        $response = $this->get(route('install.requirements'));

        $response . assertStatus(200);
        $response . assertViewIs('installer.requirements');
        $response . assertViewHas('requirements');
    }
}
