<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=$name?>"
            name="<?=$name?>[]"
            multiple="multiple"
            class="form-control input">

            <?php foreach ($options as $value => $caption): ?>
                <option value="<?=e($value)?>" <?=selected(in_array($value, $selectedValues))?>>
                    <?=$trans($caption)?>
                </option>
            <?php endforeach; ?>

        </select>
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>

<script>
    $(function() {
        $("#<?=$name?>").select2({
            <?php if (isset($placeholder)): ?>
                placeholder: "<?=$trans($placeholder)?>",
            <?php endif ?>
            allowClear: true
        });
    });
</script>
