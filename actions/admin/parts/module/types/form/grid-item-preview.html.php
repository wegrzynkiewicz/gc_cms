<?php
$form = GC\Model\Form::selectByPrimaryId($content);
?>

<?=trans('Wyświetla:')?> <a href="<?=url('/admin/form/field/list/'.$form['form_id'])?>"><?=e($form['name'])?></a>
