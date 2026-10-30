<?php

require __DIR__ . "/../config/config.php";

function connectDB()
{
    $conn = new PDO('mysql:host=localhost;dbname=be_odoa', 'root', '');
    return $conn;
}

function createDatabase()
{
    $conn = connectDB();

    $database = 'create database be_odoa';

    $conn->exec($database);
}

function structureDB()
{
    $conn = connectDB();

    $tableMembers = "create table users (
    id int(11) auto_increment primary key,
    name varchar(100) not null,
    nomor_wa varchar(255) not null,
    created_at datetime default current_timestamp
    )";

    $tableAdmins = "create table admins (
    id int(11) auto_increment primary key,
    name varchar(100) not null,
    email varchar(100) not null unique,
    password varchar(100) not null,
    created_at datetime default current_timestamp
    )";

    $conn->query($tableMembers);
    $conn->query($tableAdmins);
}

function seederAdmin()
{
    $conn = connectDB();

    $hashPassword = password_hash('12345678', PASSWORD_DEFAULT);

    $seederAdmin = "insert into admins (name, email, password) values ('Admin123', 'test@gmail.com' ,'$hashPassword')";

    $conn->query($seederAdmin);
}

connectDB();
// createDatabase();
// structureDB();
// seederAdmin();

// 1. hapus dbname di dalam connectdb terlebih dahulu karena belum ada database yang dibuat
// 2. ketik php function.php di terminal namun jalankan function connectDB() dan createDatabase() ( sisanya di command dlu )
// 3. Setelah berhasil masukan dbname sesuai createDatabase ke dalam connectDB ( di PDO )
// 4. Sekarang command connnectDB dan createDatabase() lalu gantian jalankan structureDB dan seederadmin di terminal dengann php function.php


function connectKumis($data)
{

    $nomorWa = $data['nomor_wa'];

    if (isset($_POST)) {
        
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => BASE_URL_API_KUMIS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'token' => TOKEN,
                'number' => $nomorWa,
                'message' => randomAyat()
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        header('Content-Type: application/json');
        http_response_code(200);
        return [
            'status' => 'success',
            'message' => 'berhasil mengirim data',
            'response' => json_decode($response, true)
        ];

    } else {
        header('Content-Type: application/json');
        http_response_code(400);
        return [
            'status' => 'failed',
            'message' => 'data bukan post'
        ];
    }
}

function randomAyat()
{

    $api = BASE_URL_API_AYAT;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $api,
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);

    $data = json_decode($response, true);

    $dataMessage = [
        "ayat" => $data['data']['text'],
        "ayatNumber" => $data['data']['surah']['number'],
        "surat" => $data['data']['surah']['name'],
        "suratNumber" => $data['data']['numberInSurah'],
    ];

    $string_message = "Penggalan ayat untuk hari ini:\n\n" . $dataMessage['ayat'] . "\n\n(QS. " . $dataMessage['surat'] . " [" . $dataMessage['suratNumber'] . "]:" . $dataMessage['ayatNumber'] . ")" . "." . " Semoga Allah melimpahkan rahmat kepada kita semua.";

    return $string_message;
}

function login($input)
{
    $conn = connectDB();

    $hashPassword = $input['password'];
    $email = $input['email'];

    $selectData = "select * from admins where email = '$email'";

    $result = $conn->query($selectData);

    $data = $result->fetch();

    if ($data && password_verify($hashPassword, $data['password'])) {
        header('Content-Type: application/json');
        http_response_code(200);
        return [
            'status' => 'success',
            'message' => 'berhasil login'
        ];
    } else {
        header('Content-Type: application/json');
        http_response_code(400);
        return [
            'status' => 'failed',
            'message' => 'password tidak valid'
        ];
    }
}

function dashboardIndex()
{
    $conn = connectDB();

    $all = 'select * from users';

    $result = $conn->query($all);

    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function registerMembers($input)
{
    $conn = connectDB();

    $name = $input['nama'];
    $nomorWa = $input['nomor_wa'];

    $insertData = "insert into users (name, nomor_wa) values ('$name', '$nomorWa')";

    $result = $conn->query($insertData);

    header('Content-Type: application/json');
    if ($result) {
        http_response_code(201);
        return [
            'status' => 'success',
            'message' => 'berhasil login'
        ];
    } else {
        http_response_code(400);
        return [
            'status' => 'success',
            'message' => 'berhasil login'
        ];
    }
}

function showOne($id){
    $conn = connectDB();

    $selectData = "select * from users where id= '$id'";
    $result = $conn->query($selectData);
    
    return $result->fetch(PDO::FETCH_ASSOC);
}