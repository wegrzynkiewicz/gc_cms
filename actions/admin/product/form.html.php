<?php

# pobierz wszystkie posortowane taksonomie z danego języka
$taxonomies = GC\Model\Product\Taxonomy::select()
    ->equals('lang', GC\Auth\Staff::getEditorLang())
    ->sort('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Product\Node::select()
    ->fields(['node_id', 'tax_id', 'parent_id', 'name'])
    ->source('::tree')
    ->sort('position', 'ASC')
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
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">
            <div class="simple-box">
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa produktu',
                ])?>

                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => 'Tagi i słowa kluczowe (meta keywords)',
                ])?>

                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => 'Opis podstrony (meta description)',
                ])?>

                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => 'Zdjęcie wyróżniające',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = $taxonomyTrees[$tax_id]?>
                <?php if ($tree and $tree->hasChildren()): ?>
                    <div class="simple-box">
                        <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/checkbox-tree.html.php', [
                            'id' => $tax_id,
                            'name' => "taxonomy[{$tax_id}]",
                            'label' => $taxonomy['name'],
                            'help' => "Do jakich węzłów ma należeć ten produkt?",
                            'checkedValues' => $checkedValues,
                            'tree' => $tree,
                        ])?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz wpis',
            ])?>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('form').validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "<?=$trans('Nazwa produktu jest wymagana')?>"
            },
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
