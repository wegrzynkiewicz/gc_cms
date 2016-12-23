<?php
$status = $config['formStatuses'][$message['status']];
?>

<tr class="<?=$status['class']?>">
    <td>
        <?=e($message['name'])?>
    </td>
    <td>
        <span class="">
            <?=trans($status['name'])?>
        </span>
    </td>
    <td><?=e($message['sent_date'])?></td>
    <td class="text-right">
        <a href="<?=GC\Url::mask("/$sent_id/show")?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=trans('Podgląd')?>
        </a>

        <a data-toggle="modal"
            data-id="<?=e($sent_id)?>"
            data-name="<?=e($message['name'])?>"
            data-target="#deleteModal"
            title="<?=trans('Usuń wiadomość')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans("Usuń")?>
        </a>
    </td>
</tr>
