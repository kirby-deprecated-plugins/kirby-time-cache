# Options

The following options can be set in your `/site/config/config.php` file:

```php
c::set('partial.cache.expires', 86400);
c::set('partial.cache.filename.hash', true)
c::set('partial.cache.comments', false)
c::set('partial.cache.before');
c::set('partial.cache.after');
```

### partial.cache.expires

By default the expire time is set to `86400` seconds, which is 1 day.

### partial.cache.filename.hash

If you want to keep the cache filenames without hashing them, you need to set this value to `false`.

### partial.cache.comments

By having this value set to `true`, you will have HTML comments around your cached code block.

### partial.cache.before

This option is dependent on that `partial.cache.comments` is set to `true`.

By changing this option you can output whatever you want before the cached block in the HTML source code. By default you will see the expire time and the filename.

### partial.cache.after

This option is dependent on that `partial.cache.comments` is set to `true`.

By changing this option you can output whatever you want after the cached block in the HTML source code. By default you will see that the cached code block has ended.

## Site options

If you don't already have a `site.php` in the root folder of your installation, add one. Now you can change the folder of where to store your partial cache files. By default `site/cache-partial` is used.

**Be aware:** If you set it to `kirby()->roots()->cache()`, the partial cache might not work as expected.

```php
$kirby = kirby();
$kirby->roots()->partial() = $kirby->roots()->site() . DS . 'cache-partial';
```