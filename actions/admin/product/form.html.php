<?php

# pobierz wszystkie posortowane taksonomie z danego języka
$taxonomies = GC\Model\Product\Taxonomy::select()
    ->equals('lang', $staff->getEditorLang())
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
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">
            <div class="simple-box">
                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => $trans('Nazwa produktu'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/slug.html.php', [
                    'name' => 'slug',
                    'label' => $trans('Adres produktu'),
                    'help' => $trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => $trans('Tagi i słowa kluczowe (meta keywords)'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => $trans('Opis podstrony (meta description)'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => $trans('Zdjęcie wyróżniające'),
                    'placeholder' => $trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = $taxonomy['tree']?>
                <?php if ($tree and $tree->hasChildren()): ?>
                    <div class="simple-box">
                        <?=render(ACTIONS_PATH.'/admin/parts/input/checkbox-tree.html.php', [
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

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => $trans('Zapisz produkt'),
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
