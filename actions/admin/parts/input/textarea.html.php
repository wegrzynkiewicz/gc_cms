<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=e($name)?>">
        <?=trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <textarea
            name="<?=e($name)?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=trans($placeholder)?>"
            <?php endif ?>
            class="form-control input-l vertical_resize"><?=e(inputValue($name))?></textarea>
    </div>
</div>
