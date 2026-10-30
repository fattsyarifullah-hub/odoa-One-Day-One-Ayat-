<?php

require __DIR__ . "/functions/function.php";

session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonInput = file_get_contents('php://input');
    $requestData = json_decode($jsonInput, true);

    if ($requestData) {
        $response = login($requestData);

        if ($response['status'] === 'success') {
            $_SESSION['admin_id'] = $response['admin_id'];
            $_SESSION['admin_nama'] = $response['admin_nama'];

            http_response_code(200);
        } else {
            http_response_code(400);
        }
        
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
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'bukan post woe'
    ]);
}


?>