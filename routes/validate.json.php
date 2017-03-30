<?php

$validator = array_shift($_SEGMENTS);
$validator = lcfirst(implode('', array_map('ucfirst', explode('-', $validator))));

$arguments = [];
$reflectionMethod = new \ReflectionMethod(GC\Validation\Assert::class, $validator);
foreach ($reflectionMethod->getParameters() as $parameter) {
    $arguments[$parameter->getName()] = $_REQUEST[$parameter->getName()] ?? null;
}

try {
    $reflectionMethod->invokeArgs(null, $arguments);
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
