<?php if (isset($node['frame_id'])): ?>
    <?=$trans($config['nodeTypes']['page'])?>
    <a href="<?=$node->getUri()?>">
        <?=e($node['frame_name'])?>
    </a>

    <span style="margin-left: 30px">
        <?=$trans($config['navNodeTargets'][$node['target']])?>
    </span>
<?php else: ?>
    <span class="text-danger">
        <?=$trans('Kieruje do nieistniejącej strony!')?>
    </span>
<?php endif ?>
