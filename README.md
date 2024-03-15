# Techno\Framework

💀 Dead simple PHP microframework

This framework contains only:
- router
- service container
- .env parser

## How to start

Add framework to project.

```bash
composer require techno/framework
```

Create entry file.

```php
// index.php
$app = new Techno\Framework\App();
$app->run();
```

## Router

```php
// router.php
return [
    'GET /' => Index::class,
    'POST /action' => Action::class,
];
```

By default, the `router.php` file is loaded from the same directory as the entry point. The file path can be changed during application initialization:

```php
// index.php
$app = new Techno\Framework\App(
    router_path: './src/router.php',
);
```

## .env files
All variables from the `.env` file are automatically loaded into the global `$_ENV` variable.

The `.env` file must always be provided.

By default, the `.env` file is loaded from the same directory as the entry point. The file path can be changed during application initialization:

```php
// index.php
$app = new Techno\Framework\App(
    env_path: './../.env',
);
```
