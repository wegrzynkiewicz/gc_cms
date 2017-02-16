<?php foreach ($menu->getChildren() as $node): ?>
    <li>
        <?=templateView("/parts/menu-node-link.html.php", [
            'node' => $node,
        ])?>
        <ol class="list-unstyled" style="padding-left: 20px">
            <?=templateView("/navs/side-items.html.php", [
                'menu' => $node,
            ])?>
        </ol>
    </li>
<?php endforeach ?>
