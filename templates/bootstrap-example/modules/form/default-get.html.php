<?php
$form_id = $content;
$fields = GC\Model\Form\Field::joinAllWithKeyByForeign($form_id);
?>

<form id="form_<?=$form_id?>" action="" method="post" class="form-horizontal">
    <?php foreach ($fields as $field_id => $field): $fieldType = $field['type']; ?>
        <?=render(TEMPLATE_PATH."/modules/form/default/{$fieldType}.html.php", [
            'name' => "formField_$field_id",
            'field_id' => $field_id,
            'field' => $field,
            'settings' => json_decode($field['settings'], true),
        ])?>
    <?php endforeach ?>

    <div class="text-center">
        <button
            type="submit"
            name="formSubmit_<?=$form_id?>"
            value="1"
            class="btn btn-success btn-md">
            <?=$trans('Wyślij')?>
        </button>
    </div>
</form>
