<?php $dest = $node['destination']; if (isset($pages[$dest])): ?>
    <?=trans($config['nodeTypes']['page'])?>
    <?=makeLink('/admin/page/edit/'.$dest, $pages[$dest]['name'])?>
<?php else: ?>
    <span class="text-danger">
        <?=trans('Kieruje do nieistniejącej strony!')?>
    </span>
<?php endif ?>
