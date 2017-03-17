<?php

# pobierz samą nawigację
$nav = GC\Model\Navigation\Taxonomy::select()
    ->equals('workname', 'funny-movies')
    ->equals('::menu_taxonomies.lang', getVisitorLang())
    ->fetch();

# pobierz węzły nawigacji i zbuduj z nich drzewo
$menu = GC\Model\Navigation\Node::select()
    ->fields('::fields')
    ->source('::tree_frame')
    ->equals('nav_id', $nav['nav_id'])
    ->fetchTree();

?>

<?php if ($nav): ?>
    <div class="sidebar-module">
        <h4><?=e($nav['name'])?></h4>
        <?php if ($menu->hasChildren()): ?>
            <ol class="list-unstyled">
                <?php foreach ($menu->getChildren() as $node): ?>
                    <?=render(TEMPLATE_PATH.'/navs/funny-movies-item.html.php', [
                        'node' => $node,
                    ])?>
                <?php endforeach ?>
            </ol>
        <?php else: ?>
            <p>
                <?=trans('Brak stron do wyświetlenia')?>
            </p>
        <?php endif ?>
    </div>
<?php endif ?>
