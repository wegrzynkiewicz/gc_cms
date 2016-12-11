<?php $menu = Menu::buildTreeByWorkName("side", getClientLang()) ?>

<?php if ($menu->hasChildren()): ?>
    <ol class="list-unstyled">
        <?=templateView("/navs/side-item.html.php", [
            'menu' => $menu,
        ])?>
    </ol>
<?php else: ?>
    <p>
        <?=trans('Brak stron do wyświetlenia')?>
    </p>
<?php endif ?>
