<?php if (isset($frame_id) and intval($frame_id) > 0): ?>
    <?=templateView("/parts/modules-loop.html.php", [
        'modules' => GCC\Model\FrameModule::selectAllByFrameId($frame_id)
    ])?>
<?php else: ?>
<?php endif ?>
