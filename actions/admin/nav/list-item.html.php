<?php $tree = GC\Model\Menu::buildTreeByTaxonomyId($nav_id) ?>
<tr>
    <td><?=e($nav['name'])?></td>
    <td>
        <?php if ($tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=GC\Render::action('/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $tree,
                    'taxonomyUrl' => function($path) use ($surl, $nav_id) {
                        return $surl("/$nav_id/menu$path/");
                    },
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ta nawigacja nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=$surl("/$nav_id/menu/list")?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Węzły nawigacji')?>
        </a>
    </td>
</tr>
