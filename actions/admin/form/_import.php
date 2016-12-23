<?php

$headTitle = trans("Formularze");
GC\Url::extendMask('/form%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-envelope-o');
$form_id = shiftSegmentAsInteger();
