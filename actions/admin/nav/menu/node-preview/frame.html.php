<?php if (isset($node['frame_id'])): ?>

    <?php $frame_id = $node['frame_id']; ?>

    <?=$trans($config['nodeTypes'][$type])?>
    <a href="<?=$uri->make("/admin/{$type}/{$frame_id}/edit")?>">
        <?=e($node['frame_name'])?>
    </a>

    <?=$trans('o adresie')?>

    <a href="<?=$uri->make($node->getSlug())?>">
        <?=$node->getSlug()?></a>

    <span style="margin-left: 30px">
        <?=$trans($config['navNodeTargets'][$node['target']])?>
    </span>

<?php endif ?>
