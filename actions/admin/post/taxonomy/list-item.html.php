<tr>
    <td>
        <?=e($taxonomy['name'])?>
    </td>
    <td>
        <?php if ($tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ACTIONS_PATH.'/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $tree,
                    'taxonomyUrl' => function($path) use ($tax_id) {
                        return $uri->mask("/{$tax_id}/node{$path}");
                    },
                ])?>
            </div>
        <?php else: ?>
            <?=$trans('Ten podział nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$uri->mask("/{$tax_id}/node/tree")?>"
            title="<?=$trans('Wyświetl węzły podziału')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=$trans('Węzły')?>
        </a>
    </td>
</tr>
