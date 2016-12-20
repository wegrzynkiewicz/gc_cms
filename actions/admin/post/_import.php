<?php

$headTitle = trans("Wpisy");
$breadcrumbs->push('/admin/post/list', $headTitle, 'fa-pencil-square-o');

function taxonomyNodeUrl($path)
{
    global $tax_id;

    return url("/admin/post/taxonomy/node$path/$tax_id");
};
