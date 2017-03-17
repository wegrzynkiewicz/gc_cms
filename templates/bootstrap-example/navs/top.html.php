<?php

# pobierz samą nawigację
$nav = GC\Model\Navigation\Taxonomy::select()
    ->equals('workname', 'top')
    ->equals('lang', getVisitorLang())
    ->fetch();

# pobierz węzły nawigacji i zbuduj z nich drzewo
$menu = GC\Model\Navigation\Node::select()
    ->fields('::fields')
    ->source('::tree_frame')
    ->equals('nav_id', $nav['nav_id'])
    ->fetchTree();

?>

<?php if ($menu->hasChildren()): ?>
    <div class="blog-masthead">
        <div class="container">
            <nav class="blog-nav">
                <?php foreach ($menu->getChildren() as $node): ?>
                    <?=render(TEMPLATE_PATH.'/navs/node.html.php', [
                        'node' => $node,
                        'extend' => 'class="blog-nav-item"',
                    ])?>
                <?php endforeach ?>
            </nav>
        </div>
    </div>
<?php else: ?>

<?php endif ?>
