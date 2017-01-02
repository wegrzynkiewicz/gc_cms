<?php

$node = GC\Model\Menu\Menu::selectByPrimaryId($menu_id);

$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push($request->path, $headTitle);

$_POST = $node;
$refreshUrl = GC\Url::mask("/{$menu_id}/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
