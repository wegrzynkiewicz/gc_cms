<?php
$errorMessage = (isset($error) and isset($error[$name])) ? $error[$name] : null;
?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <textarea
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
