<?php

$mail->Subject = trans('Czy zapomniałeś hasła?');

require ACTIONS_PATH.'/admin/parts/email/header.html.php'; ?>

<div class="title">
    <?=trans('Witaj')?> <?=e($name)?>!
</div>
<br>
<div class="body-text">
    <?=trans('Na ten adres została wysłana prośba o wygenerowanie nowego hasła.')?><br>
    <?=trans('Jeżeli niczego nie robiłeś, to po prostu zignoruj tą wiadomość.')?>
    <br>
    <br>
    <?=trans('Jeżeli chcesz wygenerować nowe hasło kliknij poniższy link')?><br>
    <a href="<?=e($regenerateUrl)?>"><?=e($regenerateUrl)?></a><br>
    <br>
    <?=trans('Ten link jest aktywny tylko przez jedną godzinę')?><br>
    <br>
    <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    <br>
</div>

<?php require ACTIONS_PATH.'/admin/parts/email/footer.html.php'; ?>
