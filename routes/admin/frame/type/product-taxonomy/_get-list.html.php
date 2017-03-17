<?php

# pobierz wszystkie posortowane taksonomie z języka
$taxonomies = GC\Model\Frame::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->equals('type', $type)
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Frame::select()
    ->fields(['taxonomy_id', 'frame_id', 'parent_id', 'name'])
    ->source('::tree')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych taksonomii
$taxonomyNodes = [];
foreach ($nodes as $node) {
    $taxonomyNodes[$node['taxonomy_id']][] = $node;
}

# zbuduj drzewa dla konkretnych taksonomii
foreach ($taxonomies as $taxonomy_id => &$taxonomy) {
    $taxonomy['tree'] = isset($taxonomyNodes[$taxonomy_id])
        ? GC\Model\Frame::createTree($taxonomyNodes[$taxonomy_id])
        : null;
}
unset($taxonomy);

echo render(ROUTES_PATH.'/admin/frame/_parts/list-taxonomies.html.php', [
    'addCaption' => trans('Dodaj nowy podział produktów'),
    'nameCaption' => trans('Nazwa podziału produktów'),
]);
