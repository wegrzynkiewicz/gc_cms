<?php
$attributes['class'] = ($attributes['class'] ?? '').' form-control input';
$attributes['type'] = ($attributes['type'] ?? 'text');
?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="input-group">
            <span class="input-group-addon">
                <?=e($_SERVER['HTTP_HOST'])?>
            </span>
            <input
                id="<?=$name?>"
                name="<?=$name?>"
                <?php foreach ($attributes ?? [] as $attrName => $attrValue): ?>
                    <?=$attrName?><?=$attrValue ? '="'.$attrValue.'"' : ''?>
                <?php endforeach ?>
                data-validation-error-msg-container="#error-<?=$name?>"
                value="<?=e(post($name))?>"
                type="text">
        </div>

        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>

        <div id="error-<?=$name?>"></div>
    </div>
</div>
