# Karma CMS - Professional Web Installer & Modular Architecture

> **Phase 1: Core Architecture & Web Installer System**

Karma CMS is a powerful, production-ready Laravel 11 CMS designed specifically for high-performance modular applications and optimized for shared hosting environments (DirectAdmin/cPanel).

## 🚀 Phase 1 Overview: Core Infrastructure

The first phase of Karma CMS focuses on building a rock-solid foundation that allows for plug-and-play modules and a seamless web-based installation process.

### 🛠 Key Components

1. **Modular Architecture Kernel**:
    - Dynamic module discovery from `/modules/`.
    - Manifest-based dependency resolution (`module.json`).
    - Automated registration of service providers, routes, views, and migrations.
    - Database-driven module lifecycle (Activate/Deactivate/Uninstall).

2. **Web-Based Installer (Wizard)**:
    - 8-step premium installation wizard built with Tabler Admin.
    - Comprehensive server requirements check (PHP 8.2+, Extensions, Permissions).
    - License verification (Envato/CodeCanyon ready).
    - DirectAdmin-optimized database configuration.
    - Dynamic `.env` generation and secure `APP_KEY` setup.
    - AJAX-powered database migration and seeding.
    - Super-admin account creation.

3. **Shared Hosting Optimization Layer**:
    - Advanced database connection retry logic for unstable MySQL hosts.
    - File-based cache garbage collection to prevent storage bloat.
    - Manual session cleanup fallback.
    - Automatic log rotation (preventing massive `laravel.log` files).

4. **Premium Admin UI**:
    - Full integration of **Tabler Admin** template.
    - Responsive layout with dark/light mode toggle.
    - Breadcrumbs, toast notifications, and modular navigation support.

---

## 🛠 Installation (Shared Hosting)

1. Upload the files to your shared hosting directory.
2. Point your domain to the `/public` directory.
3. Visit `yoursite.com/install` to begin the wizard.

## 📁 Project Structure

- `app/Core/`: The engine of the CMS (ModuleManager, SharedHostingOptimizer).
- `modules/`: Directory for plug-and-play modules (Blog, SEO, Media, etc.).
- `resources/views/installer/`: Installer step templates.
- `resources/views/layouts/admin.blade.php`: The main layout for the administration area.

## 📄 License

Part of the Karma-CMS Ecosystem. Phase 1 - Core & Installer.
