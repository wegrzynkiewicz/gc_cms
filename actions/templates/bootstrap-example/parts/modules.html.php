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
