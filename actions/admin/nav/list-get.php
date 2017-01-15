<?php

$navs = GC\Model\Menu\Taxonomy::select()
    ->equals('lang', GC\Auth\Staff::getEditorLang())
    ->sort('name')
    ->fetchByPrimaryKey();

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($navs)): ?>
                <?=$trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Auth\Staff::getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=$trans('Nazwa nawigacji')?></th>
                            <th><?=$trans('Podgląd węzłów')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($navs as $nav_id => $nav): ?>
                            <?=GC\Render::file(ACTIONS_PATH.'/admin/nav/list-item.html.php', [
                                'nav_id' => $nav_id,
                                'nav' => $nav,
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
