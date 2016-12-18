<?php
$form_id = $content;
$fields = GC\Model\FormField::selectAllByFormId($form_id);


print_r($_POST);
?>

<form id="form_<?=$form_id?>" action="" method="post" class="form-horizontal">
    <?php foreach ($fields as $field_id => $field): $fieldType = $field['type']; ?>
        <?=templateView("/modules/form/default/$fieldType.html.php", [
            'name' => "formField_$field_id",
            'field_id' => $field_id,
            'field' => $field,
            'settings' => json_decode($field['settings'], true),
        ])?>
    <?php endforeach ?>

    <div class="row" style="margin-top:20px">
        <div class="col-md-4 col-md-offset-4 text-center">
            <button type="submit" class="btn btn-success btn-block btn-md">
                <?=trans('Wyślij')?>
            </button>
        </div>
    </div>
</form>
