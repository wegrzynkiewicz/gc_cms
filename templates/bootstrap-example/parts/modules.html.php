<?php if (isset($frame_id)): ?>
    <?=templateView("/parts/modules-loop.html.php", [
        'modules' => GC\Model\FrameModule::selectAllByFrameId($frame_id)
    ])?>
<?php else: ?>
<?php endif ?>
