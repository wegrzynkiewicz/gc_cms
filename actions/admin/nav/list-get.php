<?php

# pobierz wszystkie posortowane nawigacje z języka
$navs = GC\Model\Menu\Taxonomy::select()
    ->equals('lang', GC\Auth\Staff::getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$menus = GC\Model\Menu\Menu::select()
    ->fields(['menu_id', 'nav_id', 'parent_id', 'name'])
    ->source('::tree')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych nawigacji
$navsNodes = [];
foreach ($menus as $menu) {
    $navsNodes[$menu['nav_id']][] = $menu;
}

# zbuduj drzewa dla konkretnych nawigacji
$menuTrees = [];
foreach ($navs as $nav_id => $nav) {
    $menuTrees[$nav_id] = isset($navsNodes[$nav_id])
        ? GC\Model\Menu\Menu::createTree($navsNodes[$nav_id])
        : null;
}

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($navs)): ?>
                <?=$trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=render(ACTIONS_PATH.'/admin/parts/language.html.php', [
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
                            <?=render(ACTIONS_PATH.'/admin/nav/list-item.html.php', [
                                'nav_id' => $nav_id,
                                'nav' => $nav,
                                'tree' => $menuTrees[$nav_id],
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
