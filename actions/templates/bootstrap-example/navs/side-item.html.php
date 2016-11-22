<?php foreach ($menu->getChildren() as $node): ?>
    <li>
        <?=startlinkAttributesFromMenuNode($node)?>
            <?=$node['name']?>
        <?=endlinkAttributesFromMenuNode($node)?>
        <ol class="list-unstyled" style="padding-left: 20px">
            <?=templateView("/navs/side-item.html.php", [
                'menu' => $node,
            ])?>
        </ol>
    </li>
<?php endforeach ?>
