<?php

$widgets = GC\Model\Widget::select()
    ->equals('lang', GC\Auth\Staff::getEditorLang())
    ->sort('name', 'ASC')
    ->fetchByPrimaryKey();

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($widgets)): ?>
                <?=$trans('Nie znaleziono żadnych widżetów w języku: ')?>
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Auth\Staff::getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th class="col-md-4 col-lg-4">
                                <?=$trans('Nazwa widżetu')?>
                            </th>
                            <th class="col-md-8 col-lg-8">
                                <?=$trans('Rodzaj')?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($widgets as $widget_id => $widget): ?>
                            <tr>
                                <td>
                                    <a href="<?=GC\Url::mask("/{$widget_id}/edit")?>"
                                        title="<?=$trans('Edytuj widżet')?>">
                                        <?=e($widget['name'])?>
                                    </a>
                                </td>
                                <td>
                                    <?=$trans($config['widgetTypes'][$widget['type']])?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
