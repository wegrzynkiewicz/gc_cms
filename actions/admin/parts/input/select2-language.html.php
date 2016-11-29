<?php $selectedValue = inputValue($name) ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=$name?>"
            name="<?=$name?>"
            class="form-control input">

            <?php foreach ($config['langs'] as $value => $caption): ?>
                <option value="<?=$value?>" data-flag="<?=$config['flags'][$value]?>"
                    <?=selected($selectedValue == $value)?>>
                    <?=trans($caption)?>
                </option>
            <?php endforeach; ?>

        </select>
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>

<script>
    $(function() {
        function format (state) {
            return '<span><span class="flag-icon flag-icon-'+$(state.element).attr('data-flag')+'"></span> '+state.text+'</span>'
        }

        $("#<?=$name?>").select2({
            templateResult: format,
            templateSelection: format,
            escapeMarkup: function(m) {
                return m;
            }
        });
    });
</script>
