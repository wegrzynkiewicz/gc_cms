<li id="node_<?=$field_id?>" data-id="<?=$field_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <a href="<?=$uri->make("/admin/form/field/{$field_id}/edit")?>">
                <?=e($name)?>
            </a>
        </div>

        <div class="pull-right">
            <a data-toggle="modal"
                data-id="<?=$field_id?>"
                data-name="<?=e($name)?>"
                data-target="#deleteModal"
                title="<?=trans('Usuń węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=trans('Usuń')?>
            </a>
        </div>

        <div class="pull-right" style="margin-right: 30px">
            <?=trans($config['formFieldTypes'][$type])?>
        </div>

        <div class="clearfix"></div>
    </div>

</li>
