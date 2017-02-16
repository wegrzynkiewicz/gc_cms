<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Menu\Tree::delete()
    ->equals('nav_id', $nav_id)
    ->execute();

# każdą nadesłaną pozycję wstaw do bazy danych
foreach ($positions as $menu) {
    if (isset($menu['id'])) {
        GC\Model\Menu\Tree::insert([
            'nav_id' => $nav_id,
            'menu_id' => $menu['id'],
            'parent_id' => $menu['parent_id'],
            'position' => GC\Model\Menu\Tree::selectMaxPositionByTaxonomyIdAndParentId($nav_id, $menu['parent_id']),
        ]);
    }
}

flashBox($trans('Pozycja węzłów została zapisana.'));
redirect($breadcrumbs->getLast('uri'));
