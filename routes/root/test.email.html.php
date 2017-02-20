<?php

$mail->Subject = trans('Zażółć gęślą jaźń, czyli test usługi mailowej');

require ROUTES_PATH.'/admin/parts/email/header.html.php'; ?>

<div class="title">
    <?=trans('Witaj')?>!
</div>
<br>
<div class="body-text">
    <div>
        <?=trans('Wysłaliśmy dla Ciebie testową wiadomość celem przetestowania usługi mailowej.')?><br>
    </div><br>
    <div>
        <?=trans('Czy wiesz, że zdanie "Zażółć gęślą jaźń" jest najbardziej zagęszczonym zdaniem z polskimi znakami diakrytycznymi?')?><br>
    </div><br>
    <div>
        <strong><?=trans('Wiadomość została wygenerowana automatycznie. Prosimy nie odpowiadać')?></strong><br>
    </div><br>
</div>

<?php require ROUTES_PATH.'/admin/parts/email/footer.html.php'; ?>
