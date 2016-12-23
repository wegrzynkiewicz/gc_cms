<?php $modules = GC\Model\Module::joinAllWithKeyByForeign($frame_id) ?>
<?php if (empty($modules)): ?>
    <div class="container">
        <?=trans("Nie znaleziono modułów")?>
    </div>
<?php else: ?>
    <?=GC\Render::template("/parts/modules-loop.html.php", [
        'modules' => $modules,
        'container' => $container,
    ])?>
<?php endif ?>
