<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select
            id="<?=e($name)?>"
            name="<?=e($name)?>[]"
            multiple="multiple"
            class="form-control input hideSearch">

            <?php foreach ($options as $caption): ?>
                <option value="<?=e($caption)?>" <?=selected(in_array($caption, $selectedValues))?>><?=trans($caption)?></option>
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
        $("#<?=e($name)?>").select2({
            <?php if (isset($placeholder)): ?>
                placeholder: "<?=trans($placeholder)?>",
            <?php endif ?>
            tags: true,
            minimumResultsForSearch: Infinity
        });
        $('#<?=e($name)?>').on('select2:opening select2:close', function(e){
            $('body').toggleClass('kill-all-select2-dropdowns', e.type=='select2:opening');
        });
    });
</script>

<style media="screen">
    body.kill-all-select2-dropdowns .select2-dropdown {
        display: none !important;
    }
    body.kill-all-select2-dropdowns .select2-container--default.select2-container--open.select2-container--below .select2-selection--single,
    body.kill-all-select2-dropdowns .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }
</style>
