<tr>
    <td><?=e($name)?></td>
    <td>
        <?php if ($tree and $tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ROUTES_PATH.'/admin/post/taxonomy/_tree-preview.html.php', [
                    'tree' => $tree,
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ten podział nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$uri->mask("/{$tax_id}/node/tree")?>"
            title="<?=trans('Wyświetl węzły podziału wpisów')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Węzły')?>
        </a>
    </td>
</tr>
