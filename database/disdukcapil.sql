-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2025 at 07:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `disdukcapil`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas_pengajuan`
--

CREATE TABLE `berkas_pengajuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nama_berkas` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berkas_pengajuan`
--

INSERT INTO `berkas_pengajuan` (`id`, `nama`, `nama_berkas`, `file_path`, `uploaded_at`) VALUES
(6, NULL, 'Foto KTP', '1767126059_unnamed.jpg', '2025-12-31 03:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_layanan`
--

CREATE TABLE `jenis_layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_layanan`
--

INSERT INTO `jenis_layanan` (`id`, `nama_layanan`, `deskripsi`, `created_at`) VALUES
(1, 'KTP Elektronik', 'Pengajuan pembuatan dan perpanjangan KTP secara online.', '2025-12-31 03:41:26'),
(2, 'Kartu Keluarga', 'Pengurusan KK baru, perubahan, dan pembaruan data.', '2025-12-31 03:41:26'),
(3, 'Akta Kelahiran', 'Pengajuan akta kelahiran anak secara online.', '2025-12-31 03:41:26'),
(4, 'Akta Kematian', 'Pelaporan dan penerbitan akta kematian.', '2025-12-31 03:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nik` int(20) NOT NULL,
  `jenis_dokumen` varchar(100) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') DEFAULT 'Menunggu',
  `keterangan` text DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `nama`, `email`, `nik`, `jenis_dokumen`, `tanggal_pengajuan`, `status`, `keterangan`, `catatan_admin`) VALUES
(6, 'Icut Miralda Lambate', 'icutm@gmail.com', 2147483647, 'KTP Elektronik', '2025-12-30', 'Selesai', 'KTP saya hilang, dan saya tinggal jauh dari kantor catatan sipil.\r\n', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nik`, `email`, `password`, `created_at`, `role`) VALUES
(2, 'Icut Miralda Lambate', '72892829920', 'icutm@gmail.com', '$2y$10$GaStDct1lk6dB.pgBp0W8OIC34jCYAmmr6yHwrzQV4bhZdeIAL6tO', '2025-12-30 17:36:09', 'user'),
(3, 'Icut Miralda Lambate', '2829200288', 'icutt@gmail.com', '$2y$10$xmND7FOJWcUTca.wy03Bve6kpFCd0OPkqjcW6ddmcIgON8m6LzWB2', '2025-12-30 18:59:38', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas_pengajuan`
--
ALTER TABLE `berkas_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas_pengajuan`
--
ALTER TABLE `berkas_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
