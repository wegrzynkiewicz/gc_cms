<?php

$headTitle = "Sumy kontrolne plików";
GC\Url::extendMask('/root/checksum%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle);

$getFiles = function () {
    return array_filter(rglob('*.*'), function ($value) {
        return in_array(pathinfo($value, PATHINFO_EXTENSION), [
            'php', 'js', 'css', 'json', 'txt', 'md', 'html'
        ]);
    });
};
