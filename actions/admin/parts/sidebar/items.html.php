<?php foreach ($menu as $node_id => $node): ?>
    <?php if (GC\Staff::getInstance()->hasPermissions($node['perms'])): ?>
        <?=render(ACTIONS_PATH.'/admin/parts/sidebar/item.html.php', [
            'node_id' => $node_id,
            'node' => $node,
            'attr' => $attr,
        ])?>
    <?php endif ?>
<?php endforeach ?>
