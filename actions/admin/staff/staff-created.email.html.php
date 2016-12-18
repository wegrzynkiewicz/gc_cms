<?php

$mail->Subject = trans("Utworzyliśmy dla Ciebie konto pracownika w serwisie")." ".$_SERVER['HTTP_HOST'];

require ACTIONS_PATH.'/admin/parts/email/header.html.php'; ?>

<div class="title">
    <?=trans('Witaj')?> <?=e($name)?>!
</div>
<br>
<div class="body-text">
    <?=trans('Utworzyliśmy dla Ciebie konto pracownika w serwisie')?>
    <a href="http://<?=e($_SERVER['HTTP_HOST'])?>"><?=e($_SERVER['HTTP_HOST'])?></a><br>
    <br>
    <?=trans('Login')?>: <?=e($login)?><br>
    <?=trans('Hasło')?>: <strong><?=e($password)?></strong><br>
    <br>
    <?=trans('Możesz przejść teraz do panelu admina')?>
    <a href="http://<?=e($_SERVER['HTTP_HOST'])?>/admin"><?=e($_SERVER['HTTP_HOST'])?>/admin</a><br>
    <br>
    <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    <br>
</div>

<?php require ACTIONS_PATH.'/admin/parts/email/footer.html.php'; ?>
