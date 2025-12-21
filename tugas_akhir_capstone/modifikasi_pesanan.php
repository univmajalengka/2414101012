<?php
$conn = mysqli_connect("localhost", "root", "", "jalan_jalan");
if (!$conn) die("Koneksi database gagal");

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pemesanan WHERE id='$id'");
    header("Location: modifikasi_pesanan.php");
    exit;
}

// AMBIL DATA UNTUK EDIT
$dataEdit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM pemesanan WHERE id='$id'");
    $dataEdit = mysqli_fetch_assoc($result);
}

// HARGA STANDAR LAYANAN
$harga_layanan = [
    'penginapan' => 1000000,
    'transportasi' => 1200000,
    'makan' => 500000
];

// UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $hp = $_POST['hp'];
    $tanggal = $_POST['tanggal'];
    $hari = intval($_POST['hari']);
    $peserta = intval($_POST['peserta']);

    $penginapan = 'N';
    $transportasi = 'N';
    $makan = 'N';
    if (isset($_POST['pelayanan'])) {
        foreach ($_POST['pelayanan'] as $p) {
            if ($p=='penginapan') $penginapan='Y';
            if ($p=='transportasi') $transportasi='Y';
            if ($p=='makan') $makan='Y';
        }
    }

    $harga_paket = intval($_POST['harga_paket']);
    $total = intval($_POST['total']);

    mysqli_query($conn, "UPDATE pemesanan SET
        nama='$nama',
        hp='$hp',
        tanggal_pesan='$tanggal',
        hari='$hari',
        peserta='$peserta',
        penginapan='$penginapan',
        transportasi='$transportasi',
        makan='$makan',
        harga_paket='$harga_paket',
        total_tagihan='$total'
        WHERE id='$id'
    ");

    header("Location: modifikasi_pesanan.php");
    exit;
}

// AMBIL SEMUA DATA
$data = mysqli_query($conn, "SELECT * FROM pemesanan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Modifikasi Pemesanan</title>
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
<body class="bg-light">

<!-- NAVIGASI -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">WisataKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#paket">Daftar Paket Wisata</a></li>
                <li class="nav-item"><a class="nav-link active" href="modifikasi_pesanan.php">Modifikasi Pesanan</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HEADER IMAGE -->
<div class="header">
    <h1>Cirebon Jeh</h1>
</div>
<div class="container my-5">
<h2 class="text-center mb-4">Daftar Pesanan</h2>

<!-- FORM EDIT -->
<?php if ($dataEdit): ?>
<div class="card mb-4">
    <div class="card-header bg-warning text-white">Edit Pemesanan</div>
    <div class="card-body">
        <form method="post" id="formPemesanan">
            <input type="hidden" name="id" value="<?= $dataEdit['id'] ?>">

            <div class="mb-2">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $dataEdit['nama'] ?>" required>
            </div>

            <div class="mb-2">
                <label>HP</label>
                <input type="text" name="hp" class="form-control" value="<?= $dataEdit['hp'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= $dataEdit['tanggal_pesan'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Hari</label>
                <input type="number" name="hari" id="hari" class="form-control" value="<?= $dataEdit['hari'] ?>" min="1" required>
            </div>

            <div class="mb-2">
                <label>Peserta</label>
                <input type="number" name="peserta" id="peserta" class="form-control" value="<?= $dataEdit['peserta'] ?>" min="1" required>
            </div>

            <div class="mb-2">
                <label>Pelayanan</label><br>
                <?php foreach ($harga_layanan as $layanan => $harga): ?>
                    <input type="checkbox" name="pelayanan[]" value="<?= $layanan ?>" data-harga="<?= $harga ?>"
                    <?= $dataEdit[$layanan]=='Y'?'checked':'' ?>> <?= ucfirst($layanan) ?> (Rp<?= number_format($harga) ?>)<br>
                <?php endforeach; ?>
            </div>

            <div class="mb-2">
                <label>Harga Paket</label>
                <input type="number" name="harga_paket" id="harga_paket" class="form-control" value="<?= $dataEdit['harga_paket'] ?>" readonly>
            </div>

            <div class="mb-2">
                <label>Total</label>
                <input type="number" name="total" id="total" class="form-control" value="<?= $dataEdit['total_tagihan'] ?>" readonly>
            </div>

            <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
            <a href="modifikasi_pesanan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- TABEL DATA -->
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>HP</th>
    <th>Tanggal</th>
    <th>Hari</th> <!-- Tambahan kolom Hari -->
    <th>Peserta</th> <!-- Tambahan kolom Peserta -->
    <th>Penginapan</th>
    <th>Transportasi</th>
    <th>Makan</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['hp'] ?></td>
    <td><?= $row['tanggal_pesan'] ?></td>
    <td class="text-center"><?= $row['hari'] ?></td> <!-- Tampilkan jumlah hari -->
    <td class="text-center"><?= $row['peserta'] ?></td> <!-- Tampilkan jumlah peserta -->
    <td class="text-center"><?= $row['penginapan'] ?></td>
    <td class="text-center"><?= $row['transportasi'] ?></td>
    <td class="text-center"><?= $row['makan'] ?></td>
    <td>Rp<?= number_format($row['total_tagihan']) ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
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
        if(p.checked){
            if(p.value=='penginapan') harga+=1000000;
            if(p.value=='transportasi') harga+=1200000;
            if(p.value=='makan') harga+=500000;
        }
    });
    hargaPaket.value = harga;
    total.value = harga * Number(hari.value || 1) * Number(peserta.value || 1);
}

window.addEventListener('DOMContentLoaded', hitung);
pelayanan.forEach(p=>p.addEventListener('change', hitung));
hari.addEventListener('input', hitung);
peserta.addEventListener('input', hitung);
</script>
</body>
</html>
