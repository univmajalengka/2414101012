<?php
session_start();
require 'koneksi.php'; // Pastikan koneksi.php ada untuk navbar, meskipun tidak melakukan INSERT data pesanan

// Redirect jika keranjang kosong
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$grandTotal = 0;
// Hitung Grand Total
foreach ($_SESSION['cart'] as $c) {
    $grandTotal += $c['price'] * $c['qty'];
}

// ----- HANDLE SUBMIT CHECKOUT -----
if (isset($_POST['complete_checkout'])) {
    // 1. Ambil data form
    $nama_penerima = $_POST['nama_penerima'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $metode_bayar = $_POST['metode_bayar'];

    // Validasi sederhana (Anda bisa menambahkan validasi yang lebih ketat)
    if (empty($nama_penerima) || empty($alamat) || empty($no_hp)) {
        $error = "Semua field pengiriman harus diisi!";
    } else {
        // --- SIMULASI PEMESANAN ---
        // Di sini seharusnya ada logika untuk:
        // 1. Menyimpan data pesanan (users_id, grand_total, detail_pengiriman, status) ke tabel 'orders'
        // 2. Menyimpan detail barang (order_id, id_buah, qty, harga_satuan) ke tabel 'order_details'

        // Karena tidak ada tabel orders/order_details, kita hanya mencetak nota simulasi

        // 3. Mengosongkan keranjang setelah pesanan "selesai"
        unset($_SESSION['cart']);

        // 4. Redirect ke halaman konfirmasi atau index dengan pesan sukses
        $_SESSION['checkout_success'] = "Pesanan Anda berhasil diproses! Total: Rp " . number_format($grandTotal, 0, ',', '.') . ". Silakan tunggu konfirmasi.";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout - Toko Buah Segar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container mt-4">
  <h2 class="mb-4">Halaman Checkout</h2>
  <div class="row">

    <div class="col-md-7">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">Ringkasan Pesanan</div>
        <div class="card-body p-0">
          <table class="table table-bordered mb-0 align-middle">
            <thead>
              <tr class="text-center"><th>Nama Buah</th><th>Qty</th><th>Harga Satuan</th><th>Total</th></tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['cart'] as $id => $c): ?>
                <tr>
                  <td><?= htmlspecialchars($c['name']) ?></td>
                  <td class="text-center"><?= $c['qty'] ?></td>
                  <td class="text-end">Rp <?= number_format($c['price'], 0, ',', '.') ?></td>
                  <td class="text-end">Rp <?= number_format($c['price'] * $c['qty'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="table-light">
                <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                <td class="text-end fw-bold fs-5">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-header bg-warning">Detail Pengiriman & Pembayaran</div>
        <div class="card-body">
          <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
          
          <form method="post">
            <div class="mb-3">
              <label for="nama_penerima" class="form-label">Nama Penerima</label>
              <input type="text" name="nama_penerima" class="form-control" value="<?= isset($_SESSION['nama_lengkap']) ? htmlspecialchars($_SESSION['nama_lengkap']) : '' ?>" required>
            </div>
            <div class="mb-3">
              <label for="no_hp" class="form-label">No. HP Aktif</label>
              <input type="text" name="no_hp" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat Lengkap Pengiriman</label>
              <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            
            <hr>
            
            <div class="mb-3">
              <label for="metode_bayar" class="form-label">Metode Pembayaran</label>
              <select name="metode_bayar" class="form-select" required>
                <option value="Transfer Bank">Transfer Bank (BCA/Mandiri)</option>
                <option value="COD">Cash On Delivery (COD)</option>
                <option value="E-Wallet">E-Wallet (Dana/GoPay)</option>
              </select>
            </div>
            
            <button name="complete_checkout" class="btn btn-success w-100 mt-2">Selesaikan Pesanan</button>
            <a href="keranjang.php" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Keranjang</a>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>