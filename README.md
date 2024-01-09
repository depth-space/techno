# Depth\Techno

💀 Dead simple PHP microframework

```php
// index.php
$app = new Depth\Techno\App();
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
