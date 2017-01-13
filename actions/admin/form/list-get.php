<?php

$forms = GC\Model\Form\Form::select()
    ->equals('lang', $_SESSION['lang']['editor'])
    ->sort('name', 'ASC')
    ->fetchByPrimaryKey();

$counts = GC\Model\Form\Sent::select()
    ->fields("form_id, SUM(status = 'unread') AS unread")
    ->groupBy('form_id')
    ->fetchByKey('form_id');

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($forms)): ?>
                <?=$trans('Nie znaleziono żadnego formularza w języku: ')?>
                <?=GC\Render::action('/admin/parts/language.html.php')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=$trans('Nazwa formularza')?></th>
                            <th><?=$trans('Nieprzeczytanych')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $form_id => $form): ?>
                            <?=GC\Render::action('/admin/form/list-item.html.php', [
                                'form_id' => $form_id,
                                'form' => $form,
                                'counts' => $counts,
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?=GC\Render::action('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
