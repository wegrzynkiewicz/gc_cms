<?php

$taxonomies = GrafCenter\CMS\Model\PostTaxonomy::selectAllCorrectWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Nazwa wpisu',
            ])?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'keywords',
                'label' => 'Tagi i słowa kluczowe (meta keywords)',
            ])?>

            <?=view('/admin/parts/input/textarea.html.php', [
                'name' => 'description',
                'label' => 'Opis podstrony (meta description)',
            ])?>

            <?=view('/admin/parts/input/image.html.php', [
                'name' => 'image',
                'label' => 'Zdjęcie wyróżniające',
                'placeholder' => 'Ścieżka do pliku zdjęcia',
            ])?>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = GrafCenter\CMS\Model\PostNode::buildTreeByTaxonomyId($tax_id) ?>
                <?php if ($tree->hasChildren()): ?>
                    <?=view('/admin/parts/input/checkbox-tree.html.php', [
                        'tree' => $tree,
                        'tax_id' => $tax_id,
                        'name' => sprintf('taxonomy[%s]', $tax_id),
                        'label' => $taxonomy['name'],
                        'help' => "Do jakich węzłów ma należeć ten post?",
                        'checkedValues' => $checkedValues,
                    ])?>
                <?php endif ?>
            <?php endforeach ?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/post/list",
                'saveLabel' => 'Zapisz wpis',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                minlength: 4,
                required: true
            }
        },
        messages: {
            name: {
                minlength: "<?=trans('Nazwa wpisu musi być dłuższa niż 4 znaki')?>",
                required: "<?=trans('Nazwa wpisu jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
