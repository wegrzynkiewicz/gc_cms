<?php

$forms = GC\Model\Form::selectAllCorrectWithPrimaryKey();
$counts = GC\Model\FormSent::selectSumStatusForFormId();

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($forms)): ?>
                <?=trans('Nie znaleziono żadnego formularza w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
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
                            <tr>
                                <td><?=e($form['name'])?></td>
                                <td>
                                    <span class="label label-warning">
                                        <?=e($counts[$form_id]['unread'])?>
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="<?=url("/admin/form/received/list/$form_id")?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-search fa-fw"></i>
                                        <?=trans('Pokaż nadesłane')?>
                                    </a>
                                    <a href="<?=url("/admin/form/field/list/$form_id")?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-file-text-o fa-fw"></i>
                                        <?=trans('Pola formularza')?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?=view('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
