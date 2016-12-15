<?=$content?>

<?php
print_r($_POST);





$response = curlReCaptcha();

var_dump($response);


?>

<form action="" method="post">
<div class="g-recaptcha" data-sitekey="<?=getConfig()['reCaptcha']['public']?>"></div>
<button type="submit" name="button">save</button>
<form>
