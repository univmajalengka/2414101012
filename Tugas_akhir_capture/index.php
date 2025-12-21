<?php
// index.php - Halaman Beranda Aplikasi Paket Wisata
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Cirebon Jeh </title>
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

<!-- DAFTAR PAKET WISATA -->
<div class="container my-5" id="paket">
    <h2 class="text-center mb-4">Daftar Paket Wisata</h2>
    <div class="row g-4">
        
        <!-- PAKET 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="img/3.jpg" class="card-img-top" alt="Paket Gua">
                <div class="card-body">
                    <h5 class="card-title">Paket Tradisi 1</h5>
                    <p class="card-text">Menikmati keindahan alam Gua Sunyaragi.</p>
                    <div class="ratio ratio-16x9 mb-2">
                        <iframe src="https://www.youtube.com/embed/7NgNGCNP3-E" title="Video Promosi" allowfullscreen></iframe>
                    </div>
                    <a href="pemesanan.php" class="btn btn-success btn-sm float-end">Pesan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- PAKET 2 -->
        <div class="col-md-4">
            <div class="card">
                <img src="img/4.jpg" class="card-img-top" alt="Paket Kraton">
                <div class="card-body">
                    <h5 class="card-title">Paket Tradisi 2</h5>
                    <p class="card-text">Wisata regligus kedalam keraton.</p>
                    <div class="ratio ratio-16x9 mb-2">
                        <iframe src="https://www.youtube.com/embed/08PGLO0DMAw" title="Video Promosi" allowfullscreen></iframe>
                    </div>
                    <a href="pemesanan.php" class="btn btn-success btn-sm float-end">Pesan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- PAKET 3 -->
        <div class="col-md-4">
            <div class="card">
                <img src="img/5.jpg" class="card-img-top" alt="Paket Pantai">
                <div class="card-body">
                    <h5 class="card-title">Paket Tradisi 3</h5>
                    <p class="card-text">Menikmati wisata di pantai kejawanan.</p>
                    <div class="ratio ratio-16x9 mb-2">
                        <iframe src="https://www.youtube.com/embed/D_VRO3ubpq8" title="Video Promosi" allowfullscreen></iframe>
                    </div>
                    <a href="pemesanan.php" class="btn btn-success btn-sm float-end">Pesan Sekarang</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
