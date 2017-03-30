<?php

# pobierz wszystkie posortowane taksonomie z danego języka
$taxonomies = GC\Model\Frame::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->equals('type', 'post-taxonomy')
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

?>

<?php foreach ($taxonomies as $taxonomy_id => $taxonomy): ?>
    <?php $tree = $taxonomy['tree']?>
    <?php if ($tree and $tree->hasChildren()): ?>
        <div class="simple-box">
            <?=render(ROUTES_PATH."/admin/parts/input/_checkbox-tree.html.php", [
                'id' => $taxonomy_id,
                'name' => "taxonomy[{$taxonomy_id}]",
                'label' => $taxonomy['name'],
                'help' => "Do jakich węzłów ma należeć ten wpis?",
                'checkedValues' => $checkedValues,
                'tree' => $tree,
            ])?>
        </div>
    <?php endif ?>
<?php endforeach ?>
