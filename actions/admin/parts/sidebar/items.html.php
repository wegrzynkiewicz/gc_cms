<?php foreach ($menu as $node_id => $node): ?>
    <?php if ($staff->hasPermissions($node['perms'])): ?>
        <?=GC\Render::action('/admin/parts/sidebar/item.html.php', [
            'node_id' => $node_id,
            'node' => $node,
            'attr' => $attr,
        ])?>
    <?php endif ?>
<?php endforeach ?>
