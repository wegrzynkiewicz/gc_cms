<?php $menu = GC\Model\Menu\Menu::buildTreeByWorkName("side", GC\Auth\Client::getLang()) ?>

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
