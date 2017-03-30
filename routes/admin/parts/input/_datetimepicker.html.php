<?php $type = isset($type) ? $type : 'text'; ?>
<div class="form-group">
    <?php if (isset($label)): ?>
        <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
            <?=$label?>
        </label>
    <?php endif ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="input-group date">
            <input id="<?=$name?>"
            name="<?=$name?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=$placeholder?>"
            <?php endif ?>
            value="<?=e(post($name))?>"
            type="text"
            autocomplete="off"
            class="form-control input">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#<?=$name?>').datetimepicker({
            locale: '<?=getVisitorLang()?>',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
</script>
