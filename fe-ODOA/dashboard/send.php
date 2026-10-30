<?php

$id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST" id="kirimAyat">
        <label for="nama">Nama</label>
        <input type="text" id="nama" readonly required>

        <label for="nomor_wa">Nomor Wa</label>
        <input type="text" id="nomor_wa" readonly required>

        <button type="submit">Kirim Ayat</button>
    </form>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        // 1. Ambil query string dari URL browser (misal: halaman.html?id=5)
const urlParams = new URLSearchParams(window.location.search);

// 2. Ekstrak nilai dari parameter 'id'
const idValue = urlParams.get('id'); 

const form = document.getElementById("kirimAyat")

    if(idValue) {

        const nama = document.getElementById('nama')
        const nomor_wa = document.getElementById('nomor_wa')

        fetch(`http://localhost/Project/PKL/be-ODOA/showOne.php?id=${idValue}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data.data)
            nama.value = `${data.data.name}`
            nomor_wa.value = `${data.data.nomor_wa}`
        })

    }

    form.addEventListener('submit', function(e) {
        e.preventDefault()

        const jsonData = {
            nomor_wa: `${nomor_wa.value}`,
        }

        fetch("http://localhost/Project/PKL/be-ODOA/chat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(jsonData)
        })
        .then((response) => response.json())
        .then((result) => {
            console.log('Success', result)
        })
        .catch((error) => {
            console.error(error)
        })
    })
    </script>
</body>
</html>