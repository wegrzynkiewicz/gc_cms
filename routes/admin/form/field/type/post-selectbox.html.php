<?php

# zapisz meta dane dla pola formularza
GC\Model\Form\Meta::updateMeta($field_id, [
    'options' => json_encode(post('options'), JSON_UNESCAPED_UNICODE),
]);
