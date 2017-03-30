<?php

require ROUTES_PATH."/admin/_import.php";

try {
    $staff_id = GC\Validation\Optional::int('staff_id') ?? 0;
    GC\Validation\Required::staffEmail('email', $staff_id);
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
