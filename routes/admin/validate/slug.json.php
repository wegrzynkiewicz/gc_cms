<?php

require ROUTES_PATH."/admin/_import.php";

try {
    $frame_id = GC\Validation\Optional::int('frame_id') ?? 0;
    GC\Validation\Required::slug('slug', $frame_id);
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
