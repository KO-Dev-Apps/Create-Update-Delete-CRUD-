-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2025 at 01:41 AM
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
-- Database: `data_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_hp` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp`) VALUES
('C001', 'Andi Wijaya', 2147483647),
('C002', 'Sari Dewi', 2147483647),
('C003', 'Budi Santoso', 2147483647),
('C004', 'Maya Indah', 2147483647),
('C005', 'Rizki Pratama', 2147483647),
('C006', 'Dian Permata', 2147483647),
('C007', 'Fajar Nugroho', 2147483647),
('C008', 'Gita Saraswati', 2147483647),
('C009', 'Hendra Gunawan', 2147483647),
('C010', 'Intan Purnama', 2147483647),
('C011', 'Joko Susilo', 2147483647),
('C012', 'Kartika Sari', 2147483647),
('C013', 'Lutfi Rahman', 2147483647),
('C014', 'Ninda Ayu', 2147483647),
('C015', 'Oki Setiawan', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(100) NOT NULL,
  `id_produk` varchar(100) NOT NULL,
  `id_pelanggan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(100) NOT NULL,
  `total_harga` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_produk`, `id_pelanggan`, `tanggal`, `jumlah`, `total_harga`) VALUES
('S001', 'P001', 'C001', '2024-01-15', 1, 15000000),
('S002', 'P002', 'C002', '2024-01-16', 2, 24000000),
('S003', 'P003', 'C003', '2024-01-17', 1, 8000000),
('S004', 'P004', 'C001', '2024-01-18', 1, 5000000),
('S005', 'P005', 'C004', '2024-01-19', 3, 7500000),
('S006', 'P001', 'C005', '2024-01-20', 1, 15000000),
('S007', 'P002', 'C003', '2024-01-21', 1, 12000000),
('S008', 'P004', 'C002', '2024-01-22', 2, 10000000),
('S009', 'P006', 'C006', '2024-01-23', 2, 1600000),
('S010', 'P007', 'C007', '2024-01-24', 3, 1500000),
('S011', 'P008', 'C008', '2024-01-25', 1, 2000000),
('S012', 'P009', 'C009', '2024-01-26', 1, 1500000),
('S013', 'P010', 'C010', '2024-01-27', 2, 2400000),
('S014', 'P011', 'C011', '2024-01-28', 5, 2000000),
('S015', 'P012', 'C012', '2024-01-29', 10, 750000),
('S016', 'P013', 'C013', '2024-01-30', 1, 600000),
('S017', 'P014', 'C014', '2024-02-01', 2, 1800000),
('S018', 'P015', 'C015', '2024-02-02', 4, 3200000),
('S019', 'P003', 'C001', '2024-02-03', 1, 8000000),
('S020', 'P005', 'C002', '2024-02-04', 2, 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(100) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int(100) NOT NULL,
  `stok` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `stok`) VALUES
('P001', 'Laptop ASUS ROG', 15000000, 15),
('P002', 'Smartphone Samsung S23', 12000000, 25),
('P003', 'Tablet iPad Air', 8000000, 20),
('P004', 'Smartwatch Apple', 5000000, 30),
('P005', 'Headphone Sony', 2500000, 40),
('P006', 'Keyboard Mechanical', 800000, 50),
('P007', 'Mouse Gaming', 500000, 60),
('P008', 'Monitor 24 inch', 2000000, 18),
('P009', 'Printer Epson', 1500000, 22),
('P010', 'Speaker JBL', 1200000, 35),
('P011', 'Power Bank 20000mAh', 400000, 45),
('P012', 'Kabel Data Type-C', 75000, 100),
('P013', 'Webcam HD', 600000, 28),
('P014', 'SSD 512GB', 900000, 32),
('P015', 'RAM 16GB DDR4', 800000, 40),
('P016', 'Lenovo idea Slim Pad 3i', 4500000, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`,`id_pelanggan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
