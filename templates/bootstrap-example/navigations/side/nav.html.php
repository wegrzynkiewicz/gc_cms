<?php

# pobierz samą nawigację
$navigation = GC\Model\Navigation::select()
    ->equals('workname', 'side')
    ->equals('lang', getVisitorLang())
    ->fetch();

# pobierz węzły nawigacji i zbuduj z nich drzewo, jeżeli nawigacja istnieje
$tree = false;
if ($navigation) {
    $tree = GC\Model\Navigation\Node::select()
        ->fields('::withFrameFields')
        ->source('::withFrameSource')
        ->equals('navigation_id', $navigation['navigation_id'])
        ->fetchTree();
}

?>

<?php if ($navigation and $tree and $tree->hasChildren()): ?>
    <div class="well">
        <h4><?=e($navigation['name'])?></h4>
        <ol class="list-unstyled">
            <?php foreach ($tree->getChildren() as $node): ?>
                <?=render(TEMPLATE_PATH."/navigations/side/_item.html.php", $node->getData())?>
            <?php endforeach ?>
        </ol>
    </div>
<?php endif ?>
