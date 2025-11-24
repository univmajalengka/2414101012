<?php
session_start();
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// ----- HANDLE TAMBAH/KURANG KUANTITAS -----
// Logika ini dipindahkan ke sini agar halaman keranjang bisa update sendiri
if (isset($_POST['update_cart'])) {
    $id = $_POST['id'];
    if ($_POST['action'] == 'plus') $_SESSION['cart'][$id]['qty']++;
    if ($_POST['action'] == 'minus' && $_SESSION['cart'][$id]['qty'] > 1) $_SESSION['cart'][$id]['qty']--;
    if ($_POST['action'] == 'remove') unset($_SESSION['cart'][$id]);
    
    // Redirect kembali ke halaman keranjang untuk refresh
    header("Location: keranjang.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Keranjang - Toko Buah Segar</title>
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
  <h2 class="mb-3">Keranjang Belanja Anda</h2>
  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (empty($_SESSION['cart'])): ?>
        <p class="text-center">Keranjang masih kosong. <a href="index.php">Mulai belanja</a>!</p>
      <?php else: ?>
        <table class="table table-bordered text-center align-middle">
          <thead>
            <tr><th>Nama</th><th>Harga</th><th>Qty</th><th>Total</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php $grandTotal = 0; foreach ($_SESSION['cart'] as $id => $c): 
              $total = $c['price'] * $c['qty']; $grandTotal += $total; ?>
              <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td>Rp <?= number_format($c['price'], 0, ',', '.') ?></td>
                <td>
                  <form method="post" style="display:inline">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="action" value="minus">
                    <button name="update_cart" class="btn btn-sm btn-outline-danger">-</button>
                  </form>
                  <span class="mx-2"><?= $c['qty'] ?></span>
                  <form method="post" style="display:inline">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="action" value="plus">
                    <button name="update_cart" class="btn btn-sm btn-outline-success">+</button>
                  </form>
                </td>
                <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                <td>
                  <form method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="action" value="remove">
                    <button name="update_cart" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr class="table-light">
              <td colspan="3" class="text-end fw-bold">Grand Total:</td>
              <td colspan="2" class="fw-bold fs-5">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
            </tr>
          </tfoot>
        </table>
        <div class="text-end">
          <a href="checkout.php" class="btn btn-success">Lanjut ke Checkout</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>