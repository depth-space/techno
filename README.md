# Depth\Techno
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fbvlinsky%2Ftechno.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fbvlinsky%2Ftechno?ref=badge_shield)


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


## License
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fbvlinsky%2Ftechno.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fbvlinsky%2Ftechno?ref=badge_large)