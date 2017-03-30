<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/widget/_import.php";

$widgets = GC\Model\Widget::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($widgets)): ?>
                <?=trans('Nie znaleziono żadnych widżetów w języku: ')?>
                <?=render(ROUTES_PATH."/admin/parts/_language.html.php", [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
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
                                    <a href="<?=$uri->make("/admin/widget/{$widget_id}/edit")?>"
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
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/assets/_footer.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
