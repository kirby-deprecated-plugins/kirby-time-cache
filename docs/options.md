# Options

The following options can be set in your `/site/config/config.php` file:

```php
c::set('time.cache.expires', 86400);
c::set('time.cache.filename.hash', true);
c::set('time.cache.pages', false);
c::set('time.cache.pages.comments', false);
c::set('time.cache.pages.expires', 86400);
c::set('time.cache.path', kirby()->roots()->site() . '/cache-time');
```

### time.cache.expires

By default the expire time is set to `86400` seconds, which is 1 day.

### time.cache.filename.hash

If you want to keep the cache filenames without hashing them, you need to set this value to `false`.

### time.cache.pages

If you want to cache the full pages similar to the built in cache, you can set this to `true`.

### time.cache.pages.comments

This option is only relevant if `time.cache.pages` is `true`.

If you want to see information about the cache pages, like `id`, `filename` and `timestamp` as a HTML comment you can set this to `true`. Be aware that the HTML comment is cached as well. If you change this option after the page is cached, you need to clear the cache and reload the page.

### time.cache.pages.expires

This option is only relevant if `time.cache.pages` is `true`.

By default the pages cache will expire after 1 day. You can change it by setting an expire time in seconds.

### time.cache.path

The path of where the cache files will be stored. By default `site/cache-time` is used.