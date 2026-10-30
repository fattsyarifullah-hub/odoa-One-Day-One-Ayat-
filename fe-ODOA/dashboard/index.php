
<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$namaAdmin = $_SESSION['admin_nama'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin One Day One Ayat</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="admin">

        <!-- Sidebar -->
        <aside class="admin__sidebar">
            <h4 class="admin__logo">Ayat Harian</h4>

            <p class="admin__subtitle">Admin</p>

            <nav class="admin__nav">
                <a href="index.php"
                    class="admin__link admin__link--active">
                    Dashboard
                </a>

            </nav>
        </aside>

        <!-- Konten Utama -->
        <main class="admin__content">

            <!-- Header -->
            <div class="admin__header">
                <div>
                    <h3 class="admin__title">
                        Kirim One Day One Ayat
                    </h3>

                    <p class="admin__description">
                        Istiqamah dari hal yang kecil.
                    </p>
                </div>

                <span class="admin__badge">
                    Admin
                </span>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">

                <div class="col-md-4 mb-3">
                    <div class="admin__card">
                        <p class="admin__card-label">
                            Total Pendaftar
                        </p>

                        <h3 id="totalPendaftar">0</h3>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="admin__card">
                        <p class="admin__card-label">
                            Pesan Terkirim
                        </p>

                        <h3 id="totalTerkirim">0</h3>
                    </div>
                </div>

            </div>

            <!-- Tabel Pendaftar -->
            <section class="admin__section" id="daftar">

                <div class="admin__section-header">
                    <h5 class="admin__section-title">
                        Daftar Pendaftar
                    </h5>

                    <input
                        type="text"
                        class="form-control admin__search"
                        id="searchInput"
                        placeholder="Cari nama...">
                </div>

                <div class="table-responsive">
                    <table class="table admin__table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor WhatsApp</th>
                            </tr>
                        </thead>

                        <tbody id="tabelPendaftar">
                            <!-- Data dimuat melalui JavaScript -->
                        </tbody>

                    </table>
                </div>

            </section>

        </main>
    </div>

    <!-- Modal Form Kirim Ayat -->
    <div
        class="modal fade"
        id="modalKirim"
        tabindex="-1"
        role="dialog"
        aria-labelledby="judulModal"
        aria-hidden="true">

        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document">

            <div class="modal-content">

                <div class="modal-header admin__modal-header">
                    <h5 class="modal-title" id="judulModal">
                        Kirim Ayat Al-Qur'an
                    </h5>

                    <button
                        type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Tutup">

                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formKirim">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nama">
                                Nama Penerima
                            </label>

                            <input
                                type="text"
                                id="nama"
                                class="form-control"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="nomor">
                                Nomor WhatsApp
                            </label>

                            <input
                                type="text"
                                id="nomor"
                                class="form-control"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="pesan">
                                Pesan Ayat Al-Qur'an
                            </label>

                            <textarea
                                id="pesan"
                                class="form-control"
                                rows="8"
                                required
                                placeholder="Masukkan ayat, terjemahan, dan pesan harian..."></textarea>
                        </div>

                        <small class="text-muted">
                            Periksa kembali ayat dan sumbernya
                            sebelum mengirim.
                        </small>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="btn admin__button">
                            Kirim via WhatsApp
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- 
    <script src="script.js"></script> -->

    <script>

        const ui = document.getElementById('tabelPendaftar')

        fetch("http://localhost/Project/PKL/odoa/be-ODOA/dashboard.php")
        .then((response) => response.json())
        .then((result) => {
            console.log(result)
            let daftar = result.data
            console.log(daftar)
            let dataJson = ''
            let no = 1
            daftar.forEach((data) => {
                console.log(data)
                dataJson += `<tr>
                <th scope="row">${no}</th>
                <td>${data.name}</td>
                <td>${data.nomor_wa}</td>
                <td>
                <a href="send.php?id=${data.id}"><button type="button" class="btn btn-success">Kirim Pesan</button></a>
                </td>
                </tr>`
                no++
            })

            ui.innerHTML = dataJson
        })

    </script>

</body>
</html>
