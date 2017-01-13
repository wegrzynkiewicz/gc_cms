<?php $base64 = base64_encode($checksum['file']); ?>
<tr class="<?=$checksum['status'] ? 'success' : 'danger'?>">
    <td>
        <a href="<?=GC\Url::make("/root/checksum/show/{$base64}")?>">
            <?=$checksum['file']?>
        </a>
    </td>
    <td><?=$checksum['exists'] ? $checksum['hash'] : 'Brak zapisanej sumy kontrolnej'?></td>
    <td class="text-right">
        <?php if (!$checksum['status']): ?>
            <button
                data-toggle="modal"
                data-id="<?=e($checksum['file'])?>"
                data-name="<?=e($checksum['file'])?>"
                data-target="#refreshModal"
                title="<?=$trans('Odśwież')?>"
                class="btn btn-primary btn-xs">
                <i class="fa fa-refresh fa-fw"></i>
                <?=$trans("Odśwież")?>
            </button>
        <?php endif ?>
    </td>
</tr>
