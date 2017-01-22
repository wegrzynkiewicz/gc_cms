<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=$trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="color_<?=e($name)?>" class="input-group colorpicker-component">
            <span class="input-group-addon">
                <i style="background-color: rgb(0, 0, 0);"></i>
            </span>
            <input
                id="<?=e($name)?>"
                name="<?=e($name)?>"
                value="<?=e(post($name))?>"
                type="text"
                autocomplete="off"
                class="form-control input">
        </div>
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>

<script>
    $(function() {
        $('#color_<?=e($name)?>').colorpicker({
            align: 'left',
            customClass: 'colorpicker-2x',
            sliders: {
                saturation: {
                    maxLeft: 200,
                    maxTop: 200
                },
                hue: {
                    maxTop: 200
                },
                alpha: {
                    maxTop: 200
                }
            }
        });
    });
</script>

<style>
    .colorpicker-2x .colorpicker-saturation {
        width: 200px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-color,
    .colorpicker-2x .colorpicker-color div {
        height: 30px;
    }
</style>
