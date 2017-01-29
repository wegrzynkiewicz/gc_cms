<?php

$form_id = $content;
$fields = GC\Model\Form\Field::joinAllWithKeyByForeign($form_id);

if (!isset($_POST["formSubmit_$form_id"])) {
    require TEMPLATE_PATH.'/modules/form/default-get.html.php';
}

$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);

$data = [];
foreach ($fields as $field_id => $field) {
    $data[$field['name']] = post("formField_$field_id");
}

$localization = infoIP(GC\Auth\Visitor::getIP());

if (count($settings['emails']) > 0) {
    foreach ($settings['emails'] as $email) {
        $mail = new GC\Mail();
        $mail->buildTemplate(
            ACTIONS_PATH.'/admin/form/posted-form.email.html.php',
            ACTIONS_PATH.'/admin/parts/email/styles.css', [
                'form' => $form,
                'data' => $data,
                'localization' => $localization,
            ]
        );
        $mail->addAddress($email);
        $mail->send();
    }
}

GC\Model\Form\Sent::insertToForm($form_id, $data, $localization);

?>
<p class="text-success">
    <?=$trans('Dziękujemy za wysłanie wiadomości, wkrótce się z Państwem skontaktujemy.')?>
</p>
