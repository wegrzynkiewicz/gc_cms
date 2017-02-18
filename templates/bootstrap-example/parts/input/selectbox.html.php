<?php $selectValue = post($name) ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=e($name)?>"
            name="<?=e($name)?>"
            class="form-control input"
            type="text">

            <?php if (isset($firstOption)): ?>
                <option value="" disabled="disabled" <?=selected('' == $selectValue)?>>
                    <?=$firstOption?>
                </option>
            <?php endif ?>

            <?php foreach ($options as $value => $caption): ?>
                <option value="<?=e($value)?>" <?=selected($value == $selectValue)?>>
                    <?=$caption?>
                </option>
            <?php endforeach; ?>

        </select>
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
    </div>
</div>
