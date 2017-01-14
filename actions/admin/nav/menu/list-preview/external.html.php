<?=$trans(GC\Data::get('config')['nodeTypes']['external'])?>
<a href="<?=e($node['destination'])?>">
    <?=e($node['destination'])?>
</a>
<span style="margin-left: 30px">
    <?=$trans(GC\Data::get('config')['navNodeTargets'][$node['target']])?>
</span>
