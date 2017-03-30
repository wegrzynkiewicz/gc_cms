<?php
$value = post($name);
$preview = empty($value) ? $config['imageNotAvailableUri']: $value;
$attributes['class'] = ($attributes['class'] ?? '').' form-control input';
$attributes['type'] = ($attributes['type'] ?? 'text');
?>

<div class="form-group">

    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
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

                <div class="input-group" style="margin-bottom: 20px">
                    <span class="input-group-addon">
                        <?=e($_SERVER['HTTP_HOST'])?>
                    </span>
                    <input
                        id="<?=$name?>"
                        name="<?=$name?>"
                        readonly="readonly"
                        <?php foreach ($attributes ?? [] as $attrName => $attrValue): ?>
                            <?=$attrName?><?=$attrValue ? '="'.$attrValue.'"' : ''?>
                        <?php endforeach ?>
                        data-validation-error-msg-container="#error-<?=$name?>"
                        value="<?=e($value)?>"
                        type="text">
                </div>

                <div id="error-<?=$name?>"></div>

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

        var notAvailable = '<?=$uri->root($config['imageNotAvailableUri'])?>';

        $('#<?=$name?>_select').elfinderInput({
            title: '<?=trans('Wybierz plik')?>',
        }, function(file) {
            $('#<?=$name?>_preview').attr('src', file);
            $('#<?=$name?>').val(file);
        });

        $('#<?=$name?>_delete').click( function(){
            $('#<?=$name?>_preview').attr('src', notAvailable);
            $('#<?=$name?>').val('');
        })
    });
</script>
