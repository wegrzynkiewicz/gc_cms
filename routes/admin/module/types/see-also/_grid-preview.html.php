<?php

$frames = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

?>
<p class="text-center">
    <?php if (empty($frames)): ?>
        <?=trans('Moduł nie zawiera stron, które mogłyby być wyświetlone')?>
    <?php else: ?>
        <?=trans('Moduł zawiera następujące strony: ')?><br>
        <?php foreach ($frames as $frame_id => $frame): ?>
            <?=$config['frame']['types'][$frame['type']]['name']?>:
            <a href="<?=$uri->make("/admin/frame/{$frame_id}/edit")?>"><?=$frame['name']?></a>,
        <?php endforeach ?>
    <?php endif ?>
</p>
