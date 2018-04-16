# Kirby Time Cache

![Version](https://img.shields.io/badge/version-0.2-blue.svg) ![License](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

A cache that expires after a time of your choice.

**Features**

- Cache part of a page or a function.
- Cache pages similar to the built in cache.
- Set an expire time, as config option or as argument.

## Table of contents

- [Installation instructions](docs/install.md)
- [Options](docs/options.md)

## Usage

### Cache pages

This cache will cache pages similar to the built in cache. The difference is that it will expire after a time of your choice. It's expecially good for sites that use a database where Kirby does not know when the content has been updated.

You need to add this to your config:

```php
c::set('time.cache.pages', true);
```

To see `id`, `filename` and `timestamp` in the cached HTML code, you can also add this option:

```php
c::set('time.cache.pages.comments', true);
```

*You can't add the last option after the page has already been cached. Then you need to remove the cache file or wait for the cache to expire and refresh itself*

### Cache part - Basic

Use it in a template or a snippet like this:

```php
echo time::cache('filename.json', function() {
    return 'Hello world!';
});
```

### Cache part - Advanced

```php
$page = page('about');
$site = site();

echo time::cache('filename.json', function() use ($page, $site) {
    return $page->title() . ' - ' . $site->title();
}, 60);
```

**Use arguments**

It uses `$page` and `$site` that then become available inside the `time::cache` function. You can use any variables you want.

**Time expire**

It also has the third argument `60` which is the expire time. It will refresh the cache in 1 minute (60 seconds). You can also set the expire time globally with the `c::set('time.cache.expires')` [option](docs/options.md).

## Requirements

- [**Kirby**](https://getkirby.com/) 2.5+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/kirby-time-cache/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Credits

- [Jens Törnell](https://github.com/jenstornell)
- [Bruno Meilick](https://github.com/bnomei/)