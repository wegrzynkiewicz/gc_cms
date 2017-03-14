<?php $modules = GC\Model\Module::joinAllWithKeyByForeign($frame_id); ?>
<?php if (empty($modules)): ?>
    <div class="container">
        <?=trans('Nie znaleziono modułów')?>
    </div>
<?php else: ?>
    <?=render(TEMPLATE_PATH.'/_parts/module/loop.html.php', [
        'frame' => $frame,
        'modules' => $modules,
        'container' => $container,
    ])?>
<?php endif ?>
