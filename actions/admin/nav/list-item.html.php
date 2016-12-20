<?php $tree = GC\Model\Menu::buildTreeByTaxonomyId($nav_id) ?>
<tr>
    <td><?=e($nav['name'])?></td>
    <td>
        <?php if ($tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=view('/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $tree,
                    'taxonomyUrl' => function($path) use ($nav_id) {
                        return url("/admin/nav/menu$path/$nav_id");
                    },
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ta nawigacja nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">
        <a href="<?=url("/admin/nav/menu/list/$nav_id")?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Węzły nawigacji')?>
        </a>
    </td>
</tr>
