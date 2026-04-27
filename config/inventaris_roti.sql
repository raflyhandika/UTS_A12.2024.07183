-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Apr 2026 pada 11.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_roti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Tersedia',
  `gambar` varchar(255) DEFAULT NULL,
  `thumbpath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `stok`, `status`, `gambar`, `thumbpath`) VALUES
(11, 'Roti Coklat', 10000.00, 25, 'Tersedia', 'uploads/1776912565_69e988b57ea13.jpg', 'uploads/thumbnails/thumb_1776912565_69e988b57ea13.jpg'),
(12, 'Kue Tart', 50000.00, 5, 'Tersedia', 'uploads/1776913593_69e98cb954718.jpg', 'uploads/thumbnails/thumb_1776913593_69e98cb954718.jpg'),
(13, 'Kue Nastar', 30000.00, 10, 'Tersedia', 'uploads/1776913765_69e98d654b685.jpg', 'uploads/thumbnails/thumb_1776913765_69e98d654b685.jpg'),
(14, 'Bolu Pandan', 20000.00, 15, 'Tersedia', 'uploads/1776913848_69e98db8799ab.jpg', 'uploads/thumbnails/thumb_1776913848_69e98db8799ab.jpg'),
(15, 'Abon Gulung', 40000.00, 14, 'Tersedia', 'uploads/1777038267_69eb73bb8eadf.jpg', 'uploads/thumbnails/thumb_1777038267_69eb73bb8eadf.jpg'),
(16, 'Pisang Bolen', 25000.00, 10, 'Tersedia', 'uploads/1777039298_69eb77c27892d.jpg', 'uploads/thumbnails/thumb_1777039298_69eb77c27892d.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$orcIbDDcb7UyTZFuX199zeZUITDbWONSjWZf2nTw50Zlf2EbU.5vC');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
