<?php

$widgets = GC\Model\Widget::selectAllCorrectWitPrimaryId();

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($widgets)): ?>
            <p>
                <?=trans('Nie znaleziono żadnych widżetów w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-4 col-lg-4">
                            <?=trans('Nazwa widżetu')?>
                        </th>
                        <th class="col-md-8 col-lg-8">
                            <?=trans('Rodzaj')?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($widgets as $widget_id => $widget): ?>
                        <tr>
                            <td>
                                <a href="<?=url("/admin/widget/edit/$widget_id")?>"
                                    title="<?=trans('Edytuj widżet')?>">
                                    <?=e($widget['name'])?>
                                </a>
                            </td>
                            <td>
                                <?=trans($config['widgetTypes'][$widget['type']])?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
    $(function(){
        $('[data-table]').DataTable();
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
