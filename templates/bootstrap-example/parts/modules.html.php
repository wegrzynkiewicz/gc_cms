<?php

$gridModules = [];

if (isset($frame_id)) {

    $modules = FrameModule::selectAllByFrameId($frame_id);
    foreach ($modules as $module_id => &$module) {
        list($x, $y, $w, $h) = explode(':', $module['grid']);
        $module['grid'] = [
            'x' => $x,
            'y' => $y,
            'w' => $w,
            'h' => $h,
        ];

        $content = $module['content'];

        $gridModules[$y][$x] = $module;
    }
    unset($module);

    ksort($gridModules);
    foreach ($gridModules as $y => &$row) {
        ksort($row);
        $previousWidth = 0;
        foreach ($row as $x => &$module) {
            $offset = $x - $previousWidth;
            $module['grid']['o'] = $offset;
            $previousWidth = $x + $module['grid']['w'];
        }
        unset($module);
    }
    unset($row);
}

?>

<?php if (empty($gridModules)): ?>

<?php else: ?>
    <?php foreach ($gridModules as $row): ?>
        <div class="row">
            <?php foreach ($row as $module): $grid = $module['grid'];  ?>
                <div class="col-md-<?=$grid['w']?>
                    <?=$grid['o']>0 ? 'col-md-offset-'.$grid['o'] : ''?>">
                    <div id="module_<?=$module['module_id']?>">
                        <?php require sprintf(TEMPLATE_PATH."/modules/%s-%s.html.php", $module['type'], $module['theme']); ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
