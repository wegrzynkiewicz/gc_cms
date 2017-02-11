<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';

# pobierz wszystkie posortowane taksonomie z języka
$taxonomies = GC\Model\Product\Taxonomy::select()
    ->equals('lang', $staff->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Product\Node::select()
    ->fields(['node_id', 'tax_id', 'parent_id', 'name'])
    ->source('::tree')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych taksonomii
$taxonomyNodes = [];
foreach ($nodes as $node) {
    $taxonomyNodes[$node['tax_id']][] = $node;
}

# zbuduj drzewa dla konkretnych taksonomii
$taxonomyTrees = [];
foreach ($taxonomies as $tax_id => $taxonomy) {
    $taxonomyTrees[$tax_id] = isset($taxonomyNodes[$tax_id])
        ? GC\Model\Product\Node::createTree($taxonomyNodes[$tax_id])
        : null;
}

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($taxonomies)): ?>
                <?=$trans('Nie znaleziono podziałów wpisów w języku: ')?>
                <?=render(ACTIONS_PATH.'/admin/parts/language.html.php', [
                    'lang' => $staff->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th>
                                <?=$trans('Nazwa podziału produktu')?>
                            </th>
                            <th>
                                <?=$trans('Podgląd węzłów')?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                            <?=render(ACTIONS_PATH.'/admin/product/taxonomy/list-item.html.php', [
                                'tax_id' => $tax_id,
                                'taxonomy' => $taxonomy,
                                'tree' => $taxonomyTrees[$tax_id],
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
