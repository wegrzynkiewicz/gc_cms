<?php
$content = json_decode($module['content'], true);
$module['images'] = ImageModel::pobierz_zdjecia_dla_galerii($content['gallery_id']);
