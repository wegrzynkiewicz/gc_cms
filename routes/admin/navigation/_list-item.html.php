<tr>
    <td>
        <a href="<?=$uri->make("/admin/navigation/{$navigation_id}/edit")?>"
            title="<?=trans('Edytuj nawigację')?>">
            <?=e($name)?></a>
    </td>
    <td>
        <?php if (isset($tree) and $tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ROUTES_PATH."/admin/navigation/_tree-preview.html.php", [
                    'tree' => $tree
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ta nawigacja nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$uri->make("/admin/navigation/{$navigation_id}/node/tree")?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-sitemap fa-fw"></i>
            <?=trans('Węzły nawigacji')?>
        </a>

        <a data-toggle="modal"
            data-id="<?=$navigation_id?>"
            data-name="<?=e($name)?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń nawigację')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</tr>
