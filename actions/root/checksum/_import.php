<?php

$headTitle = "Sumy kontrolne plików";
$uri->extendMask('/root/checksum%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getFiles = function () {
    $webDataPath = realpath(WEB_PATH.'/data');
    return array_filter(globRecursive('*.*'), function ($value) use (&$webDataPath) {

        if (strpos(realpath($value), $webDataPath) !== false) {
            return false;
        }

        return in_array(pathinfo($value, PATHINFO_EXTENSION), [
            'php', 'js', 'css', 'json', 'txt', 'md', 'html'
        ]);
    });
};
