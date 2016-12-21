<?php $dest = $node['destination']; if (isset($pages[$dest])): ?>
    <?=trans($config['nodeTypes']['page'])?>
    <a href="<?=url("/admin/page/$dest/edit")?>">
        <?=e($pages[$dest]['name'])?>
    </a>
<?php else: ?>
    <span class="text-danger">
        <?=trans('Kieruje do nieistniejącej strony!')?>
    </span>
<?php endif ?>
