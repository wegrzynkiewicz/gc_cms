<?php if ($frame_id): ?>
    <?=trans('Kieruj na:')?>
    <?=trans($config['frame']['types'][$frame_type]['name'])?>

    <a href="<?=$uri->make("/admin/{$type}/{$frame_id}/edit")?>">
        <?=e($node['frame_name'])?>
    </a>

    <?=trans('o adresie')?>

    <a href="<?=$uri->make($slug)?>">
        <?=$slug?></a>

    <span style="margin-left: 30px">
        <?=trans($config['navigation']['nodeTargets'][$target])?>
    </span>

<?php endif ?>
