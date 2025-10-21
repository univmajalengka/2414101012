<?php
// ----- START SESSION & DB -----
session_start();
require 'koneksi.php'; // Hubungkan ke database
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// ----- HANDLE TAMBAH KE KERANJANG -----
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = ['name' => $name, 'price' => $price, 'qty' => 1];
    } else {
        $_SESSION['cart'][$id]['qty']++;
    }
    // Redirect ke halaman yang sama untuk menghindari resubmit form
    header("Location: index.php");
    exit;
}

// ----- AMBIL DATA BUAH DARI DATABASE -----
$stmt = $pdo->query("SELECT * FROM buah ORDER BY nama ASC");
$buah = $stmt->fetchAll(); // $buah sekarang berisi data dari DB
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Toko Buah Segar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* ... CSS Anda tetap sama ... */
body { background-color: #f8f9fa; }
.card img { height: 180px; object-fit: cover; }
footer { background: #198754; color: white; text-align: center; padding: 15px 0; margin-top: 50px; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="index.php">Toko Buah Segar</a>
    
    <div class="ms-auto d-flex">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="navbar-text text-white me-3">
          Hi, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light me-2">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-light me-2">Login</a>
      <?php endif; ?>
      
      <a href="keranjang.php" class="btn btn-light">
        🛒 Keranjang (<?= count($_SESSION['cart']) ?>)
      </a>
    </div>
  </div>
</nav>

<div class="p-5 text-center bg-light mt-3 rounded shadow-sm">
  <h1>Selamat Datang di Toko Buah Segar 🍎</h1>
  <p>Kami menyediakan berbagai buah segar pilihan dari lokal hingga impor, siap dipesan untuk Anda!</p>
</div>

<div class="container mt-4 text-center">
  <button class="btn btn-outline-success m-1" onclick="filterCards('Semua')">Semua</button>
  <button class="btn btn-outline-success m-1" onclick="filterCards('Tropis')">Tropis</button>
  <button class="btn btn-outline-success m-1" onclick="filterCards('Lokal')">Lokal</button>
  <button class="btn btn-outline-success m-1" onclick="filterCards('Impor')">Impor</button>
</div>

<div class="container mt-4">
  <div class="row" id="buahCards">
    <?php foreach ($buah as $b): ?>
    <div class="col-md-3 mb-4 buah-card" data-category="<?= htmlspecialchars($b['kategori']) ?>">
      <div class="card shadow-sm">
        <img src="<?= htmlspecialchars($b['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($b['nama']) ?>">
        <div class="card-body text-center">
          <h5 class="card-title"><?= htmlspecialchars($b['nama']) ?></h5>
          <p class="card-text text-success fw-bold">Rp <?= number_format($b['harga'], 0, ',', '.') ?></p>
          <form method="post">
            <input type="hidden" name="id" value="<?= $b['id_buah'] ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($b['nama']) ?>">
            <input type="hidden" name="price" value="<?= $b['harga'] ?>">
            <button name="add_to_cart" class="btn btn-success btn-sm">+ Keranjang</button>
            <button type="button" class="btn btn-warning btn-sm" onclick="openModalBeli('<?= htmlspecialchars($b['nama']) ?>', <?= $b['harga'] ?>)">Beli Sekarang</button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="modal fade" id="beliModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Form Pemesanan</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formBeli">
          <input type="hidden" id="buahNama">
          <input type="hidden" id="buahHarga">
          <div class="mb-2">
            <label>Nama Pemesan</label>
            <input type="text" id="namaPemesan" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>No. HP</label>
            <input type="text" id="noHP" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Tanggal Kunjungan</label>
            <input type="date" id="tglKunjungan" class="form-control" required>
          </div>
          <button type="button" class="btn btn-success w-100" onclick="cetakNota()">Cetak Nota</button>
        </form>
      </div>
    </div>
  </div>
</div>

<footer>
  <p>© <?= date('Y') ?> Toko Buah Segar | Fresh Fruit Everyday 🍇</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// SCRIPT (Tetap Sama)
// ... JavaScript Anda untuk filterCards, openModalBeli, cetakNota ...
// FILTER KATEGORI
function filterCards(kat) {
  document.querySelectorAll('.buah-card').forEach(card => {
    card.style.display = (kat === 'Semua' || card.dataset.category === kat) ? 'block' : 'none';
  });
}

// MODAL BELI
function openModalBeli(nama, harga) {
  document.getElementById('buahNama').value = nama;
  document.getElementById('buahHarga').value = harga;
  new bootstrap.Modal(document.getElementById('beliModal')).show();
}

// CETAK NOTA
function cetakNota() {
  let namaBuah = document.getElementById('buahNama').value;
  let harga = document.getElementById('buahHarga').value;
  let pemesan = document.getElementById('namaPemesan').value;
  let hp = document.getElementById('noHP').value;
  let tanggal = document.getElementById('tglKunjungan').value;

  if (!pemesan || !hp || !tanggal) return alert('Lengkapi data dulu!');

  let nota = `
    ====== NOTA PEMESANAN BUAH ======\n
    Nama Pemesan : ${pemesan}
    No. HP       : ${hp}
    Buah Dibeli  : ${namaBuah}
    Harga        : Rp ${parseInt(harga).toLocaleString('id-ID')}
    Tanggal      : ${tanggal}
    ==============================\n
    Terima kasih sudah memesan di Toko Buah Segar 🍓
  `;
  let w = window.open('', '', 'width=400,height=600');
  w.document.write(`<pre>${nota}</pre>`);
  w.print();
}
</script>
</body>
</html>