<?php if (empty($sideMenu->getChildren())): ?>
    <p>
        <?=trans('Brak stron do wyświetlenia')?>
    </p>
<?php else: ?>
    <ol class="list-unstyled">
        <?=templateView("/navs/side-item.html.php", [
            'menu' => $sideMenu,
        ])?>
    </ol>
<?php endif ?>
