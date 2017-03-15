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
                                <?=$nameCaption?>
                            </th>
                            <th>
                                <?=trans('Podgląd węzłów')?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxonomies as $taxonomy): ?>
                            <?=render(ROUTES_PATH.'/admin/frame/_parts/list-taxonomy-item.html.php', $taxonomy)?>
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
