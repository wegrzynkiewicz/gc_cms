<tr>
    <td><?=e($nav['name'])?></td>
    <td>
        <?php if ($tree and $tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ACTIONS_PATH.'/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $tree,
                    'taxonomyUrl' => function($path) use ($nav_id, &$uri) {
                        return $uri->mask("/{$nav_id}/menu{$path}");
                    },
                ])?>
            </div>
        <?php else: ?>
            <?=$trans('Ta nawigacja nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$uri->mask("/{$nav_id}/menu/tree")?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=$trans('Węzły nawigacji')?>
        </a>
    </td>
</tr>
