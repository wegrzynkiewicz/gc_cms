<?php $lang = (isset($lang) and $lang != null) ? $lang : $_SESSION['lang']['editor'] ?>
<span class="flag-icon flag-icon-<?=$config['flags'][$lang]?>"></span>
<?=trans($config['langs'][$lang])?>
