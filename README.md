FileCache
=========
Usage
-----
```php
<?php
use FuHsi\FileCache;
require '../FileCache/FileCache.php';

$options = array(
    'cacheDir' => __DIR__,
    'lifeTime' => FileCache::HOUR
);
$cache = new FileCache($options);

$result = $cache->get('my unique key', true, function ()
{
    return array(
        1,
        2,
        3,
        4,
        5
    );
});

var_dump($result);
?>
```
Cache file source
-----------------
```php
<?php return array (
  0 => 1,
  1 => 2,
  2 => 3,
  3 => 4,
  4 => 5,
); ?>
```
