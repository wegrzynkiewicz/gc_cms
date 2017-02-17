<?php

# pobierz węzły nawigacji i zbuduj z nich drzewo
$menu = GC\Model\Menu\Menu::select()
    ->fields('parent_id, ::menus.*, slug')
    ->source('::taxonomy')
    ->equals('workname', 'top')
    ->equals('::menu_taxonomies.lang', GC\Visitor::getLang())
    ->fetchTree();

?>

<?php if ($menu->hasChildren()): ?>
    <div class="blog-masthead">
        <div class="container">
            <nav class="blog-nav">
                <?php foreach ($menu->getChildren() as $node): ?>
                    <?=render(TEMPLATE_PATH.'/parts/menu-node-link.html.php', [
                        'node' => $node,
                        'extend' => 'class="blog-nav-item"',
                    ])?>
                <?php endforeach ?>
            </nav>
        </div>
    </div>
<?php else: ?>

<?php endif ?>
