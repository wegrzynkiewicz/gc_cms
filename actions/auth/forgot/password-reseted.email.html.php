<?php

$mail->Subject = trans("Twoje hasło zostało zresetowane");

require_once ACTIONS_PATH.'/admin/parts/email/header.html.php'; ?>

<div class="title">
    <?=trans('Witaj')?> <?=$name?>!
</div>
<br>
<div class="body-text">
    <?=trans('Twoje hasło do konta pracownika zostało zresetowane')?><br>
    <br>
    <?=trans('Login')?>: <?=escape($login)?><br>
    <?=trans('Hasło')?>: <strong><?=escape($password)?></strong><br>
    <br>
    <?=trans('Możesz przejść teraz do panelu admina i zalogować się')?>
    <a href="http://<?=$_SERVER['HTTP_HOST']?>/auth/login"><?=$_SERVER['HTTP_HOST']?>/auth/login</a><br>
    <br>
    <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    <br>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/email/footer.html.php'; ?>
