<?php

$tabs = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

?>
<p class="text-center">
    <?php if (empty($tabs)): ?>
        <?=trans('Moduł nie zawiera zakładek, które mogłyby być wyświetlone')?>
    <?php else: ?>
        <?=trans('Moduł zawiera następujące zakładki: ')?><br>
        <?php foreach ($tabs as $frame_id => $frame): ?>
            <a href="<?=$uri->make("/admin/module/grid/{$frame_id}")?>">
                <?=e($frame['name'])?></a>,
        <?php endforeach ?>
    <?php endif ?>
</p>
