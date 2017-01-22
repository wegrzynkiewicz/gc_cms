<?php

$headTitle = "Sumy kontrolne plików";
GC\Url::extendMask('/root/checksum%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
]);

$getFiles = function () {
    $webDataPath = realpath(WEB_PATH.'/data');
    return array_filter(GC\Disc::globRecursive('*.*'), function ($value) use (&$webDataPath) {

        if (strpos(realpath($value), $webDataPath) !== false) {
            return false;
        }

        return in_array(pathinfo($value, PATHINFO_EXTENSION), [
            'php', 'js', 'css', 'json', 'txt', 'md', 'html'
        ]);
    });
};
