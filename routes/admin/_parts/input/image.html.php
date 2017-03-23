<?php
    $value = post($name);
    $preview = empty($value) ? $config['imageNotAvailableUri']: $value;
?>

<div class="form-group">

    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>_source">
        <?=$label?>
    </label>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="col-md-2 image_page_preview">
                <img id="<?=$name?>_preview"
                    alt="<?=trans('Podgląd zdjęcia')?>"
                    src="<?=$uri->root(thumbnail($preview, 240, 240))?>"
                    width="240"
                    style="width: 100%; height: 100%"/>
            </div>

            <div class="col-md-10">

                <div class="input-group">
                    <span class="input-group-addon">
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
            $('#<?=$name?>_preview').attr('src', '<?=$uri->root($config['imageNotAvailableUri'])?>');
            $('#<?=$name?>_source').val('');
        })
    });
</script>
