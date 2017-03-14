<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/product/_import.php';
require ROUTES_PATH.'/admin/product/taxonomy/_import.php';

# pobierz wszystkie posortowane taksonomie z języka
$taxonomies = GC\Model\Frame::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->equals('type', 'product-taxonomy')
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Product\Tree::select()
    ->fields(['tax_id', 'frame_id', 'parent_id', 'name'])
    ->source('::nodes')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych taksonomii
$taxonomyNodes = [];
foreach ($nodes as $node) {
    $taxonomyNodes[$node['tax_id']][] = $node;
}

# zbuduj drzewa dla konkretnych taksonomii
foreach ($taxonomies as $tax_id => &$taxonomy) {
    $taxonomy['tree'] = isset($taxonomyNodes[$tax_id])
        ? GC\Model\Product\Tree::createTree($taxonomyNodes[$tax_id])
        : null;
}
unset($taxonomy);

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($taxonomies)): ?>
                <?=trans('Nie znaleziono podziałów produktów w języku: ')?>
                <?=render(ROUTES_PATH.'/admin/_parts/language.html.php', [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th>
                                <?=trans('Nazwa podziału produktu')?>
                            </th>
                            <th>
                                <?=trans('Podgląd węzłów')?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxonomies as $taxonomy): ?>
                            <?=render(ROUTES_PATH.'/admin/product/taxonomy/_list-item.html.php', $taxonomy)?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
