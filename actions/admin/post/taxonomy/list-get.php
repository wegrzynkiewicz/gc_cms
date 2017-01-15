<?php

$tax_id = intval(array_shift($_PARAMETERS));
$taxonomies = GC\Model\Post\Taxonomy::select()
    ->equals('lang', GC\Auth\Staff::getEditorLang())
    ->sort('name')
    ->fetchByPrimaryKey();

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($taxonomies)): ?>
                <?=$trans('Nie znaleziono podziałów wpisów w języku: ')?>
                <?php require ACTIONS_PATH.'/admin/parts/language.html.php'; ?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th>
                                <?=$trans('Nazwa podziału')?>
                            </th>
                            <th>
                                <?=$trans('Podgląd węzłów')?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                            <?=GC\Render::file(ACTIONS_PATH.'/admin/post/taxonomy/list-item.html.php', [
                                'tax_id' => $tax_id,
                                'taxonomy' => $taxonomy,
                                'tree' => GC\Model\Post\Node::buildTreeWithFrameByTaxonomyId($tax_id),
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
