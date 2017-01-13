<?php $lang = (isset($lang) and is_array($lang)) ? $lang : GC\Model\Lang::fetchByPrimaryId($_SESSION['lang']['editor']) ?>
<span class="flag-icon flag-icon-<?=e($lang['flag'])?>"></span>
<?=$trans($lang['name'])?>
