<?php
$image = empty($image)
    ? $config['noImageUri']
    : $image;
?>

<tr>
    <td style="width:64px">
        <img src="<?=$uri->root(thumbnail($image, 64, 64))?>" width="64"/>
    </td>
    <td>
        <a href="<?=$uri->mask("/{$frame_id}/edit")?>"
            title="<?=trans('Edytuj ten podział')?>">
            <?=e($name)?></a>
    </td>
    <td>
        <a href="<?=$uri->mask($slug)?>"
            title="<?=trans('Podejrzyj ten podział')?>"
            target="_blank">
            <?=$slug?></a>
    </td>
    <td>
        <?php if ($tree and $tree->hasChildren()): ?>
            <div style="margin-left:-20px">
                <?=render(ROUTES_PATH.'/admin/frame/_parts/tree-taxonomy-preview.html.php', [
                    'tree' => $tree,
                ])?>
            </div>
        <?php else: ?>
            <?=trans('Ten podział nie posiada węzłów.')?>
        <?php endif ?>
    </td>
    <td class="text-right">

        <a href="<?=$uri->mask("/{$frame_id}/module/grid")?>"
            title="<?=trans('Wyświetl moduły podziału')?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-table fa-fw"></i>
            <?=trans('Moduły')?>
        </a>

        <a href="<?=$uri->mask("/{$frame_id}/tree")?>"
            title="<?=trans('Wyświetl węzły podziału')?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-sitemap fa-fw"></i>
            <?=trans('Węzły')?>
        </a>

        <a data-toggle="modal"
            data-id="<?=$frame_id?>"
            data-name="<?=e($name)?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń węzły podziału')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</tr>
