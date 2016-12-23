<?php

$taxonomies = GC\Model\PostTaxonomy::selectAllCorrectWithPrimaryKey();

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa wpisu',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => 'Tagi i słowa kluczowe (meta keywords)',
                ])?>

                <?=GC\Render::action('/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => 'Opis podstrony (meta description)',
                ])?>

                <?=GC\Render::action('/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => 'Zdjęcie wyróżniające',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                <?php $tree = GC\Model\PostNode::buildTreeWithFrameByTaxonomyId($tax_id) ?>
                <?php if ($tree->hasChildren()): ?>
                    <div class="simple-box">
                        <?=GC\Render::action('/admin/parts/input/checkbox-tree.html.php', [
                            'tree' => $tree,
                            'tax_id' => $tax_id,
                            'name' => sprintf('taxonomy[%s]', $tax_id),
                            'label' => $taxonomy['name'],
                            'help' => "Do jakich węzłów ma należeć ten post?",
                            'checkedValues' => $checkedValues,
                        ])?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz wpis',
            ])?>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "<?=trans('Nazwa wpisu jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
