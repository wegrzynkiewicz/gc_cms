<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

$rows = GC\Model\Module\Row::select()
    ->fields(['position', 'type', 'gutter', 'bg_image', 'bg_color'])
    ->equals('frame_id', $frame_id)
    ->fetchByKey('position');

foreach ($rows as &$row) {
    if ($row['gutter'] == 30) {
        unset($row['gutter']);
    }
    $preview = empty($row['bg_image']) ? $config['noImageUri']: $row['bg_image'];
    $row['thumbnail'] = $uri->root(thumbnail($preview, 41, 41));
}
unset($row);

echo json_encode($rows, JSON_UNESCAPED_UNICODE);
