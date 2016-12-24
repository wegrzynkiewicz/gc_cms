<?php foreach ($menu->getChildren() as $node): ?>
    <li>
        <?=($node->getOpenTag())?>
            <?=e($node['name'])?>
        <?=($node->getCloseTag())?>
        <ol class="list-unstyled" style="padding-left: 20px">
            <?=templateView("/navs/side-items.html.php", [
                'menu' => $node,
            ])?>
        </ol>
    </li>
<?php endforeach ?>
