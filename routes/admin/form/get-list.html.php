<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/form/_import.php";

$forms = GC\Model\Form\Form::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

$counts = GC\Model\Form\Sent::select()
    ->fields("form_id, SUM(status = 'unread') AS unread")
    ->group('form_id')
    ->fetchByKey('form_id');

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($forms)): ?>
                <?=trans('Nie znaleziono żadnego formularza w języku: ')?>
                <?=render(ROUTES_PATH."/admin/parts/_language.html.php", [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=trans('Nazwa formularza')?></th>
                            <th><?=trans('Nieprzeczytanych')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $form_id => $form): ?>
                            <?=render(ROUTES_PATH."/admin/form/_list-item.html.php", [
                                'form_id' => $form_id,
                                'form' => $form,
                                'counts' => $counts,
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
