<?php

$headTitle = trans("Wpisy");

if (intval($_SEGMENTS[0])) {
    $post_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/post{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-pencil-square-o');

function taxonomyNodeUrl($path)
{
    global $tax_id;

    return url("/admin/post/taxonomy/node$path/$tax_id");
};
