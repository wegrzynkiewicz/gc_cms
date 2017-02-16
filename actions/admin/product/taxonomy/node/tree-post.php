<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/node/_import.php';

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Product\Tree::delete()
    ->equals('tax_id', $tax_id)
    ->execute();

# każdą nadesłaną pozycję wstaw do bazy danych
foreach ($positions as $node) {
    if (isset($node['id'])) {
        GC\Model\Product\Tree::insert([
            'tax_id' => $tax_id,
            'node_id' => $node['id'],
            'parent_id' => $node['parent_id'],
            'position' => GC\Model\Product\Tree::selectMaxPositionByTaxonomyIdAndParentId($tax_id, $node['parent_id']),
        ]);
    }
}

flashBox($trans('Pozycja węzłów została zapisana.'));
redirect($breadcrumbs->getLast('uri'));
