<?php
// koneksi database
$conn = mysqli_connect("localhost", "root", "", "jalan_jalan");
if (!$conn) {
    die("Koneksi database gagal");
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $hp = $_POST['hp'];
    $tanggal = $_POST['tanggal'];
    $hari = $_POST['hari'];
    $peserta = $_POST['peserta'];
    $harga_paket = $_POST['harga_paket'];
    $total = $_POST['total'];

    // default = N
    $penginapan = 'N';
    $transportasi = 'N';
    $makan = 'N';

    if (isset($_POST['pelayanan'])) {
        foreach ($_POST['pelayanan'] as $p) {
            if ($p == 'penginapan') $penginapan = 'Y';
            if ($p == 'transportasi') $transportasi = 'Y';
            if ($p == 'makan') $makan = 'Y';
        }
    }

    if ($nama == "" || $hp == "" || $tanggal == "" || $hari == "" || $peserta == "") {
        $pesan = "<div class='alert alert-danger'>Semua data wajib diisi!</div>";
    } else {
    $sql = "INSERT INTO pemesanan 
    (nama, hp, tanggal_pesan, hari, peserta, penginapan, transportasi, makan, harga_paket, total_tagihan)
    VALUES
    ('$nama','$hp','$tanggal','$hari','$peserta','$penginapan','$transportasi','$makan','$harga_paket','$total')";

    if (mysqli_query($conn, $sql)) {
        header("Location: modifikasi_pesanan.php");
        exit;
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menyimpan data</div>";
    }
}

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
        body { background-color: #f8f9fa; }
        .header {
            background: url('img/6.jpg') center/cover no-repeat;
            height: 350px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }
        .card img { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
<!-- NAVIGASI -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">WisataKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#paket">Daftar Paket Wisata</a></li>
                <li class="nav-item"><a class="nav-link" href="modifikasi_pesanan.php">Modifikasi Pesanan</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HEADER IMAGE -->
<div class="header">
    <h1>Cirebon Jeh</h1>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Form Pemesanan Paket Wisata</h2>
    <?= $pesan ?>

    <form method="post">
        <div class="mb-3">
            <label>Nama Pemesan</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nomor HP / Telp</label>
            <input type="text" name="hp" class="form-control">
        </div>
        <div class="mb-3">
            <label>Tanggal Pesan</label>
            <input type="date" name="tanggal" class="form-control">
        </div>
        <div class="mb-3">
            <label>Waktu Pelaksanaan (Hari)</label>
            <input type="number" name="hari" id="hari" class="form-control" value="1">
        </div>
        <div class="mb-3">
            <label>Jumlah Peserta</label>
            <input type="number" name="peserta" id="peserta" class="form-control" value="1">
        </div>

        <div class="mb-3">
            <label>Pelayanan</label><br>
            <input type="checkbox" name="pelayanan[]" value="penginapan" data-harga="1000000"> Penginapan (Rp1.000.000)<br>
            <input type="checkbox" name="pelayanan[]" value="transportasi" data-harga="1200000"> Transportasi (Rp1.200.000)<br>
            <input type="checkbox" name="pelayanan[]" value="makan" data-harga="500000"> Service/Makan (Rp500.000)
        </div>

        <div class="mb-3">
            <label>Harga Paket Perjalanan</label>
            <input type="text" name="harga_paket" id="harga_paket" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label>Jumlah Tagihan</label>
            <input type="text" name="total" id="total" class="form-control" readonly>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Pemesanan</button>
    </form>
</div>

<script>
const pelayanan = document.querySelectorAll("input[name='pelayanan[]']");
const hari = document.getElementById('hari');
const peserta = document.getElementById('peserta');
const hargaPaket = document.getElementById('harga_paket');
const total = document.getElementById('total');

function hitung() {
    let harga = 0;
    pelayanan.forEach(p => {
        if (p.checked) harga += parseInt(p.dataset.harga);
    });
    hargaPaket.value = harga;
    total.value = harga * hari.value * peserta.value;
}

pelayanan.forEach(p => p.addEventListener('change', hitung));
hari.addEventListener('input', hitung);
peserta.addEventListener('input', hitung);
</script>
</body>
</html>
