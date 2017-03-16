<?php

$frames = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

?>

<?php if (empty($frames)): ?>
    <?=trans('Moduł nie zawiera treści, które mogłyby być wyświetlone.')?>
<?php else: ?>
    <?php foreach ($frames as $frame_id => $frame): ?>
        <a href="<?=$uri->make("/admin/frame/{$frame_id}/edit")?>">
            <?=$frame['name']?> - <?=$config['frames'][$frame['type']]['name']?></a>,
    <?php endforeach ?>
<?php endif ?>
