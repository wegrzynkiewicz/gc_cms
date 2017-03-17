<?=trans($config['navigation']['nodeTypes']['external'])?>
<a href="<?=e($node['destination'])?>">
    <?=e($node['destination'])?>
</a>
<span style="margin-left: 30px">
    <?=trans($config['navigation']['nodeTargets'][$node['target']])?>
</span>
