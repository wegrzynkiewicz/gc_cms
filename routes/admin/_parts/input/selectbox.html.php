<?php $selectValue = post($name) ?>
<div class="form-group">
    <?php if (isset($label)): ?>
        <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
            <?=$label?>
        </label>
    <?php endif ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=$name?>"
            name="<?=$name?>"
            class="form-control input">

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
