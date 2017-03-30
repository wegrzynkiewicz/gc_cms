<?php

# pobierz samą nawigację
$navigation = GC\Model\Navigation::select()
    ->equals('workname', 'top')
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

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <?php if ($navigation and $tree and $tree->hasChildren()): ?>
                <button
                    type="button"
                    class="navbar-toggle"
                    data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span class="sr-only">
                        <?=trans('Przełącz nawigację')?>
                    </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php endif ?>
            <a class="navbar-brand" href="<?=$uri->make('/')?>">
                <?=e($config['template']['pageCaption'])?>
            </a>
        </div>
        <?php if ($navigation and $tree and $tree->hasChildren()): ?>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php foreach ($tree->getChildren() as $node): ?>
                        <?=render(TEMPLATE_PATH."/navigations/top/_item.html.php", $node->getData())?>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>
    </div>
</nav>
