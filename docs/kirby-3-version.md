```php
  use JensTornell\Time as time;
  echo time::cache('test.txt', function() {
    return 'hello world';
  }, 30);
```
