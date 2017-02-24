<?php

# pobierz wszystkie posortowane taksonomie z danego języka
$taxonomies = GC\Model\Post\Taxonomy::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Post\Tree::select()
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
        ? GC\Model\Post\Tree::createTree($taxonomyNodes[$tax_id])
        : null;
}
unset($taxonomy);

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Informacje podstawowe')?></legend>
                    <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                        'name' => 'name',
                        'label' => trans('Nazwa wpisu'),
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
                        'name' => 'image',
                        'label' => trans('Zdjęcie wyróżniające'),
                        'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/seo-box.html.php')?>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = $taxonomy['tree']?>
                <?php if ($tree and $tree->hasChildren()): ?>
                    <div class="simple-box">
                        <?=render(ROUTES_PATH.'/admin/_parts/input/checkbox-tree.html.php', [
                            'id' => $tax_id,
                            'name' => "taxonomy[{$tax_id}]",
                            'label' => $taxonomy['name'],
                            'help' => "Do jakich węzłów ma należeć ten wpis?",
                            'checkedValues' => $checkedValues,
                            'tree' => $tree,
                        ])?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia')?></legend>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                        'name' => 'visibility',
                        'label' => trans('Widoczność strony wpisu'),
                        'help' => trans('Decyduje o widoczności strony w nawigacji i mapie strony'),
                        'options' => array_trans($config['frameVisibility'])
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/datetimepicker.html.php', [
                        'name' => 'publication_datetime',
                        'label' => trans('Data publikacji wpisu'),
                        'help' => trans('Zostaw puste, aby ustawieć teraźniejszą datę'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz wpis'),
            ])?>
        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
