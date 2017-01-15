<?php $preview = empty($post['image']) ? GC\Url::assets($config['noImageUrl']): $post['image']; ?>

<tr>

    <td>
        <img src="<?=GC\Thumb::make($preview, 64, 64)?>" height="64"/>
    </td>

    <td>
        <a href="<?=GC\Url::mask("/{$post_id}/edit/")?>"
            title="<?=$trans('Edytuj wpis')?>">
            <?=e($post['name'])?>
        </a>
    </td>

    <td>
        <?=e(transDateTime($post['publication_datetime']))?>
    </td>

    <td>
        <?php if (empty($post['taxonomies'])): ?>
            <?=$trans('Ten wpis nie został nigdzie przypisany')?>
        <?php else: ?>
            <?php foreach($post['taxonomies'] as $tax_id => $tree): ?>
                <a href="<?=GC\Url::mask("/taxonomy/{$tax_id}/node/tree")?>"
                    title="<?=$trans('Przejdź do podziału')?>">
                    <strong>
                        <?=e($taxonomies[$tax_id]['name'])?>:
                    </strong>
                </a>
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/taxonomy-preview.html.php', [
                    'tree' => $tree,
                    'taxonomyUrl' => 'taxonomyNodeUrl',
                ])?>
            <?php endforeach ?>
        <?php endif ?>
    </td>

    <td class="text-right">
        <a href="<?=GC\Url::make("/post/{$post_id}")?>"
            target="_blank"
            title="<?=$trans('Podejrzyj ten wpis')?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=$trans("Podgląd")?>
        </a>

        <a href="<?=GC\Url::mask("/{$post_id}/module/list")?>"
            title="<?=$trans('Wyświetl moduły wpisu')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=$trans("Moduły")?>
        </a>

        <a data-toggle="modal"
            data-id="<?=e($post_id)?>"
            data-name="<?=e($post['name'])?>"
            data-target="#deleteModal"
            title="<?=$trans('Usuń wpis')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=$trans("Usuń")?>
        </a>
    </td>
</tr>
