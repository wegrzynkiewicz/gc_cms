<?php
$staffName = e($staff['name']);
$avatarUrl = empty($staff['avatar'])
    ? GC\Url::assets($config['avatar']['noAvatarUrl'])
    : GC\Thumb::make($staff['avatar'], 40, 40);
?>
<tr>
    <td>
        <img src="<?=$avatarUrl?>"
            height="40" style="margin-right:5px"/>

        <a href="<?=GC\Url::mask("/{$staff_id}/edit")?>"
            title="<?=$trans('Edytuj pracownika')?>">
            <?=$staffName?>
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
            <?=$trans(GC\Data::get('config')['permissions'][$permission])?> <br>
        <?php endforeach ?>
    </td>
    <td class="text-right">
        <a data-toggle="modal"
            data-id="<?=$staff_id?>"
            data-name="<?=$staffName?>"
            data-target="#deleteModal"
            title="<?=$trans('Usuń pracownika')?>"
            class="btn btn-danger btn-md">
            <i class="fa fa-times fa-fw"></i>
            <?=$trans("Usuń")?>
        </a>
    </td>
</tr>
