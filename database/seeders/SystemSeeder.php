<?php

namespace Database\Seeders;

use App\Core\Models\Module;
use App\Core\Models\Theme;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        // Register Blog Module
        Module::updateOrCreate(
            ['slug' => 'blog'],
            [
                'name' => 'Blog',
                'version' => '2.0.0',
                'is_enabled' => true,
            ]
        );

        // Register Themes
        Theme::updateOrCreate(
            ['slug' => 'corporate'],
            [
                'name' => 'Corporate',
                'version' => '1.0.0',
                'is_active' => true,
                'is_default' => true,
                'path' => resource_path('themes/corporate')
            ]
        );

        Theme::updateOrCreate(
            ['slug' => 'creative'],
            [
                'name' => 'Creative',
                'version' => '1.0.0',
                'is_active' => false,
                'is_default' => false,
                'path' => resource_path('themes/creative')
            ]
        );
    }
}
