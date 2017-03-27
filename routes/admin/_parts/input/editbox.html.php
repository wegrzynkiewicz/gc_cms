<?php
$attributes['class'] = ($attributes['class'] ?? '').' form-control input';
$attributes['type'] = ($attributes['type'] ?? 'text');
?>
<div class="form-group">
    <?php if ($label ?? false): ?>
        <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
            <?=$label?>
        </label>
    <?php endif ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <input
            id="<?=$name?>"
            name="<?=$name?>"
            value="<?=e(post($name))?>"
            autocomplete="off"
            <?php foreach ($attributes ?? [] as $attrName => $attrValue): ?>
                <?=$attrName?><?=$attrValue ? '="'.$attrValue.'"' : ''?>
            <?php endforeach ?>
            >
        <?php if ($help ?? false): ?>
            <span id="help-block" class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
    </div>
</div>
