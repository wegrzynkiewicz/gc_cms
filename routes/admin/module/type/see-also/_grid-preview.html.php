<?php

$frames = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

?>

<?php if (empty($frames)): ?>
    <?=trans('Moduł nie zawiera treści, które mogłyby być wyświetlone.')?>
<?php else: ?>
    <?php foreach ($frames as $frame): ?>
        <?=$frame['name']?> - <?=$config['frames'][$frame['type']]['name']?>,<br>
    <?php endforeach ?>
<?php endif ?>
