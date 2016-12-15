<div class="col-md-<?=$w?> col-md-offset-<?=$o?>" style="background-color: <?=randomColor()?>">
    <div id="module_<?=$module['module_id']?>">
        <?=templateView(
            sprintf(
                "/modules/%s-%s.html.php",
                $module['type'], $module['theme']
            ),
            $module['templateArgs'])?>
    </div>
</div>
