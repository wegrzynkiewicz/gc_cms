<?php

$mail->Subject = trans("Utworzyliśmy dla Ciebie konto pracownika w serwisie")." ".$_SERVER['HTTP_HOST'];

require_once ACTIONS_PATH.'/admin/parts/email/header.html.php'; ?>

<div class="title">
    <?=trans('Witaj')?> <?=$name?>!
</div>
<br>
<div class="body-text">
    <?=trans('Utworzyliśmy dla Ciebie konto pracownika w serwisie')?>
    <a href="http://<?=$_SERVER['HTTP_HOST']?>"><?=$_SERVER['HTTP_HOST']?></a><br>
    <br>
    <?=trans('Login')?>: <?=escape($login)?><br>
    <?=trans('Hasło')?>: <strong><?=escape($password)?></strong><br>
    <br>
    <?=trans('Możesz przejść teraz do panelu admina')?>
    <a href="http://<?=$_SERVER['HTTP_HOST']?>/admin"><?=$_SERVER['HTTP_HOST']?>/admin</a><br>
    <br>
    <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    <br>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/email/footer.html.php'; ?>
