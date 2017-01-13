<tr>
    <td>
        <img src="<?=GC\Model\Staff\Staff::getAvatarUrl($staff, 30)?>"
            height="30" style="margin-right:5px"/>

        <a href="<?=GC\Url::mask("/{$staff_id}/edit")?>"
            title="<?=$trans('Edytuj pracownika')?>">
            <?=e($staff['name'])?>
        </a>
    </td>
    <td>
        <?php foreach ($groups as $group_id => $group): ?>
            <a href="<?=GC\Url::mask("/group/{$group_id}/edit")?>"
                title="<?=$trans('Przejdź do grupy')?>">
                <?=$trans($group)?></a><br>
        <?php endforeach ?>
    </td>
    <td>
        <?php foreach ($permissions as $permission): ?>
            <?=$trans(GC\Container::get('config')['permissions'][$permission])?> <br>
        <?php endforeach ?>
    </td>
    <td class="text-right">
        <a data-toggle="modal"
            data-id="<?=e($staff_id)?>"
            data-name="<?=e($staff['name'])?>"
            data-target="#deleteModal"
            title="<?=$trans('Usuń pracownika')?>"
            class="btn btn-danger btn-md">
            <i class="fa fa-times fa-fw"></i>
            <?=$trans("Usuń")?>
        </a>
    </td>
</tr>
