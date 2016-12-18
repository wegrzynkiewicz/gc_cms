<?php

$form_id = intval(array_shift($_SEGMENTS));

$messages = GC\Model\FormSent::selectAllCorrectWithPrimaryKeyByFromId($form_id);

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($messages)): ?>
                <?=trans('Nie znaleziono żadnego wysłanego formularza w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            <?php else: ?>
                <form action="" method="post" id="form" class="form-horizontal">
                    <table class="table vertical-middle" data-table="">
                        <thead>
                            <tr>
                                <th><?=trans('Pierwsze pole formularza')?></th>
                                <th><?=trans('Status wiadomości')?></th>
                                <th><?=trans('Data nadesłania')?></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $sent_id => $message): ?>
                                <?=view('/admin/form/received/list-item.html.php', [
                                    'sent_id' => $sent_id,
                                    'form_id' => $form_id,
                                    'message' => $message,
                                    'config' => $config,
                                ])?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </form>
            <?php endif ?>
        </div>
        <?=view('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script>
    $(function(){
        $('[data-table]').DataTable({
            "order": []
        });
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
