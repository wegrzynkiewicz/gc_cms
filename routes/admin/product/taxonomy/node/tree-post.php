<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/product/_import.php';
require ROUTES_PATH.'/admin/product/taxonomy/_import.php';
require ROUTES_PATH.'/admin/product/taxonomy/node/_import.php';

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Product\Tree::delete()
    ->equals('tax_id', $tax_id)
    ->execute();

# każdą nadesłaną pozycję wstaw do bazy danych
foreach ($positions as $node) {

    if (isset($node['id'])) {

        # pobierz największą pozycję dla węzła w drzewie
        $position = GC\Model\Product\Tree::select()
            ->fields('MAX(position) AS max')
            ->equals('tax_id', $tax_id)
            ->equals('parent_id', $node['parent_id'])
            ->fetch()['max'];

        GC\Model\Product\Tree::insert([
            'tax_id' => $tax_id,
            'frame_id' => $node['id'],
            'parent_id' => $node['parent_id'],
            'position' => $position+1,
        ]);
    }
}

flashBox(trans('Pozycja węzłów została zapisana.'));
redirect($breadcrumbs->getLast('uri'));
