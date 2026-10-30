<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Portal Qur'an</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<body class="quran-auth">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-5">
                
                <div class="quran-auth__card shadow-lg my-4">
                    <div class="quran-auth__header text-center">
                        <div class="quran-auth__icon-wrapper mb-3">
                            <i class="fas fa-user-plus quran-auth__icon"></i>
                        </div>
                        <h2 class="quran-auth__title">Daftar ODOA</h2>
                        <p class="quran-auth__subtitle">Lengkapi data di bawah ini untuk mendaftar</p>
                    </div>

                    <div class="quran-auth__body">
                        <form action="#" method="POST" class="quran-auth__form" id="formDaftar">

                            <div class="form-group mb-3">
                                <label for="regNama" class="quran-auth__label">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text quran-auth__input-icon"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control quran-auth__input" placeholder="Contoh: Alif" id="nama" required>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="regWa" class="quran-auth__label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text quran-auth__input-icon"><i class="fab fa-whatsapp"></i></span>
                                    </div>
                                    <input type="tel" class="form-control quran-auth__input" placeholder="Contoh: 081234567890" id="nomor_wa" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block quran-auth__btn quran-auth__btn--submit mb-2" id="submit">
                                Daftar Akun <i class="fas fa-check-circle ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('formDaftar')
        
        form.addEventListener("submit", function(e) {
            e.preventDefault()
            
            const nama = document.getElementById('nama').value
            const nomor_wa = document.getElementById('nomor_wa').value

            const jsonData = {
                nama: nama,
                nomor_wa: nomor_wa 
            }

            fetch("https://staging.kurmaspace.com/pkl-2026/odoa-One-Day-One-Ayat-/be-ODOA/register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`${response.status}`)
                } 
                
                response.json()
            })
            .then(data => console.log('success', data))
            .catch(error => {
                console.error('Error', error.message)
            })
        })

    </script>
</body>
</html>