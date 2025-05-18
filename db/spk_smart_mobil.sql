-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 05:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_smart_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_perhitungan`
--

CREATE TABLE `hasil_perhitungan` (
  `id_hasil` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `skor` decimal(10,2) DEFAULT NULL,
  `ranking` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_perhitungan`
--

INSERT INTO `hasil_perhitungan` (`id_hasil`, `id_user`, `id_mobil`, `skor`, `ranking`, `created_at`) VALUES
(1, 13, 3, 0.92, 1, '2025-05-15 17:25:14'),
(2, 13, 2, 0.86, 2, '2025-05-15 17:25:14'),
(3, 13, 5, 0.75, 3, '2025-05-15 17:25:14'),
(14, 11, 3, 0.92, 1, '2025-05-18 22:35:05'),
(15, 11, 2, 0.82, 2, '2025-05-18 22:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(2) NOT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `tipe` enum('benefit','cost') NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `pilih_inputan` enum('subkriteria','input_langsung','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `tipe`, `bobot`, `pilih_inputan`) VALUES
(9, 'K1', 'Harga', 'cost', 0.52, 'input_langsung'),
(10, 'K2', 'BBM', 'benefit', 0.30, 'subkriteria'),
(11, 'K3', 'Fitur', 'benefit', 0.20, 'subkriteria');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `nama_mobil` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tersedia` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama_mobil`, `merk`, `harga`, `tahun`, `gambar`, `deskripsi`, `tersedia`, `updated_at`) VALUES
(2, 'Avanza Veloz', 'Toyota', 250000000.00, 2021, '1746056885_6ad8bab7d6dd351f7a1e.jpg', 'Mobil keluarga dengan fitur lengkap', 1, '2025-04-30 18:06:01'),
(3, 'Xpander Cross', 'Mitsubishi', 275000000.00, 2021, '1746037550_becba8a26c53dc5bfbb0.png', 'SUV crossover dengan tampilan gagah', 1, '2025-04-30 18:06:01'),
(5, 'Karimun', 'Toyota', 150000000.00, 2015, '1746037636_ebf069def086e5f4165d.jpg', 'test data tambah', 1, '2025-04-30 18:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `id_sales` int(11) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `metode_pembayaran` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_user`, `id_mobil`, `id_sales`, `no_telp`, `tanggal_pembelian`, `metode_pembayaran`, `created_at`) VALUES
(5, 11, 3, 3, '2147483647', '2025-05-13', 'transfer', '2025-05-13 01:39:40'),
(6, 11, 5, 3, '085956665511', '2025-05-13', 'transfer', '2025-05-13 01:41:14'),
(7, 13, 2, 3, '082552223655', '2025-05-13', 'credit', '2025-05-13 01:54:44'),
(8, 11, 3, 14, '087890843334', '2025-05-13', 'transfer', '2025-05-13 22:40:45'),
(9, 11, 3, 14, '087789213432', '2025-05-17', 'transfer', '2025-05-17 12:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `id_subkriteria` int(11) DEFAULT NULL,
  `nilai` int(15) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_mobil`, `id_kriteria`, `id_subkriteria`, `nilai`, `created_at`) VALUES
(49, 2, 9, NULL, 200, '2025-05-04 21:29:23'),
(50, 2, 10, 13, NULL, '2025-05-04 21:29:23'),
(51, 2, 11, 11, NULL, '2025-05-04 21:29:23'),
(52, 3, 9, NULL, 250, '2025-05-04 21:29:32'),
(53, 3, 10, 7, NULL, '2025-05-04 21:29:32'),
(54, 3, 11, 10, NULL, '2025-05-04 21:29:32'),
(55, 5, 9, NULL, 180, '2025-05-04 21:29:41'),
(56, 5, 10, 7, NULL, '2025-05-04 21:29:41'),
(57, 5, 11, 11, NULL, '2025-05-04 21:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `perbandingan`
--

CREATE TABLE `perbandingan` (
  `id_perbandingan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perbandingan`
--

INSERT INTO `perbandingan` (`id_perbandingan`, `id_user`, `tanggal`, `keterangan`) VALUES
(1, 13, '2025-05-15 09:34:49', 'Perbandingan mobil oleh user ID 13'),
(2, 13, '2025-05-15 10:25:14', 'Perbandingan mobil oleh user ID 13'),
(3, 11, '2025-05-16 10:22:20', 'Perbandingan mobil oleh user ID 11'),
(4, 11, '2025-05-16 11:50:35', 'Perbandingan mobil oleh user ID 11'),
(5, 11, '2025-05-17 12:48:18', 'Perbandingan mobil oleh user ID 11'),
(6, 11, '2025-05-17 23:52:10', 'Perbandingan mobil oleh user ID 11'),
(7, 11, '2025-05-17 23:52:11', 'Perbandingan mobil oleh user ID 11'),
(8, 11, '2025-05-18 15:35:05', 'Perbandingan mobil oleh user ID 11');

-- --------------------------------------------------------

--
-- Table structure for table `perbandingan_detail`
--

CREATE TABLE `perbandingan_detail` (
  `id` int(11) NOT NULL,
  `id_perbandingan` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perbandingan_detail`
--

INSERT INTO `perbandingan_detail` (`id`, `id_perbandingan`, `id_mobil`) VALUES
(1, 1, 5),
(2, 1, 3),
(3, 2, 3),
(4, 2, 2),
(5, 2, 5),
(6, 3, 5),
(7, 3, 3),
(8, 4, 5),
(9, 4, 3),
(10, 5, 3),
(11, 5, 2),
(12, 6, 3),
(13, 6, 5),
(14, 7, 3),
(15, 7, 5),
(16, 8, 3),
(17, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `perbandingan_hasil`
--

CREATE TABLE `perbandingan_hasil` (
  `id` int(11) NOT NULL,
  `id_perbandingan` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `nilai_preferensi` decimal(10,5) DEFAULT NULL,
  `ranking` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perbandingan_hasil`
--

INSERT INTO `perbandingan_hasil` (`id`, `id_perbandingan`, `id_mobil`, `nilai_preferensi`, `ranking`) VALUES
(1, 1, 5, 0.92000, 1),
(2, 1, 3, 0.86000, 2),
(3, 2, 3, 0.92000, NULL),
(4, 2, 2, 0.86000, NULL),
(5, 2, 5, 0.75000, NULL),
(6, 3, 5, 0.92000, NULL),
(7, 3, 3, 0.86000, NULL),
(8, 4, 5, 0.92000, NULL),
(9, 4, 3, 0.86000, NULL),
(10, 5, 3, 0.90000, NULL),
(11, 5, 2, 0.80000, NULL),
(12, 6, 3, 0.92000, NULL),
(13, 6, 5, 0.86000, NULL),
(14, 7, 3, 0.92000, NULL),
(15, 7, 5, 0.86000, NULL),
(16, 8, 3, 0.91600, NULL),
(17, 8, 2, 0.82000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `perhitungan_temp`
--

CREATE TABLE `perhitungan_temp` (
  `id_temp` int(11) NOT NULL,
  `id_perbandingan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perhitungan_temp`
--

INSERT INTO `perhitungan_temp` (`id_temp`, `id_perbandingan`, `id_user`, `id_mobil`, `created_at`) VALUES
(1, NULL, 15, 3, '2025-05-15 11:25:38'),
(2, NULL, 15, 2, '2025-05-15 11:25:40'),
(3, NULL, 15, 5, '2025-05-15 11:25:40'),
(4, 1, 13, 5, '2025-05-15 16:34:46'),
(5, 1, 13, 3, '2025-05-15 16:34:47'),
(6, NULL, 13, 2, '2025-05-15 17:25:12'),
(7, NULL, 11, 5, '2025-05-16 17:22:17'),
(8, NULL, 11, 3, '2025-05-16 17:22:18'),
(9, NULL, 11, 2, '2025-05-17 19:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pembelian`
--

CREATE TABLE `riwayat_pembelian` (
  `id_riwayat` int(11) NOT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `status` enum('proses','pending','disetujui','ditolak') DEFAULT 'proses',
  `catatan` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_pembelian`
--

INSERT INTO `riwayat_pembelian` (`id_riwayat`, `id_pembelian`, `status`, `catatan`, `updated_at`) VALUES
(1, 5, 'disetujui', 'warna yang akan dikirim warna hitam', '2025-05-13 08:39:40'),
(2, 6, 'pending', 'test', '2025-05-13 08:41:14'),
(3, 7, 'proses', 'oke untuk warna sesuai yang di sepakati', '2025-05-13 08:54:44'),
(4, 8, 'proses', 'untuk sementara tidak ada catatan', '2025-05-14 05:40:45'),
(5, 9, 'proses', 'tulisan catatan, mobil siap di antar', '2025-05-17 19:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nama_subkriteria` varchar(100) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_subkriteria`, `id_kriteria`, `nama_subkriteria`, `nilai`) VALUES
(7, 10, 'Hemat', 5.00),
(10, 11, 'Lengkap', 5.00),
(11, 11, 'Cukup Lengkap', 3.00),
(13, 10, 'Sedang', 3.00),
(14, 10, 'Boros', 1.00),
(15, 11, 'Tidak Lengkap', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','pelanggan','sales') DEFAULT 'pelanggan',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `alamat`, `role`, `created_at`) VALUES
(3, 'Sales A', 'sales@gmail.com', '$2y$10$lf2IaT1t5UXmbit.kzaIeeeex9b9AxS5qhe2Z4F3cey4Sx0bOu6ei', 'Jl. Melati No.7', 'sales', '2025-04-09 08:09:30'),
(8, 'andi', 'andi@gmail.com', '$2y$10$uzvEPrTOdvlUayYmijC8duIEqEQ1nVWaesUJ2oNUuOaP056AKdNgu', 'jl irigasi no. 22', 'admin', '2025-04-29 11:59:09'),
(9, 'Putri', 'puts@gmail.com', '$2y$10$z5yGtOWoQmnAivwOzCjKnuf.y6zmwGrBqfj35a744T87rBAeFjZj6', 'jl test alamat', 'pelanggan', '2025-04-30 21:02:20'),
(11, 'irwan', 'irwan@gmail.com', '$2y$10$RZ9wCpZ/OKwpCjWQsEaGpeOQI/vqIgdZeqS8pW0XkviDCbwlJEnSO', 'jl. irigasi blok cobek losari jawa barat', 'pelanggan', '2025-05-09 01:26:57'),
(13, 'Putri', 'putri@gmail.com', '$2y$10$xCa7huS4qNQJgXHpi05fWOSUSuDwX9hnf6cFgSwxE5Yyt0cHTH60C', 'jl. irigasi no. 15 purworejo jawa tengah', 'pelanggan', '2025-05-13 08:51:10'),
(14, 'Rudi S', 'ruds@gmail.com', '$2y$10$7EpFAIir/TF3n24I4UhXyuUuQc8vZUdjiPjgCLl/qil4jd.Nc7CPu', 'jl. pramuka no. 15 karang sembung', 'sales', '2025-05-13 09:21:03'),
(15, 'riza', 'riza@gmail.com', '$2y$10$TEHLI.YUDe/7FPEobuZp4ut0Lavb2.BoikmFiXKJzvLeTooCF3wue', 'jl. irigasi blok cobek mulysari', 'pelanggan', '2025-05-15 11:25:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_perhitungan`
--
ALTER TABLE `hasil_perhitungan`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_mobil` (`id_mobil`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `id_sales` (`id_sales`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `fk_penilaian_subkriteria` (`id_subkriteria`);

--
-- Indexes for table `perbandingan`
--
ALTER TABLE `perbandingan`
  ADD PRIMARY KEY (`id_perbandingan`);

--
-- Indexes for table `perbandingan_detail`
--
ALTER TABLE `perbandingan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perbandingan_hasil`
--
ALTER TABLE `perbandingan_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perhitungan_temp`
--
ALTER TABLE `perhitungan_temp`
  ADD PRIMARY KEY (`id_temp`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `fk_perhitungan_temp_perbandingan` (`id_perbandingan`);

--
-- Indexes for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_pembelian` (`id_pembelian`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_perhitungan`
--
ALTER TABLE `hasil_perhitungan`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `perbandingan`
--
ALTER TABLE `perbandingan`
  MODIFY `id_perbandingan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `perbandingan_detail`
--
ALTER TABLE `perbandingan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `perbandingan_hasil`
--
ALTER TABLE `perbandingan_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `perhitungan_temp`
--
ALTER TABLE `perhitungan_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_perhitungan`
--
ALTER TABLE `hasil_perhitungan`
  ADD CONSTRAINT `hasil_perhitungan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_perhitungan_ibfk_2` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`),
  ADD CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`id_sales`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_subkriteria` FOREIGN KEY (`id_subkriteria`) REFERENCES `sub_kriteria` (`id_subkriteria`),
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `perhitungan_temp`
--
ALTER TABLE `perhitungan_temp`
  ADD CONSTRAINT `fk_perhitungan_temp_perbandingan` FOREIGN KEY (`id_perbandingan`) REFERENCES `perbandingan` (`id_perbandingan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perhitungan_temp_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `perhitungan_temp_ibfk_2` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  ADD CONSTRAINT `riwayat_pembelian_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`);

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
