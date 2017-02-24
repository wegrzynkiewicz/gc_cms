<?php

# pobierz wszystkie posortowane taksonomie z danego języka
$taxonomies = GC\Model\Product\Taxonomy::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
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
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">
            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa produktu'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/slug.html.php', [
                    'name' => 'slug',
                    'label' => trans('Adres produktu'),
                    'help' => trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => trans('Tagi i słowa kluczowe (meta keywords)'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => trans('Opis podstrony (meta description)'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => trans('Zdjęcie wyróżniające'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = $taxonomy['tree']?>
                <?php if ($tree and $tree->hasChildren()): ?>
                    <div class="simple-box">
                        <?=render(ROUTES_PATH.'/admin/_parts/input/checkbox-tree.html.php', [
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

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz produkt'),
            ])?>
        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('form').validate({
        rules: {
            name: {
                required: true,
            },
            slug: {
                remote: {
                    url: "<?=$uri->make('/admin/validate/slug.json')?>",
                    data: {
                        frame_id: <?=$frame_id?>,
                    },
                },
            },
        },
        messages: {
            name: {
                required: "<?=trans('Nazwa produktu jest wymagana')?>",
            },
            slug: {
                remote: "<?=trans('Podany adres został już zarezerwowany')?>",
            },
        },
    });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
