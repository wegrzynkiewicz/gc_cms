<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(request('frame_id'));
$slug = request('slug');

try {
    GC\Validation\Assert::slug($slug, $frame_id);
    $response = [
        'valid' => true,
    ];
} catch (GC\Exception\AssertException $exception) {
    $response = [
        'valid' => false,
        'message' => $exception->getMessage(),
    ];
}

echo json_encode($response);
