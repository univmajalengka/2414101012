-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Des 2025 pada 00.37
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_wisata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `hari` int(11) DEFAULT NULL,
  `peserta` int(11) DEFAULT NULL,
  `penginapan` char(1) DEFAULT NULL,
  `transportasi` char(1) DEFAULT NULL,
  `makan` char(1) DEFAULT NULL,
  `harga_paket` int(11) DEFAULT NULL,
  `total_tagihan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `nama`, `hp`, `tanggal_pesan`, `hari`, `peserta`, `penginapan`, `transportasi`, `makan`, `harga_paket`, `total_tagihan`) VALUES
(9, 'Mandala', '089534452898', '2025-08-12', 2, 1, 'Y', 'Y', 'Y', 2700000, 5400000),
(10, 'Rei', '0895322489156', '2025-12-12', 1, 1, 'Y', 'N', 'N', 1000000, 1000000),
(11, 'Andi', '0895322489156', '2025-12-12', 5, 1, 'Y', 'N', 'N', 1000000, 5000000),
(12, 'Kaiden', '0895322489156', '2026-09-21', 1, 8, 'N', 'N', 'Y', 500000, 4000000),
(13, 'Haha', '0895322489156', '2026-12-12', 2, 2, 'N', 'Y', 'N', 1200000, 4800000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
