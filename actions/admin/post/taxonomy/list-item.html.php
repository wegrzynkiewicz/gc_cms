<tr>
    <td>
        <?=e($taxonomy['name'])?>
    </td>
    <td>
        <?php if ($tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=view('/admin/post/list-tax-preview.html.php', [
                    'tree' => $tree,
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ten podział nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=taxonomyNodeUrl("/list")?>"
            title="<?=trans('Wyświetl węzły podziału')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans("Węzły")?>
        </a>
    </td>
</tr>
