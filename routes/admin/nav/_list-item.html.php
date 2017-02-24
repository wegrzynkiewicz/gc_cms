<tr>
    <td><?=e($name)?></td>
    <td>
        <?php if (isset($tree) and $tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ROUTES_PATH.'/admin/nav/_tree-preview.html.php', [
                    'tree' => $tree
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ta nawigacja nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$uri->mask("/{$nav_id}/menu/tree")?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Węzły nawigacji')?>
        </a>
    </td>
</tr>
