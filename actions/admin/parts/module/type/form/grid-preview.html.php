<?php
$form = GC\Model\Form\Form::selectByPrimaryId($content);
?>

<?=trans('Wyświetla:')?> <a href="<?=GC\Url::mask('/admin/form/field/list/'.$form['form_id'])?>"><?=e($form['name'])?></a>
