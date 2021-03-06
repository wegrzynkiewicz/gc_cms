<?php
$errorMessage = (isset($error) and isset($error[$name])) ? $error[$name] : null;
?>
<div class="form-group">
    <?php if (isset($label)): ?>
        <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
            <?=$label?>
        </label>
    <?php endif ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <textarea
            id="<?=$name?>"
            name="<?=$name?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=$placeholder?>"
            <?php endif ?>
            class="form-control input-l vertical_resize"><?=e(post($name))?></textarea>
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
