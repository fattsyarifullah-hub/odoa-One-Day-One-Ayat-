<?php

require __DIR__ . "/functions/function.php";

$id = $_GET['id'];

$json = json_decode($id);

$data = showOne($json);

header('Content-Type: application/json');
http_response_code(200);

echo json_encode([
    'status' => 'success',
    'message' => 'berhasil mengambil data',
    'data' => $data
]);
