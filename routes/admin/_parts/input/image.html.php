<?php
    $value = post($name);
    $preview = empty($value) ? $config['noImageUri']: $value;
?>

<div class="form-group">

    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=$label?>
    </label>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="col-md-2 image_page_preview">
                <img id="<?=$name?>_preview" src="<?=$uri->root($preview)?>"/>
            </div>

            <div class="col-md-10">

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon2">
                        <?=e($_SERVER['HTTP_HOST'])?>
                    </span>
                    <input
                        id="<?=$name?>_source"
                        name="<?=$name?>"
                        <?php if (isset($placeholder)): ?>
                            placeholder="<?=$placeholder?>"
                        <?php endif ?>
                        class="form-control input"
                        value="<?=e($value)?>"
                        type="text">
                </div>
                <br/>
                <button type="button" id="<?=$name?>_select" class="btn btn-primary btn-xs">
                    <i class="fa fa-cog fa-fw"></i>
                    <?=trans('Wybierz zdjęcie')?>
                </button>
                <button type="button" id="<?=$name?>_delete" class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=trans('Usuń zdjęcie')?>
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {

        $('#<?=$name?>_select').elfinderInput({
            title: '<?=trans('Wybierz plik')?>',
        }, function(file) {
            $('#<?=$name?>_preview').attr('src', file);
            $('#<?=$name?>_source').val(file);
        });

        $('#<?=$name?>_delete').click( function(){
            $('#<?=$name?>_preview').attr('src', '<?=$uri->root($config['noImageUri'])?>');
            $('#<?=$name?>_source').val('');
        })
    });
</script>
