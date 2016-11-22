<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12" for="<?=$name?>">
        <?=trans($label)?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <input
            id="<?=$name?>"
            name="<?=$name?>"
            <?php if (isset($placeholder)): ?>
                placeholder="<?=trans($placeholder)?>"
            <?php endif ?>
            value="<?=escape(inputValue($name))?>"
            type="text"
            class="form-control input">
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=trans($help)?>
            </span>
        <?php endif ?>
    </div>
</div>