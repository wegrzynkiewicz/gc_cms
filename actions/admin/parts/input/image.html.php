<?php
    $value = inputValue($name);
    $preview = empty($value) ? assetsUrl($config['noImagePath']): $value;
?>

<div class="form-group">

    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=trans($label)?>
    </label>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="col-md-2 image_page_preview">
                <img id="<?=$name?>_preview" src="<?=$preview?>"/>
            </div>

            <div class="col-md-10">
                <input
                    id="<?=$name?>_source"
                    name="<?=$name?>"
                    <?php if (isset($placeholder)): ?>
                        placeholder="<?=trans($placeholder)?>"
                    <?php endif ?>
                    class="form-control input"
                    value="<?=escape($value)?>"
                    type="text">
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
            title: '<?=trans('Wybierz pliki')?>',
            lang: '<?=$config['lang']?>',
            url: '<?=rootUrl('/admin/elfinder/connector')?>'
        }, function(file) {
            $('#<?=$name?>_preview').attr('src', file);
            $('#<?=$name?>_source').val(file);
        });

        $('#<?=$name?>_delete').click( function(){
            $('#<?=$name?>_preview').attr('src', '<?=rootUrl($config['noImagePath'])?>');
            $('#<?=$name?>_source').val('');
        })
    });
</script>
