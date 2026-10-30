<?php

require __DIR__ . "/functions/function.php";

$data = dashboardIndex();

header('Content-Type: application/json');
http_response_code(200);

echo json_encode([
    'status' => 'success',
    'message' => 'berhasil mengambil data',
    'data' => $data
]);