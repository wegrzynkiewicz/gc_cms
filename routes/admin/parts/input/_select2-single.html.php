<?php
$selectedValue = post($name);
$errorMessage = (isset($error) and isset($error[$name])) ? $error[$name] : null;
?>
<div class="form-group <?=$errorMessage ? 'has-error' : ''?>">
    <?php if (isset($label)): ?>
        <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
            <?=$label?>
        </label>
    <?php endif ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=$name?>"
            name="<?=$name?>"
            class="form-control">

            <?php if (isset($placeholder)): ?>
                <option value="" disabled="disabled" <?=selected(!$selectedValue)?>></option>
            <?php endif ?>

            <?php foreach ($options as $value => $caption): ?>
                <option value="<?=e($value)?>" <?=selected($value == $selectedValue)?>>
                    <?=$caption?>
                </option>
            <?php endforeach; ?>

        </select>

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

<script>
    $(function() {
        $("#<?=$name?>").select2({
            <?php if ($placeholder ?? false): ?>
                placeholder: "<?=$placeholder?>",
            <?php endif ?>
            width: '100%',
            theme: "bootstrap",
            <?php if ($hideSearch ?? false): ?>
                minimumResultsForSearch: -1
            <?php endif ?>
        });
    });
</script>
