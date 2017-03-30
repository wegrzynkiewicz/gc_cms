<?php

$mail->Subject = trans('%s został wykorzystany w serwisie %s', [$form['name'], $_SERVER['HTTP_HOST']]);

require ROUTES_PATH.'/admin/parts/email/_header.html.php'; ?>

<div class="title">
    <?=e($form['name'])?>
</div>
<br>
<div class="body-text">
    <?=trans('Została wysłana wiadomość na Twój adres email.')?><br>
    <br>
    <b><?=trans('Treść wiadomości')?></b><br>
    <br>
    <table border="1" cellpadding="6" style="width:100%;border-collapse:collapse;">
        <?php foreach ($data as $label => $value): ?>
            <tr>
                <td><?=$label?></td>
                <td><?=$value?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <br>
    <?php require ROUTES_PATH.'/admin/parts/email/_localization.html.php'; ?>
    <br>
    <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    <br>
</div>

<?php require ROUTES_PATH.'/admin/parts/email/_footer.html.php'; ?>
