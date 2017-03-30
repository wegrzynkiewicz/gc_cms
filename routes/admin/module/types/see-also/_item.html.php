<li id="item_<?=$frame_id?>" data-id="<?=$frame_id?>">
    <div class="sortable-content">
        <div class="col-lg-4">
            <a href="<?=$uri->make("/admin/frame/{$frame_id}/edit")?>"
                title="<?=trans('Przejdź do edycji')?>">
                <?=e($name)?></a>
        </div>

        <div class="pull-right">
            <a data-toggle="modal"
                data-id="<?=$frame_id?>"
                data-name="<?=$name?>"
                data-target="#deleteModal"
                title="<?=trans('Wyłącz ten węzeł')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
                <?=trans('Zaprzestań wyświetlania')?>
            </a>
        </div>

        <div class="pull-right" style="margin-right: 30px">
            <?=trans($config['frame']['types'][$type]['name'])?>
            <?php if ($slug): ?>
                <?=trans('o adresie')?>
                <a href="<?=$uri->make($slug)?>"
                    title="<?=trans('Podgląd')?>"
                    target="_blank">
                    <?=$slug?></a>
            <?php endif; ?>
        </div>

        <div class="clearfix"></div>
    </div>
</li>
