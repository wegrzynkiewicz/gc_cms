<?php $type = isset($type) ? $type : 'text' ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <input
            id="<?=e($name)?>"
            name="<?=e($name)?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=trans($placeholder)?>"
            <?php endif ?>
            value="<?=e(inputValue($name))?>"
            type="<?=e($type)?>"
            autocomplete="off"
            class="form-control input">
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>