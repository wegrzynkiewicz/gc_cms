<?php $dest = $node['destination']; ?>
<?php if (isset($pages[$dest])): ?>
    <?=$trans(GC\Data::get('config')['nodeTypes']['page'])?>
    <a href="<?=GC\Url::make("/admin/page/{$dest}/edit")?>">
        <?=e($pages[$dest]['name'])?>
    </a>
<?php else: ?>
    <span class="text-danger">
        <?=$trans('Kieruje do nieistniejącej strony!')?>
    </span>
<?php endif ?>

<span style="margin-left: 30px">
    <?=$trans(GC\Data::get('config')['navNodeTargets'][$node['target']])?>
</span>
