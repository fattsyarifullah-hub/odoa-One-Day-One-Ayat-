<?php

require __DIR__ . "/functions/function.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if (isset($_POST)) {
    $jsonInput = file_get_contents('php://input');
    $requestData = json_decode($jsonInput, true);

    if ($requestData) {
        $response = login($requestData);
        echo json_encode([
            'data' => $response
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'format tidak valid'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'bukan post woe'
    ]);
}


?>