<tr>
    <td>
        <a href="<?=$uri->mask("/{$group_id}/edit")?>"
            title="<?=trans('Edytuj grupę')?>">
            <?=e($group['name'])?>
        </a>
    </td>
    <td>
        <?php if (isset($permissions) and $permissions): ?>
            <?php foreach ($permissions as $permission): ?>
                <?=trans($config['permissions'][$permission])?> <br>
            <?php endforeach ?>
        <?php else: ?>
            <?=trans('Ta grupa nie posiada nadanych żadnych uprawnień.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a data-toggle="modal"
            data-id="<?=$group_id?>"
            data-name="<?=$name?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń grupę')?>"
            class="btn btn-danger btn-md">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</tr>
