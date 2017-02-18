<?php $type = isset($type) ? $type : 'text' ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <input
            id="<?=e($name)?>"
            name="<?=e($name)?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=$placeholder?>"
            <?php endif ?>
            value="<?=e(post($name))?>"
            type="<?=e($type)?>"
            autocomplete="off"
            class="form-control input">
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
    </div>
</div>
