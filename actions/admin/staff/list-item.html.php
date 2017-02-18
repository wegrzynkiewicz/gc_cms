<?php
$avatarUri = empty($avatar)
    ? $config['noImageUri']
    : $avatar;
?>
<tr>
    <td>
        <img src="<?=$uri->root(thumbnail($avatarUri, 64, 64))?>"
            width="64"
            height="64"
            style="margin-right:5px"/>

        <a href="<?=$uri->mask("/{$staff_id}/edit")?>"
            title="<?=trans('Edytuj pracownika')?>">
            <?=e($name)?>
        </a>
    </td>
    <td>
        <?php if (isset($groups) and $groups): ?>
            <?php foreach ($groups as $group_id => $group): ?>
                <a href="<?=$uri->mask("/group/{$group_id}/edit")?>"
                    title="<?=trans('Przejdź do grupy')?>">
                    <?=trans($group)?></a><br>
            <?php endforeach ?>
        <?php else: ?>
            <?=trans('Ten pracownik nie jest przypisany do żadnej grupy.')?>
        <?php endif ?>
    </td>
    <td>
        <?php if (isset($permissions) and $permissions): ?>
            <?php foreach ($permissions as $permission): ?>
                <?=trans($config['permissions'][$permission])?> <br>
            <?php endforeach ?>
        <?php else: ?>
            <?=trans('Ten pracownik nie posiada żadnych uprawnień.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a data-toggle="modal"
            data-id="<?=$staff_id?>"
            data-name="<?=e($name)?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń pracownika')?>"
            class="btn btn-danger btn-md">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</tr>
