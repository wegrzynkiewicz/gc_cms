<?php
$form_id = $content;
$fields = GC\Model\FormField::selectAllByFormId($form_id);

$wasSend = isPost() and isset($_POST["formSubmit_$form_id"]);

if ($wasSend) {
    $form = GC\Model\Form::selectByPrimaryId($form_id);

    $data = [];
    foreach ($fields as $field_id => $field) {
        $data[$field['name']] = def($_POST, "formField_$field_id", '');
    }

    $localization = infoIP(getIP());

    if (count($settings['emails']) > 0) {
        foreach ($settings['emails'] as $email) {
            $mail = new GC\Mail();
            $mail->buildTemplate(
                '/admin/form/posted-form.email.html.php',
                '/admin/parts/email/styles.css', [
                    'form' => $form,
                    'data' => $data,
                    'localization' => $localization,
                ]
            );
            $mail->addAddress($email);
            $mail->send();
        }
    }

    GC\Model\FormSent::insertToForm($form_id, $data, $localization);
}

?>

<?php if ($wasSend): ?>
    <p class="text-success">
        <?=trans('Dziękujemy za wysłanie wiadomości, wkrótce się z Państwem skontaktujemy.')?>
    </p>
<?php else: ?>
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
                <button
                    type="submit"
                    name="formSubmit_<?=$form_id?>"
                    value="1"
                    class="btn btn-success btn-block btn-md">
                    <?=trans('Wyślij')?>
                </button>
            </div>
        </div>
    </form>
<?php endif ?>
