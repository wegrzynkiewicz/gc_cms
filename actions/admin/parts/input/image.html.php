<?php
    $value = inputValue($name);
    $preview = empty($value) ? GC\Url::assets($config['noImageUrl']): $value;
?>

<div class="form-group">

    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=trans($label)?>
    </label>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="col-md-2 image_page_preview">
                <img id="<?=e($name)?>_preview" src="<?=e($preview)?>"/>
            </div>

            <div class="col-md-10">

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon2">
                        <?=e($_SERVER['HTTP_HOST'])?>
                    </span>
                    <input
                        id="<?=e($name)?>_source"
                        name="<?=e($name)?>"
                        <?php if (isset($placeholder)): ?>
                            placeholder="<?=trans($placeholder)?>"
                        <?php endif ?>
                        class="form-control input"
                        value="<?=e($value)?>"
                        type="text">
                </div>
                <br/>
                <button type="button" id="<?=e($name)?>_select" class="btn btn-primary btn-xs">
                    <i class="fa fa-cog fa-fw"></i>
                    <?=trans('Wybierz zdjęcie')?>
                </button>
                <button type="button" id="<?=e($name)?>_delete" class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=trans('Usuń zdjęcie')?>
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {

        $('#<?=e($name)?>_select').elfinderInput({
            title: '<?=trans('Wybierz plik')?>'
        }, function(file) {
            $('#<?=e($name)?>_preview').attr('src', file);
            $('#<?=e($name)?>_source').val(file);
        });

        $('#<?=e($name)?>_delete').click( function(){
            $('#<?=e($name)?>_preview').attr('src', '<?=GC\Url::assets($config['noImageUrl'])?>');
            $('#<?=e($name)?>_source').val('');
        })
    });
</script>
