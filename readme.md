# Kirby Partial Cache

*Version 0.1*

Partial cache made simple!

**Features**

- Cache anything you want.
- Set the expire time as config option or as argument.
- Set the cache folder to anything you like.
- Hash the cache filename or not, the choice is yours.
- Debug the cached blocks by using a HTML comment before and after.
- Multiple instances. Multiple cache files, for multiple blocks, with different expire times.

## Table of contents

- [Installation instructions](docs/install.md)
- [Options](docs/options.md)

## Usage

The only thing you need to use is the `partial::cache($filename, $callback, $expire = null)` function.

Everything within the callback function will be cached. When it reaches the expire time, it will run again and recached.

### Basic

Use it in a template or a snippet.

```php
echo partial::cache('filename.json', function() {
    return 'Hello world!';
});
```

### Use arguments

```php
echo partial::cache('filename.json', function() use ($page, $site) {
    return $page->title() . ' - ' . $site->title();
});
```

### Use a custom expire time

The third argument is the cache expire time, which is optional. In this case the cache will refresh after 1 minute (60 seconds).

```php
echo partial::cache('filename.json', function() {
    return $page->title();
}, 60);
```

### With a controller

The cached data goes into `$categories` and `$products` when using it in a template or a snippet.

**Controller**

```php
return function($site, $pages, $page) {
    return [
        'categories' => partial::cache('categories.json', function() {
            return slowCategoryFunction();
        }),
        'products' => partial::cache('products.json', function() {
            return slowProductFunction();
        }),
    ];
};
```

## Requirements

- [**Kirby**](https://getkirby.com/) 2.5+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/kirby-partial-cache/issues/new).

## License

Free to use at the moment.

## Credits

- [Jens Törnell](https://github.com/jenstornell)
- [Bruno Meilick](https://github.com/bnomei/)