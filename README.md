# KarmaCMS

KarmaCMS is an enterprise-grade, modular Content Management System built on Laravel 12.

## Key Features
- **High Performance**: Optimized for shared hosting with custom caching.
- **Security Hardened**: Protected against XSS, SQLi, and CSRF.
- **Marketplace Ready**: Clean code, no TODOs, and full documentation.
- **Modular**: Core, Blog, and Ecommerce modules included.

## Quick Installation
1. Upload the files to your server.
2. Visit `yourdomain.com/install.php`.
3. Follow the instructions.

## Developer Installation
```bash
composer install
php artisan migrate --seed
php artisan karma:post-install
```

## Documentation
Full documentation is available in the `documentation/index.html` file.
