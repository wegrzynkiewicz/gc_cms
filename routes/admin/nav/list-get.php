<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/nav/_import.php';

# pobierz wszystkie posortowane nawigacje z języka
$navs = GC\Model\Menu\Taxonomy::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$menus = GC\Model\Menu\Menu::select()
    ->fields('::fields, nav_id')
    ->source('::tree_frame')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych nawigacji
$navsNodes = [];
foreach ($menus as $menu) {
    $navsNodes[$menu['nav_id']][] = $menu;
}

# zbuduj drzewa dla konkretnych nawigacji
foreach ($navs as $nav_id => &$nav) {
    $nav['tree'] = isset($navsNodes[$nav_id])
        ? GC\Model\Menu\Menu::createTree($navsNodes[$nav_id])
        : null;
}
unset($nav);

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($navs)): ?>
                <?=trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=render(ROUTES_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=trans('Nazwa nawigacji')?></th>
                            <th><?=trans('Podgląd węzłów')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($navs as $nav_id => $nav): ?>
                            <?=render(ROUTES_PATH.'/admin/nav/list-item.html.php', $nav)?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/footer.html.php'; ?>
