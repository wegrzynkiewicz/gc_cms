<div class="col-md-<?=e($w)?> col-md-offset-<?=e($o)?>" style="background-color: <?=randomColor()?>">
    <div id="module_<?=e($module['module_id'])?>">
        <?=templateView(
            sprintf(
                "/modules/%s-%s.html.php",
                $module['type'], $module['theme']
            ),
            $module['templateArgs'])?>
    </div>
</div>
