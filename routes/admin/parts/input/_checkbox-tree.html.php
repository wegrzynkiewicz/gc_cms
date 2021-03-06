<div class="form-group">
    <label class="col-md-12 col-sm-12 col-xs-12">
        <?=$label?>
    </label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php if (isset($help)): ?>
            <span class="help-block">
                <?=$help?>
            </span>
        <?php endif ?>
        <?php if ($tree->hasChildren()): ?>
            <div id="taxonomy_<?=e($id)?>">
                <?=render(ROUTES_PATH."/admin/parts/input/_checkbox-tree-item.html.php", [
                    'tree' => $tree,
                    'name' => $name,
                    'checkedValues' => $checkedValues,
                ])?>
            </div>
        <?php else:?>
            <p>
                <?=trans('Brak węzłów')?>
            </p>
        <?php endif?>
    </div>
</div>

<script>
$(function(){
    $('#taxonomy_<?=e($id)?> .tree-checkbox').change(function() {
        if (!$(this).prop('checked')) {
            $(this)
                .closest('.tree-checkbox-container')
                .find('[type="checkbox"]')
                .not($(this))
                .prop('checked', false);
        }

        var $treeCheckbox = $(this).closest('.tree-checkbox-wrapper').parent();
        while ($treeCheckbox.length > 0) {
            var $treeCheckbox = $treeCheckbox
                .children('.checkbox')
                .find('[type="checkbox"]')
                .prop('checked', true)
                .closest('.tree-checkbox-wrapper')
                .parent();
        }
    });
});
</script>
