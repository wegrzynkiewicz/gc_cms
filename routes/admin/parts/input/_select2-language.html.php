<?php $selectedValue = post($name) ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=$name?>"
            name="<?=$name?>"
            class="form-control input">

            <?php foreach ($config['lang']['installed'] as $code => $lang): ?>
                <option value="<?=$code?>" data-flag="<?=$lang['flag']?>"
                    <?=selected($selectedValue == $code)?>>
                    <?=trans($lang['name'])?>
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
            },            
            theme: "bootstrap",
        });
    });
</script>
