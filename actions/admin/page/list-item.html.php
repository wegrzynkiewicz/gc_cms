<?php $preview = empty($page['image']) ? assetsUrl($config['noImageUrl']): $page['image']; ?>

<tr>
    <td>
        <img src="<?=GC\Thumb::make($preview, 64, 64)?>" height="64"/>
    </td>

    <td>
        <a href="<?=$surl("/$page_id/edit")?>"
            title="<?=trans('Edytuj stronę')?>">
            <?=e($page['name'])?>
        </a>
    </td>

    <td class="text-right">

        <a href="<?=url("/page/$page_id")?>"
            target="_blank"
            title="<?=trans('Podejrzyj tą stronę')?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=trans("Podgląd")?>
        </a>

        <a href="<?=$surl("/$page_id/module/list")?>"
            title="<?=trans('Wyświetl moduły strony')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans("Moduły")?>
        </a>

        <a data-toggle="modal"
            data-id="<?=e($page_id)?>"
            data-name="<?=e($page['name'])?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń stronę')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans("Usuń")?>
        </a>

    </td>
</tr>
