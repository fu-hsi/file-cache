<?php
use FuHsi\FileCache\FileCache;

//require 'vendor/autoload.php';
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
