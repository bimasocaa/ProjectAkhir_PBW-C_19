-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 06:58 PM
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
-- Database: `perpustakaan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama`, `alamat`, `no_telepon`, `email`, `tanggal_daftar`) VALUES
(1, 'Rina Andayani', 'Jl. Merdeka No. 12', '081234567890', 'rina@gmail.com', '2025-06-01'),
(2, 'Budi Santoso', 'Jl. Mawar No. 3', '082134567891', 'budi.santoso@yahoo.com', '2025-06-02'),
(3, 'Siti Aminah', 'Jl. Anggrek No. 7', '081334567892', 'siti_aminah@gmail.com', '2025-06-03'),
(4, 'Dedi Mulyadi', 'Jl. Kenanga No. 14', '082234567893', 'dedi.mulyadi@outlook.com', '2025-06-04'),
(5, 'Ani Lestari', 'Jl. Flamboyan No. 9', '081434567894', 'ani.lestari@gmail.com', '2025-06-05'),
(6, 'Wahyu Prasetyo', 'Jl. Cemara No. 2', '081534567895', 'wahyu.prasetyo@yahoo.com', '2025-06-06'),
(7, 'Nur Aini', 'Jl. Melati No. 15', '082334567896', 'nur.aini@gmail.com', '2025-06-07'),
(8, 'Hendra Saputra', 'Jl. Dahlia No. 6', '081634567897', 'hendra_saputra@gmail.com', '2025-06-08'),
(9, 'Linda Kusuma', 'Jl. Teratai No. 18', '081734567898', 'linda.kusuma@ymail.com', '2025-06-09'),
(10, 'Rizky Aditya', 'Jl. Sawo No. 11', '082434567899', 'rizky.aditya@gmail.com', '2025-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_pengarang` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `jumlah_buku` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `id_pengarang`, `id_penerbit`, `tahun_terbit`, `isbn`, `jumlah_buku`) VALUES
(2, 'superman', 3, 2, '2009', '8900', 43),
(3, 'Laskar Pelangi', 1, 1, '2005', '9786020329571', 25),
(5, 'Bumi', 1, 2, '2014', '9786020329873', 30),
(6, 'Ayat-Ayat Cinta', 3, 1, '2004', '9789793062791', 20),
(8, 'Dilan 1990', 4, 1, '2015', '9786020332958', 27),
(9, 'Pulang', 5, 3, '2012', '9786020304924', 18),
(11, 'Koala Kumal', 6, 2, '2015', '9786020338912', 35),
(12, 'Cinta Brontosaurus', 6, 2, '2006', '9786029824546', 21),
(13, 'Sabtu Bersama Bapak', 7, 1, '2014', '9786020304566', 24),
(14, 'Critical Eleven', 8, 2, '2015', '9786020339222', 29),
(15, 'Hujan', 1, 3, '2016', '9786020332988', 40),
(16, 'Perahu Kertas', 5, 1, '2009', '9789791227253', 34),
(18, 'Dear Nathan', 9, 3, '2016', '9786020822120', 17),
(19, 'Antologi Rasa', 8, 2, '2011', '9786020339130', 19),
(20, 'Garis Waktu', 10, 1, '2016', '9786020329995', 13),
(22, 'Kambing Jantan', 6, 2, '2005', '9789793062517', 33);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `role`) VALUES
(2, 'bimasoca', '12345', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT curdate(),
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_anggota`, `id_buku`, `id_petugas`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 2, 2, NULL, '2025-06-20', '0000-00-00', 'kembali'),
(46, 3, 3, NULL, '2025-06-10', NULL, 'dipinjam'),
(47, 9, 18, NULL, '2025-06-11', NULL, 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`, `no_telepon`) VALUES
(1, 'Inti daya energitama', 'Jl. Palmerah Barat No. 29-37, Jakarta', '021-53650110'),
(2, 'Mizan Media Utama', 'Jl. Cinambo No. 135, Bandung', '022-7213730'),
(3, 'Bentang Pustaka', 'Jl. Pandega Padma, Sleman, Yogyakarta', '0274-123456'),
(4, 'GagasMedia', 'Jl. Kemang Selatan No. 99, Jakarta Selatan', '021-7654321'),
(5, 'Erlangga', 'Jl. H. Baping Raya No.100, Ciracas, Jakarta Timur', '021-8401500');

-- --------------------------------------------------------

--
-- Table structure for table `pengarang`
--

CREATE TABLE `pengarang` (
  `id_pengarang` int(11) NOT NULL,
  `nama_pengarang` varchar(100) NOT NULL,
  `negara_asal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengarang`
--

INSERT INTO `pengarang` (`id_pengarang`, `nama_pengarang`, `negara_asal`) VALUES
(1, 'Tere Liye', 'Indonesia'),
(2, 'Andrea Hirata', 'Indonesia'),
(3, 'J.K. Rowling', 'Inggris'),
(4, 'Dan Brown', 'Amerika Serikat'),
(5, 'Habiburrahman El Shirazy', 'Indonesia'),
(6, 'Agustinus Wibowo', 'Indonesia'),
(7, 'Ahmad Fuadi', 'Indonesia'),
(8, 'Dee Lestari', 'Indonesia'),
(9, 'George Orwell', 'Inggris'),
(10, 'Ernest Hemingway', 'Amerika Serikat');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `denda` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `email`, `no_telepon`) VALUES
(1, 'Bima', 'bimasoca', '$2y$10$h863UPi6Ltz9hUrHANBDJuDS9RnXa.2FpTkdi9Dz76oBiJqC/9ncG', NULL, NULL),
(3, 'soca', 'Bima Soca Pangestu', '$2y$10$4M/WsnmV9sa5o.uLStuBROCz8AW.iQTo1y7hskR/rNldtpLq0DHQq', NULL, NULL),
(5, 'pangestu', 'pangestu23', '$2y$10$2C0RV805TVYSQT4wSVXmHegaB33i1Gg/hT/YE8Qd7d5.jsUZM1SOC', NULL, NULL),
(6, 'Dewi Lestari', 'dewilestari', 'dewi123', 'dewi.lestari@example.com', '081234567891'),
(7, 'Agus Salim', 'agussalim', 'agus123', 'agus.salim@example.com', '081234567892'),
(8, 'Rina Marlina', 'rinam', 'rina123', 'rina.marlina@example.com', '081234567893'),
(9, 'Fajar Nugraha', 'fajarn', 'fajar123', 'fajar.nugraha@example.com', '081234567894'),
(10, 'Siti Aminah', 'sitiah', 'siti123', 'siti.aminah@example.com', '081234567895'),
(11, 'Teguh Santoso', 'teguhs', 'teguh123', 'teguh.santoso@example.com', '081234567896'),
(12, 'Yulianti', 'yuli', 'yuli123', 'yulianti@example.com', '081234567897');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_pengarang` (`id_pengarang`),
  ADD KEY `id_penerbit` (`id_penerbit`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `pengarang`
--
ALTER TABLE `pengarang`
  ADD PRIMARY KEY (`id_pengarang`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengarang`
--
ALTER TABLE `pengarang`
  MODIFY `id_pengarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_pengarang`) REFERENCES `pengarang` (`id_pengarang`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
