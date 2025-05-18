-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 06:45 AM
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
-- Database: `db_spk_electre`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `alternatif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `alternatif`) VALUES
(16, 'Produk 1'),
(17, 'Produk 2'),
(18, 'Produk 3'),
(19, 'Produk 4');

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bahan_baku` int(11) NOT NULL,
  `nama_bahan` varchar(100) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id_bahan_baku`, `nama_bahan`, `satuan`, `stok`, `harga`) VALUES
(1, 'Tepung Terigu', 'kg', 123, 26500.00),
(2, 'Plastik', 'pak', 30, 150000.00),
(3, 'Bahan Baku A', 'lusin', 100, 75000.00),
(4, 'Bahan Baku apa saja', 'box', 200, 12500.00);

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `id_bahan_baku` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `id_bahan_baku`, `kode_kriteria`, `kriteria`, `bobot`, `ada_pilihan`) VALUES
(9, 1, 'K1', 'kriteria b1 1', 0.4, 1),
(10, 1, 'K2', 'kriteria b1 2', 0.25, 1),
(11, 1, 'K3', 'kriteria b1 3', 0.35, 1),
(12, 2, 'K1', 'kriteria b2 1', 0.45, 0),
(14, 2, 'K2', 'kriteria b2 12', 0.55, 0),
(15, 3, 'K1', 'sasda', 34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_bahan_baku` int(10) NOT NULL,
  `id_supplier` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `id_sub_kriteria` int(10) DEFAULT NULL,
  `nilai` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_bahan_baku`, `id_supplier`, `id_kriteria`, `id_sub_kriteria`, `nilai`) VALUES
(1, 1, 2, 9, 20, NULL),
(2, 1, 2, 10, 22, NULL),
(3, 1, 2, 11, 25, NULL),
(4, 1, 1, 9, 21, NULL),
(5, 1, 1, 10, 23, NULL),
(6, 1, 1, 11, 25, NULL),
(7, 1, 3, 9, 20, NULL),
(8, 1, 3, 10, 23, NULL),
(9, 1, 3, 11, 24, NULL),
(10, 1, 4, 9, 20, NULL),
(11, 1, 4, 10, 23, NULL),
(12, 1, 4, 11, 25, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ranking_supplier`
--

CREATE TABLE `ranking_supplier` (
  `id` int(11) NOT NULL,
  `id_bahan_baku` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `peringkat` int(11) NOT NULL,
  `score` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ranking_supplier`
--

INSERT INTO `ranking_supplier` (`id`, `id_bahan_baku`, `id_supplier`, `peringkat`, `score`, `created_at`) VALUES
(3, 1, 1, 1, 3, '2025-02-20 02:55:57'),
(4, 1, 4, 2, 1, '2025-02-20 02:55:57'),
(5, 1, 2, 3, 0, '2025-02-20 02:55:57'),
(6, 1, 3, 3, 0, '2025-02-20 02:55:57'),
(7, 1, 1, 1, 3, '2025-02-20 02:57:15'),
(8, 1, 4, 2, 1, '2025-02-20 02:57:15'),
(9, 1, 2, 3, 0, '2025-02-20 02:57:15'),
(10, 1, 3, 3, 0, '2025-02-20 02:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `sub_kriteria` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `sub_kriteria`, `nilai`) VALUES
(15, 12, 'test 1', 7),
(16, 12, 'test 2', 5),
(17, 12, 'test 3', 1),
(18, 14, 'test b2 121', 3),
(19, 14, 'test b2 122', 4),
(20, 9, 'tepung terigu 1 sub 1', 2),
(21, 9, 'tepung terigu 2 sub 1', 5),
(22, 10, 'tepung terigu 1 sub 2', 7),
(23, 10, 'tepung terigu 2 sub 2', 1),
(24, 11, 'tepung terigu 1 sub 3', 4),
(25, 11, 'tepung terigu 2 sub 3', 5);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `kontak`, `email`, `created_at`) VALUES
(1, 'PT. Chatandra', 'jalan pondok pinang jakarta selatan', '0819889077333', 'cht@chatandra.co.id', '2025-02-15 02:00:45'),
(2, 'CV abc', 'alamat', '02198343xxx', 'abc@gmail.com', '2025-02-15 16:43:04'),
(3, 'PD Zainudin Jaya', 'jl road street', '087xxx', 'pdzj@gmail.com', '2025-02-15 16:44:29'),
(4, 'Cobex Tech Solutions', 'jl . irigasi blok cobek ', '08889077xxx', 'cts@cobextechsolutions.com', '2025-02-15 16:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_bahan_baku`
--

CREATE TABLE `supplier_bahan_baku` (
  `id_supplier_bahan_baku` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_bahan_baku` int(11) NOT NULL,
  `harga_supplier` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_bahan_baku`
--

INSERT INTO `supplier_bahan_baku` (`id_supplier_bahan_baku`, `id_supplier`, `id_bahan_baku`, `harga_supplier`) VALUES
(1, 2, 1, 150000.00),
(2, 1, 1, 155000.00),
(3, 3, 1, 75100.00),
(4, 4, 1, 100000.00),
(5, 1, 2, 15000.00),
(6, 4, 2, 115000.00),
(7, 3, 2, 95000.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `role`) VALUES
(15, 'direktur', '$2y$10$c.z/ooLRhz5IcJFZSpt8N.466FHiHZkh9ktZfMcaNfWl8wWHSNFP6', 'Andi S', 'asdas@asd', '2'),
(16, 'admin', '$2y$10$F28pNZKlU4ib9x07wkHmjen.faY/51wOdeF3k8ymNjgZTLyHKE1W6', 'admin', 'admin@gmail.com', '1'),
(19, '123', '$2y$10$gRwTdO3wOnleWZhqCFwtO.L4WHEcs7fyqq3VUohRyMbdMJQJOLzr6', 'tes nama', 'tes.email@m.co.id', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id_bahan_baku`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `fk_hasil` (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`),
  ADD KEY `fk_kriteria_bahanbaku` (`id_bahan_baku`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_supplier` (`id_supplier`),
  ADD KEY `fk_penilaian_kriteria` (`id_kriteria`),
  ADD KEY `fk_penilaian_bahan_baku` (`id_bahan_baku`),
  ADD KEY `fk_penilaian_sub_kriteria` (`id_sub_kriteria`);

--
-- Indexes for table `ranking_supplier`
--
ALTER TABLE `ranking_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bahan_baku` (`id_bahan_baku`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `fk_sub_kriteria_id_kriteria` (`id_kriteria`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `supplier_bahan_baku`
--
ALTER TABLE `supplier_bahan_baku`
  ADD PRIMARY KEY (`id_supplier_bahan_baku`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id_bahan_baku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ranking_supplier`
--
ALTER TABLE `ranking_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier_bahan_baku`
--
ALTER TABLE `supplier_bahan_baku`
  MODIFY `id_supplier_bahan_baku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `fk_hasil` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `fk_penilaian_bahanbaku` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_bahan_baku` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penilaian_sub_kriteria` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penilaian_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ranking_supplier`
--
ALTER TABLE `ranking_supplier`
  ADD CONSTRAINT `ranking_supplier_ibfk_1` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ranking_supplier_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `fk_sub_kriteria_id_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_bahan_baku`
--
ALTER TABLE `supplier_bahan_baku`
  ADD CONSTRAINT `supplier_bahan_baku_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_bahan_baku_ibfk_2` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
