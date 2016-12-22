<?php

$items = GC\Model\ModuleItem::selectAllWithFrameByModuleId($module_id);
?>

<?php if (count($items)): ?>
    <div id="tabs_<?=$module_id?>">
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($items as $item_id => $item): ?>
                <li role="presentation">
                    <a href="#tab_<?=$item_id?>" aria-controls="tab_<?=$item_id?>" role="tab" data-toggle="tab">
                        <?=e($item['name'])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($items as $item_id => $item): ?>
                <div role="tabpanel" class="tab-pane" id="tab_<?=$item_id?>">
                    <?=templateView('/parts/modules.html.php', [
                        'frame_id' => $item['frame_id'],
                        'withoutContainer' => true,
                    ])?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $('#tabs_<?=$module_id?> a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            $('#tabs_<?=$module_id?> a:first').tab('show') ;

            var url = document.location.toString();
            var prefix = "#tab_";

            if (url.match(prefix)) {
                $('#tabs_<?=$module_id?> a[href="'+prefix+url.split(prefix)[1]+'"]').tab('show') ;
            }
        });
    </script>
<?php endif ?>