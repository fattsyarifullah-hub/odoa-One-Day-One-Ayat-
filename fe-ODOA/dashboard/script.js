
const pendaftar = [
    {
        id: 1001,
        nama: "Nafisa",
        nomor: "6289503362509",
        status: "Belum dikirim"
    },
    {
        id: 2,
        nama: "Rashaqa",
        nomor: "6287788797704",
        status: "Belum dikirim"
    }
];

let penerimaAktif = null;
let totalTerkirim = 0;

function tampilkanPendaftar(data = pendaftar) {
    const tabel = document.getElementById("tabelPendaftar");

    tabel.innerHTML = "";

    data.forEach((orang, index) => {
        const baris = document.createElement("tr");

        const kolomNo = document.createElement("td");
        kolomNo.textContent = index + 1;

        const kolomNama = document.createElement("td");
        kolomNama.textContent = orang.nama;

        const kolomNomor = document.createElement("td");
        kolomNomor.textContent = orang.nomor;

        const kolomStatus = document.createElement("td");
        kolomStatus.textContent = orang.status;

        const kolomAksi = document.createElement("td");
        const tombol = document.createElement("button");

        tombol.type = "button";
        tombol.className = "btn admin__button btn-sm";
        tombol.textContent = "Kirim";

        tombol.addEventListener("click", function () {
            bukaFormKirim(orang.id);
        });

        kolomAksi.appendChild(tombol);

        baris.append(
            kolomNo,
            kolomNama,
            kolomNomor,
            kolomStatus,
            kolomAksi
        );

        tabel.appendChild(baris);
    });
}

// Membuka form penerima
function bukaFormKirim(id) {
    penerimaAktif = pendaftar.find(orang => orang.id === id);

    document.getElementById("nama").value =
        penerimaAktif.nama;

    document.getElementById("nomor").value =
        penerimaAktif.nomor;

    document.getElementById("pesan").value = "";

    $("#modalKirim").modal("show");
}

// Mengirim pesan melalui WhatsApp
document.getElementById("formKirim").addEventListener(
    "submit",
    function (event) {
        event.preventDefault();

        if (!penerimaAktif) {
            return;
        }

        const nomor = penerimaAktif.nomor.replace(/\D/g, "");
        const pesan = document.getElementById("pesan").value.trim();

        if (!nomor || !pesan) {
            alert("Nomor WhatsApp dan pesan wajib diisi.");
            return;
        }

        const url = "https://wa.me/" + nomor +
            "?text=" + encodeURIComponent(pesan);
        window.open(url, "_blank");
        penerimaAktif.status = "WhatsApp dibuka";
        totalTerkirim++;

        document.getElementById("totalTerkirim").textContent =
            totalTerkirim;

        $("#modalKirim").modal("hide");

        tampilkanPendaftar();
    }
);

document.getElementById("searchInput").addEventListener(
    "input",
    function () {
        const kataKunci = this.value.toLowerCase();

        const hasil = pendaftar.filter(orang =>
            orang.nama.toLowerCase().includes(kataKunci)
        );

        tampilkanPendaftar(hasil);
    }
);

document.getElementById("totalPendaftar").textContent =
    pendaftar.length;

tampilkanPendaftar();
