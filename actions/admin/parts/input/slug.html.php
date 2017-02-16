<?php
$errorMessage = (isset($error) and isset($error[$name])) ? $error[$name] : null;
?>
<div class="form-group <?=$errorMessage ? 'has-error' : ''?>">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon2">
                <?=e($_SERVER['HTTP_HOST'])?>
            </span>
            <input
                id="<?=$name?>_source"
                name="<?=$name?>"
                <?php if (isset($placeholder)): ?>
                    placeholder="<?=$placeholder?>"
                <?php endif ?>
                class="form-control input"
                value="<?=e(post($name))?>"
                type="text">
        </div>
        <?php if ($errorMessage): ?>
            <span class="help-block">
                <?=$errorMessage?>
            </span>
        <?php elseif (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
    </div>
</div>
