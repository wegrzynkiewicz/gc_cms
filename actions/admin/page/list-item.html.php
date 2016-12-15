<tr>
    <td>
        <?php if ($page['image']): ?>
            <img src="<?=GC\Thumb::make($page['image'], 64, 64)?>"
            height="64" style="margin-right:5px"/>
        <?php endif ?>
        <a href="<?=url("/admin/page/edit/$page_id")?>"
            title="<?=trans('Edytuj stronę')?>">
            <?=e($page['name'])?>
        </a>
    </td>
    <td class="text-right">

        <a href="<?=url("/admin/page/module/list/$page_id")?>"
            title="<?=trans('Wyświetl moduły strony')?>"
            class="btn btn-success btn-xs">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans("Moduły")?>
        </a>

        <a data-toggle="modal"
            data-id="<?=e($page_id)?>"
            data-name="<?=e($page['name'])?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń stronę')?>"
            class="btn btn-danger btn-xs">
            <i class="fa fa-times fa-fw"></i>
            <?=trans("Usuń")?>
        </a>

    </td>
</tr>
