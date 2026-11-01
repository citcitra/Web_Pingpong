-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2019 pada 06.09
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ujikel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `harga`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Ayam Goreng', 10000, 'ayam.jpg', '2019-08-05 17:00:00', '2019-08-05 17:00:00'),
(2, 'Nasi Goreng', 15000, 'Nasgor.jpg', NULL, NULL),
(6, 'Jus Alpukat', 10000, 'alpukat.jpg', '2019-08-05 23:57:30', '2019-08-06 06:28:08'),
(10, 'Sate Padang', 25000, '1565168965_5d4a9545c4e31.jpg', '2019-08-07 02:09:25', '2019-08-07 02:09:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2019_07_04_122728_create_table_siswa', 1),
(8, '2019_08_05_151236_create_bukus_table', 1),
(9, '2019_08_05_161758_create_upload_table', 1),
(10, '2019_08_06_040848_create_menu_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_transaksi`, `id_menu`, `created_at`, `updated_at`) VALUES
(55, 61, 6, '2019-08-07', '2019-08-07'),
(56, 61, 2, '2019-08-07', '2019-08-07'),
(57, 61, 1, '2019-08-07', '2019-08-07'),
(58, 62, 6, '2019-08-07', '2019-08-07'),
(59, 62, 8, '2019-08-07', '2019-08-07'),
(60, 62, 1, '2019-08-07', '2019-08-07'),
(61, 63, 1, '2019-08-07', '2019-08-07'),
(62, 63, 2, '2019-08-07', '2019-08-07'),
(63, 64, 6, '2019-08-07', '2019-08-07'),
(64, 64, 2, '2019-08-07', '2019-08-07'),
(65, 64, 1, '2019-08-07', '2019-08-07'),
(66, 65, 2, '2019-08-07', '2019-08-07'),
(67, 65, 1, '2019-08-07', '2019-08-07'),
(68, 66, 2, '2019-08-07', '2019-08-07'),
(69, 66, 1, '2019-08-07', '2019-08-07'),
(70, 67, 2, '2019-08-07', '2019-08-07'),
(71, 67, 1, '2019-08-07', '2019-08-07'),
(72, 68, 1, '2019-08-08', '2019-08-08'),
(73, 68, 6, '2019-08-08', '2019-08-08'),
(74, 68, 2, '2019-08-08', '2019-08-08'),
(75, 68, 1, '2019-08-08', '2019-08-08'),
(76, 69, 6, '2019-08-08', '2019-08-08'),
(77, 69, 1, '2019-08-08', '2019-08-08');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `query_pemesanan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `query_pemesanan` (
`id_transaksi` int(11)
,`nama_pemesan` varchar(100)
,`subtotal` int(11)
,`bayar` int(11)
,`kembalian` int(11)
,`status` varchar(32)
,`id_menu` int(11)
,`nama_menu` varchar(191)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status` varchar(32) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nama_pemesan`, `subtotal`, `status`, `bayar`, `kembalian`, `created_at`, `updated_at`) VALUES
(61, 'Imam Firmansyah', 35000, 'Sudah Bayar', 100000, 65000, '2019-08-07', '2019-08-07'),
(62, 'Arda Billy', 45000, 'Sudah Bayar', 50000, 5000, '2019-08-07', '2019-08-07'),
(63, 'Ardafa Pratama', 25000, 'Sudah Bayar', 100000, 75000, '2019-08-07', '2019-08-07'),
(64, 'Ahmed', 35000, 'Sudah Bayar', 100000, 65000, '2019-08-07', '2019-08-07'),
(65, 'Ardafa Ganteng', 25000, 'Sudah Bayar', 50000, 25000, '2019-08-07', '2019-08-07'),
(66, 'Imam Firmansyah', 40000, 'Sudah Bayar', 50000, 10000, '2019-08-07', '2019-08-07'),
(67, 'Bayu', 25000, 'Belum Bayar', 0, 0, '2019-08-07', '2019-08-07'),
(68, 'Zaher', 60000, 'Sudah Bayar', 100000, 40000, '2019-08-08', '2019-08-08'),
(69, 'Jaherr', 30000, 'Belum Bayar', 0, 0, '2019-08-08', '2019-08-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `upload`
--

CREATE TABLE `upload` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `upload`
--

INSERT INTO `upload` (`id`, `nama`, `filename`, `created_at`, `updated_at`) VALUES
(1, 'sssssssss', '8afc4b591c1f5bfadb0457ce993b437d.jpg', '2019-08-05 22:11:25', '2019-08-05 22:11:25'),
(2, 'sa', 'young-1822656_1920.jpg', '2019-08-06 00:01:39', '2019-08-06 00:01:39'),
(3, 'sa', 'young-1822656_1920.jpg', '2019-08-06 00:01:40', '2019-08-06 00:01:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'imamfirmansyah', 'admin@admin.com', NULL, '$2y$10$hw2/IOdl2zJQHxrOOmiA2O9EXmhfq54gMwm2w5IJXTk9M6Cs9nMGG', NULL, '2019-08-05 10:06:59', '2019-08-05 10:06:59');

-- --------------------------------------------------------

--
-- Struktur untuk view `query_pemesanan`
--
DROP TABLE IF EXISTS `query_pemesanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_pemesanan`  AS  select `transaksi`.`id_transaksi` AS `id_transaksi`,`transaksi`.`nama_pemesan` AS `nama_pemesan`,`transaksi`.`subtotal` AS `subtotal`,`transaksi`.`bayar` AS `bayar`,`transaksi`.`kembalian` AS `kembalian`,`transaksi`.`status` AS `status`,`pesanan`.`id_menu` AS `id_menu`,`menu`.`nama_menu` AS `nama_menu` from ((`transaksi` join `pesanan` on((`transaksi`.`id_transaksi` = `pesanan`.`id_transaksi`))) join `menu` on((`pesanan`.`id_menu` = `menu`.`id`))) order by `transaksi`.`id_transaksi` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `upload`
--
ALTER TABLE `upload`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
