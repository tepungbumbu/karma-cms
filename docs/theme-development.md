# 🎨 Theme Development Guide

Karma CMS uses a powerful, modular theme engine. This guide explains how to create your own theme from scratch.

## 📁 Directory Structure

Themes are located in `resources/themes/{your-theme-slug}/`.

```
your-theme/
├── theme.json         # REQUIRED: Manifest file
├── views/             # Blade templates
│   ├── layouts/       # e.g., master.blade.php
│   └── partials/      # e.g., header.blade.php
├── assets/            # CSS, JS, Images
└── theme.png          # Recommended: 800x450 preview
```

## 📝 Manifest (theme.json)

```json
{
    "name": "My Custom Theme",
    "slug": "my-theme",
    "version": "1.0.0",
    "author": "Your Name",
    "widget_areas": [{ "id": "sidebar", "name": "Main Sidebar" }]
}
```

## 🧩 Theme Views

Always extend the master layout and use the `theme::` namespace for partials:

```php
@extends('theme::layouts.master')
@include('theme::partials.header')
```

## 🛠️ Performance Best Practices

1. **Critical CSS**: Add your above-fold styles to `assets/css/critical.css`. It will be inlined automatically.
2. **Semantic HTML**: Use `<header role="banner">`, `<main role="main">`, and `<nav role="navigation">`.
3. **Lazy Loading**: Use the native `loading="lazy"` attribute on `<img>` tags.

## 🚀 Activation

1. Place your theme folder in `resources/themes/`.
2. Go to **Admin > Themes**.
3. Click **Activate**.

```php
php artisan karma:theme-discover # Coming soon
```
