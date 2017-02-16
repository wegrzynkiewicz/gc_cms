<?php

# pobierz węzły nawigacji i zbuduj z nich drzewo
$menu = GC\Model\Menu\Menu::select()
    ->fields('parent_id, ::menus.*, link')
    ->source('::taxonomy')
    ->equals('workname', 'side')
    ->equals('::menu_taxonomies.lang', GC\Auth\Visitor::getLang())
    ->fetchTree();

?>
<?php if ($menu->hasChildren()): ?>
    <ol class="list-unstyled">
        <?=templateView("/navs/side-items.html.php", [
            'menu' => $menu,
        ])?>
    </ol>
<?php else: ?>
    <p>
        <?=$trans('Brak stron do wyświetlenia')?>
    </p>
<?php endif ?>
