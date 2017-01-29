<?php $dest = $node['destination']; ?>
<?php if (isset($pages[$dest])): ?>
    <?=$trans($config['nodeTypes']['page'])?>
    <a href="<?=$uri->make("/admin/page/{$dest}/edit")?>">
        <?=e($pages[$dest]['name'])?>
    </a>
<?php else: ?>
    <span class="text-danger">
        <?=$trans('Kieruje do nieistniejącej strony!')?>
    </span>
<?php endif ?>

<span style="margin-left: 30px">
    <?=$trans($config['navNodeTargets'][$node['target']])?>
</span>
