<?php
$items = GC\Model\Module\Item::joinAllWithFrameByForeign($module_id);
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
                    <?=render(TEMPLATE_PATH, [ //TODO:
                        'frame_id' => $item['frame_id'],
                        'frame' => $item,
                        'container' => false,
                    ])?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $('#tabs_<?=$module_id?>>ul a').on('click', function (e) {
                event.preventDefault()
                $(this).tab('show')
            });

            $('#tabs_<?=$module_id?>>ul a:first').tab('show') ;

            var url = document.location.toString();
            var prefix = "#tab_";

            if (url.match(prefix)) {
                $('#tabs_<?=$module_id?>>ul a[href="'+prefix+url.split(prefix)[1]+'"]').tab('show') ;
            }
            $('document').trigger('resize');
        });
    </script>
<?php endif ?>
