<?php if ($sideMenu->hasChildren()): ?>
    <ol class="list-unstyled">
        <?=templateView("/navs/side-item.html.php", [
            'menu' => $sideMenu,
        ])?>
    </ol>
<?php else: ?>
    <p>
        <?=trans('Brak stron do wyświetlenia')?>
    </p>
<?php endif ?>
