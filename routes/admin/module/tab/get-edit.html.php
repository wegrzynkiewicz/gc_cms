<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval($_GET['frame_id']);

# pobranie zakładki z ramką
$item = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('frame_id', $frame_id)
    ->fetch();

$_POST = $item;
?>

<?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => trans('Nazwa pojedyńczej zakładki'),
])?>
