<?php $type = isset($type) ? $type : 'text' ?>
<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=$trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="input-group date">
            <input id="<?=e($name)?>"
            name="<?=e($name)?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=$trans($placeholder)?>"
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
                <?=$trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#<?=e($name)?>').datetimepicker({
            locale: '<?=GC\Auth\Visitor::getLang()?>',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
</script>
