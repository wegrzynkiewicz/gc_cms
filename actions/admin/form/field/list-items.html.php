<?php foreach ($fields as $field_id => $node): ?>

    <li id="node_<?=e($field_id)?>" data-id="<?=e($field_id)?>">
        <div class="sortable-content">
            <div class="col-lg-4">
                <a href="<?=GC\Url::mask("/$field_id/edit")?>">
                    <?=e($node['name'])?>
                </a>
            </div>

            <div class="pull-right">
                <a data-toggle="modal"
                    data-id="<?=e($field_id)?>"
                    data-name="<?=e($node['name'])?>"
                    data-target="#deleteModal"
                    title="<?=$trans('Usuń węzeł')?>"
                    class="btn btn-danger btn-xs">
                    <i class="fa fa-times fa-fw"></i>
                    <?=$trans('Usuń')?>
                </a>
            </div>

            <div class="pull-right" style="margin-right: 30px">
                <?=$trans(GC\Data::get('config')['formFieldTypes'][$node['type']])?>
            </div>

            <div class="clearfix"></div>
        </div>

    </li>

<?php endforeach?>
