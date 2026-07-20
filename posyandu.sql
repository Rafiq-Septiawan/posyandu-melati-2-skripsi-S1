-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2026 at 07:45 AM
-- Server version: 8.4.3
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `balita`
--

CREATE TABLE `balita` (
  `id` bigint UNSIGNED NOT NULL,
  `ibu_hamil_id` bigint UNSIGNED DEFAULT NULL,
  `nama_balita` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balita`
--

INSERT INTO `balita` (`id`, `ibu_hamil_id`, `nama_balita`, `nik`, `tanggal_lahir`, `jenis_kelamin`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 12, 'Naufal Wijaya', '3276020539502402', '2025-09-14', 'L', '2026-06-26 17:00:00', '2026-06-26 17:00:00', NULL, NULL),
(2, 34, 'Kenzo Saputra', '3276775891783908', '2023-03-27', 'L', '2026-06-29 17:00:00', '2026-06-29 17:00:00', NULL, NULL),
(3, 42, 'Muhammad Nurjaman', '3276661771159212', '2023-02-01', 'L', '2026-07-09 17:00:00', '2026-07-09 17:00:00', NULL, NULL),
(4, 41, 'Divya Maulana', '3276847896118367', '2022-10-28', 'P', '2026-06-26 17:00:00', '2026-06-26 17:00:00', NULL, NULL),
(5, 22, 'Divya Wibowo', '3276156545271111', '2023-12-19', 'P', '2026-06-06 17:00:00', '2026-06-06 17:00:00', NULL, NULL),
(6, 48, 'Queenta Pratama', '3276809885165604', '2024-11-28', 'P', '2026-06-19 17:00:00', '2026-06-19 17:00:00', NULL, NULL),
(7, 23, 'Hafiz Hidayat', '3276327315851493', '2026-01-26', 'L', '2026-06-27 17:00:00', '2026-06-27 17:00:00', NULL, NULL),
(8, 36, 'Iqbal Kurniawan', '3276402445502296', '2021-12-07', 'L', '2026-06-09 17:00:00', '2026-06-09 17:00:00', NULL, NULL),
(9, 48, 'Rizky Anggara', '3276836675254599', '2022-01-07', 'L', '2026-06-03 17:00:00', '2026-06-03 17:00:00', NULL, NULL),
(10, 10, 'Nabil Maulana', '3276014767976438', '2022-03-08', 'L', '2026-06-22 17:00:00', '2026-06-22 17:00:00', NULL, NULL),
(11, 28, 'Ilham Alfarizi', '3276978403690034', '2022-09-23', 'L', '2026-06-08 17:00:00', '2026-06-08 17:00:00', NULL, NULL),
(12, 49, 'Kirana Setiawan', '3276107622683885', '2021-12-12', 'P', '2026-06-25 17:00:00', '2026-06-25 17:00:00', NULL, NULL),
(13, 48, 'Reza Ramadhan', '3276715969664160', '2023-05-14', 'L', '2026-06-10 17:00:00', '2026-06-10 17:00:00', NULL, NULL),
(14, 40, 'Raisa Anggara', '3276516136968164', '2025-09-22', 'P', '2026-06-21 17:00:00', '2026-06-21 17:00:00', NULL, NULL),
(15, 15, 'Prisha Pratama', '3276181883552312', '2022-12-24', 'P', '2026-06-12 17:00:00', '2026-06-12 17:00:00', NULL, NULL),
(16, 12, 'Nabil Permana', '3276127799799552', '2024-01-04', 'L', '2026-06-04 17:00:00', '2026-06-04 17:00:00', NULL, NULL),
(17, 31, 'Latisha Nugroho', '3276490581477005', '2026-03-17', 'P', '2026-06-18 17:00:00', '2026-06-18 17:00:00', NULL, NULL),
(18, 5, 'Iqbal Maulana', '3276867980793597', '2024-05-09', 'L', '2026-06-09 17:00:00', '2026-06-09 17:00:00', NULL, NULL),
(19, 4, 'Keisha Permana', '3276518203778892', '2023-08-02', 'P', '2026-06-23 17:00:00', '2026-06-23 17:00:00', NULL, NULL),
(20, 19, 'Elora Permana', '3276590515186449', '2026-06-10', 'P', '2026-06-09 17:00:00', '2026-06-09 17:00:00', NULL, NULL),
(21, 22, 'Hafiz Alfarizi', '3276254629148652', '2025-04-20', 'L', '2026-07-14 17:00:00', '2026-07-14 17:00:00', NULL, NULL),
(22, 48, 'Kevin Alfarizi', '3276685054235733', '2022-04-25', 'L', '2026-06-09 17:00:00', '2026-06-09 17:00:00', NULL, NULL),
(23, 5, 'Syifa Permana', '3276188805929622', '2022-07-23', 'P', '2026-07-14 17:00:00', '2026-07-14 17:00:00', NULL, NULL),
(24, 50, 'Kenzo Nurjaman', '3276065379473834', '2026-01-29', 'L', '2026-06-30 17:00:00', '2026-06-30 17:00:00', NULL, NULL),
(25, 13, 'Meira Maulana', '3276774688623924', '2021-11-01', 'P', '2026-07-11 17:00:00', '2026-07-11 17:00:00', NULL, NULL),
(26, 31, 'Inara Kurniawan', '3276181412478261', '2022-10-15', 'P', '2026-06-28 17:00:00', '2026-06-28 17:00:00', NULL, NULL),
(27, 23, 'Reza Ramadhan', '3276685361530515', '2025-12-24', 'L', '2026-06-09 17:00:00', '2026-06-09 17:00:00', NULL, NULL),
(28, 9, 'Ilham Kurniawan', '3276727790104328', '2025-08-15', 'L', '2026-07-08 17:00:00', '2026-07-08 17:00:00', NULL, NULL),
(29, 34, 'Keisha Permana', '3276434103697117', '2024-11-21', 'P', '2026-07-04 17:00:00', '2026-07-04 17:00:00', NULL, NULL),
(30, 2, 'Farrel Pratama', '3276460953962185', '2021-12-03', 'L', '2026-07-03 17:00:00', '2026-07-03 17:00:00', NULL, NULL),
(31, 35, 'Fikri Wijaya', '3276706540515319', '2025-08-31', 'L', '2026-06-21 17:00:00', '2026-06-21 17:00:00', NULL, NULL),
(32, 9, 'Yusuf Hidayat', '3276527722170430', '2025-12-24', 'L', '2026-06-12 17:00:00', '2026-06-12 17:00:00', NULL, NULL),
(33, 3, 'Ulima Nugroho', '3276868740345054', '2022-03-29', 'P', '2026-06-23 17:00:00', '2026-06-23 17:00:00', NULL, NULL),
(34, 28, 'Olive Nurjaman', '3276652775841616', '2024-12-02', 'P', '2026-06-11 17:00:00', '2026-06-11 17:00:00', NULL, NULL),
(35, 35, 'Anindya Saputra', '3276154479627570', '2025-08-14', 'P', '2026-06-22 17:00:00', '2026-06-22 17:00:00', NULL, NULL),
(36, 40, 'Alesha Alfarizi', '3276016582029702', '2021-12-02', 'P', '2026-06-15 17:00:00', '2026-06-15 17:00:00', NULL, NULL),
(37, 50, 'Chelsea Wibowo', '3276909275571928', '2023-08-08', 'P', '2026-06-25 17:00:00', '2026-06-25 17:00:00', NULL, NULL),
(38, 21, 'Fathiya Saputra', '3276027868144739', '2023-02-22', 'P', '2026-07-14 17:00:00', '2026-07-14 17:00:00', NULL, NULL),
(39, 32, 'Fajar Pratama', '3276172715518844', '2026-04-26', 'L', '2026-06-10 17:00:00', '2026-06-10 17:00:00', NULL, NULL),
(40, 46, 'Raffasya Setiawan', '3276831323705895', '2024-03-01', 'L', '2026-07-05 17:00:00', '2026-07-05 17:00:00', NULL, NULL),
(41, 9, 'Rizky Nugroho', '3276678669125177', '2025-05-10', 'L', '2026-07-03 17:00:00', '2026-07-03 17:00:00', NULL, NULL),
(42, 23, 'Gibran Wijaya', '3276892268018242', '2022-06-14', 'L', '2026-06-20 17:00:00', '2026-06-20 17:00:00', NULL, NULL),
(43, 46, 'Yusuf Hidayat', '3276414384249818', '2025-02-19', 'L', '2026-06-10 17:00:00', '2026-06-10 17:00:00', NULL, NULL),
(44, 38, 'Dimas Alfarizi', '3276995900109439', '2023-11-18', 'L', '2026-07-09 17:00:00', '2026-07-09 17:00:00', NULL, NULL),
(45, 41, 'Wahyu Kurniawan', '3276844736471027', '2023-11-16', 'L', '2026-06-30 17:00:00', '2026-06-30 17:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ibu_hamil`
--

CREATE TABLE `ibu_hamil` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_ibu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravida` int NOT NULL DEFAULT '1',
  `partus` int NOT NULL DEFAULT '0',
  `abortus` int NOT NULL DEFAULT '0',
  `hpht` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ibu_hamil`
--

INSERT INTO `ibu_hamil` (`id`, `user_id`, `nama_ibu`, `nik`, `tanggal_lahir`, `no_hp`, `alamat`, `gravida`, `partus`, `abortus`, `hpht`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 2, 'Silvia Rahayu', '3276701543039117', '1989-07-20', '081234567802', 'Jl. Jenderal Sudirman Gang Belimbing, RT.003/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 1, 0, '2025-12-16', '2026-07-08 17:00:00', '2026-07-08 17:00:00', 6, 6),
(2, 14, 'Wulan Sari', '3276383465787133', '1989-06-08', '081234500005', 'Jl. Jenderal Sudirman Gang Jambu Babakan, RT.001/RW.009, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 0, '2026-01-18', '2026-07-15 17:00:00', '2026-07-15 17:00:00', 3, 3),
(3, 23, 'Susi Kusuma', '3276310518347382', '2004-03-22', '081234500014', 'Jl. Jenderal Sudirman Gang Salak Buaran, RT.008/RW.004, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 3, 0, '2026-01-21', '2026-06-06 17:00:00', '2026-06-06 17:00:00', 6, 6),
(4, 27, 'Dewi Kurniawati', '3276566701065133', '1992-04-07', '081234500018', 'Jl. Jenderal Sudirman Gang Belimbing, RT.008/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 1, 0, '2025-12-08', '2026-06-15 17:00:00', '2026-06-15 17:00:00', 3, 3),
(5, 18, 'Wahyu Pratiwi', '3276781080132677', '1992-10-17', '081234500009', 'Jl. Jenderal Sudirman Gang Duku, RT.001/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 1, '2026-05-20', '2026-06-29 17:00:00', '2026-06-29 17:00:00', 5, 5),
(6, 20, 'Tika Suryani', '3276687234309805', '1989-04-13', '081234500011', 'Jl. Jenderal Sudirman Gang Buaran Kandang Besar, RT.008/RW.009, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 1, 0, '2026-03-15', '2026-06-05 17:00:00', '2026-06-05 17:00:00', 4, 4),
(7, 34, 'Siti Widiastuti', '3276191361939909', '1989-11-02', '081234500025', 'Jl. Jenderal Sudirman Gang Anggrek Buaran, RT.009/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 0, 0, '2026-02-08', '2026-06-16 17:00:00', '2026-06-16 17:00:00', 6, 6),
(8, 47, 'Nur Rosmawati', '3276247510799118', '1992-10-12', '081234500038', 'Jl. Jenderal Sudirman Gang Kemuning, RT.005/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 0, 0, '2025-11-26', '2026-06-18 17:00:00', '2026-06-18 17:00:00', 4, 4),
(9, 36, 'Umi Utami', '3276784980841241', '1990-05-26', '081234500027', 'Jl. Jenderal Sudirman Gang Pala Buaran, RT.009/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 1, 0, '2026-07-17', '2026-06-21 17:00:00', '2026-06-21 17:00:00', 4, 4),
(10, 28, 'Indah Mardiana', '3276487401640052', '2002-04-16', '081234500019', 'Jl. Jenderal Sudirman Gang Nangka Buaran, RT.003/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 3, 0, '2025-10-24', '2026-06-04 17:00:00', '2026-06-04 17:00:00', 4, 4),
(11, 54, 'Vina Ramadhani', '3276805982620450', '1996-01-10', '081234500045', 'Jl. Jenderal Sudirman Gang Delima, RT.004/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 2, 1, '2026-07-05', '2026-06-09 17:00:00', '2026-06-09 17:00:00', 4, 4),
(12, 25, 'Lestari Safitri', '3276226025634216', '1988-11-13', '081234500016', 'Jl. Jenderal Sudirman Gang Mawar Babakan, RT.004/RW.004, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 2, 0, '2026-02-07', '2026-06-14 17:00:00', '2026-06-14 17:00:00', 3, 3),
(13, 37, 'Yanti Maharani', '3276365414586850', '1990-08-02', '081234500028', 'Jl. Jenderal Sudirman Gang Nangka Buaran, RT.003/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 1, 0, 1, '2026-05-31', '2026-07-16 17:00:00', '2026-07-16 17:00:00', 5, 5),
(14, 44, 'Eka Oktaviani', '3276698169340608', '2000-01-28', '081234500035', 'Jl. Jenderal Sudirman Gang Pepaya, RT.004/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2026-07-05', '2026-06-20 17:00:00', '2026-06-20 17:00:00', 3, 3),
(15, 12, 'Rina Marlina', '3276484656482366', '2003-03-11', '081234500003', 'Jl. Jenderal Sudirman Gang Pala Buaran, RT.003/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2026-05-23', '2026-06-13 17:00:00', '2026-06-13 17:00:00', 6, 6),
(16, 39, 'Zahra Susanti', '3276995777387214', '1999-07-24', '081234500030', 'Jl. Jenderal Sudirman Gang Pepaya, RT.006/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 1, 0, '2025-11-04', '2026-06-09 17:00:00', '2026-06-09 17:00:00', 3, 3),
(17, 58, 'Farah Safitri', '3276037917693676', '1993-06-21', '081234500049', 'Jl. Jenderal Sudirman Gang Kenanga Babakan, RT.001/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 1, 0, '2025-12-15', '2026-06-29 17:00:00', '2026-06-29 17:00:00', 3, 3),
(18, 11, 'Dewi Lestari', '3276831727889579', '2004-02-18', '081234500002', 'Jl. Jenderal Sudirman Gang Kemuning, RT.007/RW.009, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 1, 1, '2025-12-06', '2026-06-16 17:00:00', '2026-06-16 17:00:00', 4, 4),
(19, 17, 'Dwi Safitri', '3276487347143455', '2000-02-11', '081234500008', 'Jl. Jenderal Sudirman Gang Mangga, RT.003/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 1, 0, '2025-11-06', '2026-06-04 17:00:00', '2026-06-04 17:00:00', 6, 6),
(20, 21, 'Intan Kurniawati', '3276658760366909', '1996-07-13', '081234500012', 'Jl. Jenderal Sudirman Gang Mawar Babakan, RT.001/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 1, 1, '2026-06-24', '2026-07-04 17:00:00', '2026-07-04 17:00:00', 4, 4),
(21, 41, 'Maya Anggraini', '3276734670656272', '2001-12-15', '081234500032', 'Jl. Jenderal Sudirman Gang Belimbing, RT.001/RW.007, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 4, 0, '2025-10-20', '2026-07-11 17:00:00', '2026-07-11 17:00:00', 6, 6),
(22, 51, 'Oktavia Aisyah', '3276272046537556', '1994-03-29', '081234500042', 'Jl. Jenderal Sudirman Gang Anggrek Buaran, RT.005/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2026-02-22', '2026-06-14 17:00:00', '2026-06-14 17:00:00', 3, 3),
(23, 35, 'Citra Handayani', '3276003309232719', '1992-11-20', '081234500026', 'Jl. Jenderal Sudirman Gang Sirsak, RT.005/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 0, '2025-11-18', '2026-06-06 17:00:00', '2026-06-06 17:00:00', 3, 3),
(24, 10, 'Siti Aminah', '3276496631931491', '2005-11-09', '081234500001', 'Jl. Jenderal Sudirman Gang Salak Buaran, RT.001/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 3, 0, '2026-01-17', '2026-07-02 17:00:00', '2026-07-02 17:00:00', 5, 5),
(25, 45, 'Rina Suryani', '3276067165726284', '2001-10-24', '081234500036', 'Jl. Jenderal Sudirman Gang Belimbing, RT.008/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 2, 0, '2025-11-10', '2026-06-05 17:00:00', '2026-06-05 17:00:00', 5, 5),
(26, 30, 'Hesti Utami', '3276737996507527', '1992-10-03', '081234500021', 'Jl. Jenderal Sudirman Gang Rambutan, RT.005/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 2, 0, '2025-12-20', '2026-05-31 17:00:00', '2026-05-31 17:00:00', 4, 4),
(27, 16, 'Dewi Suryani', '3276136783777014', '1992-12-20', '081234500007', 'Jl. Jenderal Sudirman Gang Duku, RT.004/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 2, 1, '2026-03-20', '2026-07-03 17:00:00', '2026-07-03 17:00:00', 5, 5),
(28, 40, 'Sri Ramadhani', '3276685574443135', '1990-09-06', '081234500031', 'Jl. Jenderal Sudirman Gang Pala Buaran, RT.009/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 1, '2026-02-13', '2026-07-16 17:00:00', '2026-07-16 17:00:00', 5, 5),
(29, 50, 'Elsa Zulaikha', '3276134352408240', '1989-03-22', '081234500041', 'Jl. Jenderal Sudirman Gang Belimbing, RT.005/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2025-12-22', '2026-06-18 17:00:00', '2026-06-18 17:00:00', 6, 6),
(30, 29, 'Rani Mardiana', '3276775204711671', '2000-12-09', '081234500020', 'Jl. Jenderal Sudirman Gang Jeruk Babakan, RT.001/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 1, 0, '2025-11-10', '2026-06-07 17:00:00', '2026-06-07 17:00:00', 6, 6),
(31, 42, 'Erna Febriyanti', '3276999386774964', '2000-10-02', '081234500033', 'Jl. Jenderal Sudirman Gang Manggis, RT.001/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 0, '2026-04-03', '2026-06-05 17:00:00', '2026-06-05 17:00:00', 4, 4),
(32, 48, 'Maya Ramadhani', '3276328120679740', '1993-03-11', '081234500039', 'Jl. Jenderal Sudirman Gang Cempaka, RT.005/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 1, 0, 0, '2026-07-06', '2026-07-07 17:00:00', '2026-07-07 17:00:00', 4, 4),
(33, 57, 'Tri Ramadhani', '3276618324210249', '2004-10-18', '081234500048', 'Jl. Jenderal Sudirman Gang Salak Buaran, RT.005/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 1, 0, 0, '2026-07-15', '2026-06-25 17:00:00', '2026-06-25 17:00:00', 5, 5),
(34, 55, 'Rina Nabila', '3276887719065940', '1990-01-18', '081234500046', 'Jl. Jenderal Sudirman Gang Kelapa Babakan, RT.001/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 0, 0, '2026-03-10', '2026-07-03 17:00:00', '2026-07-03 17:00:00', 6, 6),
(35, 46, 'Ratih Kurniawati', '3276429671756551', '1991-08-10', '081234500037', 'Jl. Jenderal Sudirman Gang Jambu Babakan, RT.007/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 2, 1, '2025-12-19', '2026-06-02 17:00:00', '2026-06-02 17:00:00', 6, 6),
(36, 24, 'Dewi Ramadhani', '3276154516808760', '1992-03-16', '081234500015', 'Jl. Jenderal Sudirman Gang Kemuning, RT.006/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2026-02-12', '2026-07-05 17:00:00', '2026-07-05 17:00:00', 4, 4),
(37, 43, 'Erna Fadillah', '3276477109324808', '1997-02-24', '081234500034', 'Jl. Jenderal Sudirman Gang Mangga, RT.004/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 0, 0, '2026-06-19', '2026-07-15 17:00:00', '2026-07-15 17:00:00', 5, 5),
(38, 52, 'Gina Nuraini', '3276846773782639', '1999-05-26', '081234500043', 'Jl. Jenderal Sudirman Gang Pala Buaran, RT.003/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 1, 0, '2026-03-14', '2026-06-17 17:00:00', '2026-06-17 17:00:00', 3, 3),
(39, 13, 'Yuni Kartika', '3276449972787558', '2005-02-09', '081234500004', 'Jl. Jenderal Sudirman Gang Belimbing, RT.007/RW.008, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 0, 0, '2026-06-29', '2026-06-24 17:00:00', '2026-06-24 17:00:00', 4, 4),
(40, 56, 'Wahyu Widiastuti', '3276605766270289', '1995-06-12', '081234500047', 'Jl. Jenderal Sudirman Gang Melati Buaran, RT.008/RW.002, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 3, 0, '2026-05-05', '2026-06-26 17:00:00', '2026-06-26 17:00:00', 4, 4),
(41, 22, 'Ani Yulianti', '3276174596158657', '2000-02-19', '081234500013', 'Jl. Jenderal Sudirman Gang Buaran Kandang Besar, RT.002/RW.004, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 0, 0, '2026-06-11', '2026-06-06 17:00:00', '2026-06-06 17:00:00', 3, 3),
(42, 31, 'Wahyu Cahyani', '3276724005045562', '1993-06-23', '081234500022', 'Jl. Jenderal Sudirman Gang Kemuning, RT.007/RW.003, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 0, '2026-07-04', '2026-06-24 17:00:00', '2026-06-24 17:00:00', 4, 4),
(43, 53, 'Julia Puspita', '3276792374740748', '1991-07-18', '081234500044', 'Jl. Jenderal Sudirman Gang Mangga, RT.008/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 2, 1, '2026-07-14', '2026-06-16 17:00:00', '2026-06-16 17:00:00', 6, 6),
(44, 19, 'Yulia Anggraini', '3276436713695944', '1988-06-28', '081234500010', 'Jl. Jenderal Sudirman Gang Pepaya, RT.007/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 1, 0, 1, '2026-02-14', '2026-06-14 17:00:00', '2026-06-14 17:00:00', 5, 5),
(45, 32, 'Kartika Maharani', '3276339421047095', '2004-06-04', '081234500023', 'Jl. Jenderal Sudirman Gang Kenanga Babakan, RT.002/RW.005, Babakan, Kec. Tangerang, Kota Tangerang.', 3, 2, 1, '2026-01-31', '2026-06-12 17:00:00', '2026-06-12 17:00:00', 4, 4),
(46, 49, 'Ika Setiawati', '3276858842474517', '1989-09-08', '081234500040', 'Jl. Jenderal Sudirman Gang Kenanga Babakan, RT.004/RW.007, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 2, 0, '2026-06-06', '2026-05-31 17:00:00', '2026-05-31 17:00:00', 5, 5),
(47, 38, 'Ayu Puspita', '3276817549651370', '2001-11-23', '081234500029', 'Jl. Jenderal Sudirman Gang Belimbing, RT.006/RW.004, Babakan, Kec. Tangerang, Kota Tangerang.', 1, 0, 0, '2026-07-09', '2026-06-26 17:00:00', '2026-06-26 17:00:00', 3, 3),
(48, 26, 'Devi Fadillah', '3276200471138267', '1996-04-27', '081234500017', 'Jl. Jenderal Sudirman Gang Pepaya, RT.009/RW.007, Babakan, Kec. Tangerang, Kota Tangerang.', 5, 1, 1, '2026-04-02', '2026-06-06 17:00:00', '2026-06-06 17:00:00', 6, 6),
(49, 33, 'Citra Febriyanti', '3276964053773515', '2000-03-18', '081234500024', 'Jl. Jenderal Sudirman Gang Jeruk Babakan, RT.006/RW.001, Babakan, Kec. Tangerang, Kota Tangerang.', 4, 2, 0, '2026-01-24', '2026-06-29 17:00:00', '2026-06-29 17:00:00', 3, 3),
(50, 15, 'Puji Anggraini', '3276390053293183', '2001-02-24', '081234500006', 'Jl. Jenderal Sudirman Gang Delima, RT.004/RW.006, Babakan, Kec. Tangerang, Kota Tangerang.', 2, 0, 0, '2025-10-28', '2026-06-08 17:00:00', '2026-06-08 17:00:00', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_posyandu`
--

CREATE TABLE `jadwal_posyandu` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `keterangan` text,
  `status` enum('aktif','selesai','dibatalkan') NOT NULL DEFAULT 'aktif',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_posyandu`
--

INSERT INTO `jadwal_posyandu` (`id`, `judul`, `tanggal`, `jam`, `lokasi`, `keterangan`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Posyandu Ibu Hamil & Balita Rutin', '2026-08-13', '08:00:00', 'Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan)', NULL, 'selesai', 1, '2026-07-13 15:28:50', '2026-07-14 00:58:10'),
(2, 'Imunisasi Balita', '2026-07-23', '08:00:00', 'Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan)', 'Bawa KIA, KTP, KK', 'aktif', 1, '2026-07-14 00:56:59', '2026-07-14 00:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_17_141810_create_ibu_hamil_table', 1),
(5, '2026_04_17_142811_create_balita_table', 1),
(6, '2026_04_17_143228_create_pemeriksaan_balita_table', 1),
(7, '2026_04_17_143250_create_pemeriksaan_ibu_hamil_table', 1),
(8, '2026_04_26_105634_create_pemeriksaan_lanjutan_ibu_hamil_table', 1),
(9, '2026_04_26_105706_create_pemeriksaan_lanjutan_balita_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('jadwal','pemeriksaan','umum') NOT NULL DEFAULT 'umum',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `tipe`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 1, '2026-07-13 15:28:50', '2026-07-13 15:29:18'),
(2, 10, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-13 15:28:50', '2026-07-13 15:28:50'),
(3, 11, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-13 15:28:50', '2026-07-13 15:28:50'),
(4, 12, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-13 15:28:50', '2026-07-13 15:28:50'),
(5, 13, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-13 15:28:50', '2026-07-13 15:28:50'),
(6, 14, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Posyandu Ibu Hamil & Balita Rutin pada tanggal 2026-08-13 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-13 15:28:50', '2026-07-13 15:28:50'),
(7, 1, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 1, '2026-07-14 00:56:59', '2026-07-14 00:57:59'),
(8, 2, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 1, '2026-07-14 00:56:59', '2026-07-14 00:57:22'),
(9, 3, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(10, 4, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(11, 5, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(12, 6, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(13, 7, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 1, '2026-07-14 00:56:59', '2026-07-14 02:36:40'),
(14, 9, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(15, 10, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(16, 11, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(17, 12, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(18, 13, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(19, 14, 'Jadwal Posyandu Baru', 'Jadwal posyandu baru telah ditambahkan: Imunisasi Balita pada tanggal 2026-07-23 pukul 08:00 di Posyandu Melati 2 (Belakang Kantor Kelurahan Babakan).', 'jadwal', 0, '2026-07-14 00:56:59', '2026-07-14 00:56:59'),
(20, 2, 'Pemeriksaan Awal Ibu Hamil Baru', 'Pemeriksaan awal ibu hamil atas nama Silvia Rahayu telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 1, '2026-07-14 01:55:44', '2026-07-14 02:25:41'),
(21, 1, 'Pemeriksaan Awal Ibu Hamil Baru', 'Pemeriksaan awal ibu hamil atas nama Silvia Rahayu telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:55:44', '2026-07-14 01:55:44'),
(22, 7, 'Pemeriksaan Awal Ibu Hamil Baru', 'Pemeriksaan awal ibu hamil atas nama Silvia Rahayu telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:55:44', '2026-07-14 01:55:44'),
(23, 9, 'Pemeriksaan Awal Ibu Hamil Baru', 'Pemeriksaan awal ibu hamil atas nama Silvia Rahayu telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:55:44', '2026-07-14 01:55:44'),
(24, 2, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 1, '2026-07-14 01:56:24', '2026-07-14 02:25:41'),
(25, 1, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:56:24', '2026-07-14 01:56:24'),
(26, 3, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:56:24', '2026-07-14 01:56:24'),
(27, 4, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:56:24', '2026-07-14 01:56:24'),
(28, 5, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:56:24', '2026-07-14 01:56:24'),
(29, 6, 'Pemeriksaan Lanjutan Ibu Hamil Baru', 'Pemeriksaan lanjutan (bidan) ibu hamil atas nama Silvia Rahayu telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 01:56:24', '2026-07-14 01:56:24'),
(30, 2, 'Pemeriksaan Awal Balita Baru', 'Pemeriksaan awal untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 1, '2026-07-14 02:19:33', '2026-07-14 02:25:36'),
(31, 1, 'Pemeriksaan Awal Balita Baru', 'Pemeriksaan awal untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:19:33', '2026-07-14 02:19:33'),
(32, 7, 'Pemeriksaan Awal Balita Baru', 'Pemeriksaan awal untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:19:33', '2026-07-14 02:19:33'),
(33, 9, 'Pemeriksaan Awal Balita Baru', 'Pemeriksaan awal untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh kader pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:19:33', '2026-07-14 02:19:33'),
(34, 2, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 1, '2026-07-14 02:44:02', '2026-07-14 02:49:12'),
(35, 1, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 1, '2026-07-14 02:44:02', '2026-07-16 08:49:19'),
(36, 3, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:44:02', '2026-07-14 02:44:02'),
(37, 4, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:44:02', '2026-07-14 02:44:02'),
(38, 5, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:44:02', '2026-07-14 02:44:02'),
(39, 6, 'Pemeriksaan Lanjutan Balita Baru', 'Pemeriksaan lanjutan (bidan) untuk balita Fadhilatu Adi Ramadan Nur Saputra telah dicatat oleh bidan pada tanggal 2026-07-14.', 'pemeriksaan', 0, '2026-07-14 02:44:02', '2026-07-14 02:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('gilang041104@gmail.com', '$2y$12$qIwEsz4p0IDTOibjeV19sO0l16B9FpxplQNMgJiF4A518qlFaxEnC', '2026-06-02 03:08:24'),
('lauelyo@gmail.com', '$2y$12$pznV6cunVuHuwQ02Pgipd.okGqNTDlQGzj3fIDFNCe7BLGwga5n7W', '2026-05-29 10:34:44'),
('rafiqseptiawan@umt.ac.id', '$2y$12$fSztvLCfpVN8OXspoVZCne/YpAOfAfuUEndDXrR1aYEVvjLDmC.Hu', '2026-05-29 03:29:38'),
('septiawanaja2004@gmail.com', '$2y$12$HIH1/kBJIpQGzCgWgBAUxe3jaGX387sXuIDO.N4BdPJ/2TVjS.2.S', '2026-05-29 03:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_awal_balita`
--

CREATE TABLE `pemeriksaan_awal_balita` (
  `id` bigint UNSIGNED NOT NULL,
  `balita_id` bigint UNSIGNED NOT NULL,
  `kader_id` bigint UNSIGNED NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `usia_balita` int DEFAULT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) NOT NULL,
  `lingkar_kepala` decimal(5,2) NOT NULL,
  `lingkar_lengan` decimal(5,2) NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan_awal_balita`
--

INSERT INTO `pemeriksaan_awal_balita` (`id`, `balita_id`, `kader_id`, `tanggal_periksa`, `usia_balita`, `berat_badan`, `tinggi_badan`, `lingkar_kepala`, `lingkar_lengan`, `keluhan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 6, '2026-04-15', 8, 9.20, 68.50, 37.70, 14.70, 'Susah tidur malam', '2026-06-04 17:00:00', 6, '2026-06-04 17:00:00', 6),
(2, 2, 4, '2026-05-14', 42, 7.50, 52.30, 44.70, 16.60, 'Tidak ada keluhan', '2026-07-12 17:00:00', 4, '2026-07-12 17:00:00', 4),
(3, 3, 5, '2026-05-14', 9, 6.80, 53.20, 40.00, 15.20, 'Batuk pilek ringan', '2026-06-25 17:00:00', 5, '2026-06-25 17:00:00', 5),
(4, 4, 6, '2026-07-15', 10, 17.80, 94.90, 35.40, 13.00, 'Tidak ada keluhan', '2026-06-25 17:00:00', 6, '2026-06-25 17:00:00', 6),
(5, 5, 5, '2026-07-15', 26, 5.90, 64.10, 43.80, 10.10, 'Tidak ada keluhan', '2026-06-29 17:00:00', 5, '2026-06-29 17:00:00', 5),
(6, 6, 6, '2026-06-11', 45, 3.30, 64.90, 42.40, 13.60, 'Batuk pilek ringan', '2026-06-07 17:00:00', 6, '2026-06-07 17:00:00', 6),
(7, 7, 4, '2026-07-15', 56, 4.60, 60.90, 33.60, 15.50, 'Tidak ada keluhan', '2026-06-08 17:00:00', 4, '2026-06-08 17:00:00', 4),
(8, 8, 6, '2026-06-11', 54, 16.70, 94.10, 36.90, 11.00, 'Tidak ada keluhan', '2026-07-06 17:00:00', 6, '2026-07-06 17:00:00', 6),
(9, 9, 6, '2026-05-14', 44, 7.90, 61.70, 45.00, 11.30, 'Batuk pilek ringan', '2026-06-17 17:00:00', 6, '2026-06-17 17:00:00', 6),
(10, 10, 3, '2026-06-11', 40, 4.30, 60.60, 42.10, 11.60, 'Tidak ada keluhan', '2026-06-07 17:00:00', 3, '2026-06-07 17:00:00', 3),
(11, 11, 6, '2026-05-14', 0, 8.10, 78.20, 46.90, 11.90, 'Nafsu makan menurun', '2026-06-02 17:00:00', 6, '2026-06-02 17:00:00', 6),
(12, 12, 4, '2026-04-15', 7, 17.50, 60.70, 35.70, 16.50, 'Tidak ada keluhan', '2026-06-19 17:00:00', 4, '2026-06-19 17:00:00', 4),
(13, 13, 4, '2026-04-15', 18, 9.70, 85.30, 37.10, 15.60, 'Tidak ada keluhan', '2026-06-02 17:00:00', 4, '2026-06-02 17:00:00', 4),
(14, 14, 3, '2026-07-15', 1, 14.00, 78.10, 35.80, 13.30, 'Diare ringan', '2026-06-06 17:00:00', 3, '2026-06-06 17:00:00', 3),
(15, 15, 6, '2026-05-14', 42, 10.40, 95.10, 38.90, 13.50, 'Tidak ada keluhan', '2026-06-13 17:00:00', 6, '2026-06-13 17:00:00', 6),
(16, 16, 4, '2026-05-14', 21, 6.00, 97.90, 43.90, 11.00, 'Rewel', '2026-06-03 17:00:00', 4, '2026-06-03 17:00:00', 4),
(17, 17, 4, '2026-05-14', 0, 4.10, 89.50, 36.80, 11.10, 'Batuk pilek ringan', '2026-07-12 17:00:00', 4, '2026-07-12 17:00:00', 4),
(18, 18, 6, '2026-03-12', 55, 10.60, 103.30, 42.00, 14.80, 'Tidak ada keluhan', '2026-06-29 17:00:00', 6, '2026-06-29 17:00:00', 6),
(19, 19, 4, '2026-05-14', 10, 7.00, 45.20, 38.50, 12.30, 'Tidak ada keluhan', '2026-06-20 17:00:00', 4, '2026-06-20 17:00:00', 4),
(20, 20, 4, '2026-04-15', 2, 17.50, 63.60, 38.30, 10.00, 'Susah tidur malam', '2026-06-05 17:00:00', 4, '2026-06-05 17:00:00', 4),
(21, 21, 6, '2026-06-11', 17, 10.50, 57.10, 40.60, 10.00, 'Tidak ada keluhan', '2026-06-05 17:00:00', 6, '2026-06-05 17:00:00', 6),
(22, 22, 4, '2026-05-14', 25, 11.80, 68.60, 37.50, 14.40, 'Batuk pilek ringan', '2026-07-07 17:00:00', 4, '2026-07-07 17:00:00', 4),
(23, 23, 4, '2026-06-11', 42, 16.40, 92.00, 41.90, 15.40, 'Tidak ada keluhan', '2026-07-01 17:00:00', 4, '2026-07-01 17:00:00', 4),
(24, 24, 4, '2026-07-15', 18, 13.90, 83.60, 33.70, 15.80, 'Tidak ada keluhan', '2026-07-10 17:00:00', 4, '2026-07-10 17:00:00', 4),
(25, 25, 6, '2026-06-11', 46, 13.50, 75.30, 46.60, 15.30, 'Demam ringan', '2026-06-01 17:00:00', 6, '2026-06-01 17:00:00', 6),
(26, 26, 4, '2026-06-11', 5, 3.50, 53.00, 38.40, 10.70, 'Diare ringan', '2026-07-05 17:00:00', 4, '2026-07-05 17:00:00', 4),
(27, 27, 3, '2026-03-12', 40, 3.30, 76.90, 36.70, 11.80, 'Diare ringan', '2026-06-04 17:00:00', 3, '2026-06-04 17:00:00', 3),
(28, 28, 3, '2026-06-11', 42, 10.90, 89.70, 40.10, 15.70, 'Tidak ada keluhan', '2026-06-15 17:00:00', 3, '2026-06-15 17:00:00', 3),
(29, 29, 4, '2026-04-15', 14, 14.10, 103.50, 40.40, 12.70, 'Diare ringan', '2026-07-13 17:00:00', 4, '2026-07-13 17:00:00', 4),
(30, 30, 5, '2026-06-11', 49, 3.70, 83.00, 36.00, 14.20, 'Rewel', '2026-06-16 17:00:00', 5, '2026-06-16 17:00:00', 5),
(31, 31, 5, '2026-05-14', 39, 11.50, 45.70, 33.90, 11.90, 'Tidak ada keluhan', '2026-06-06 17:00:00', 5, '2026-06-06 17:00:00', 5),
(32, 32, 4, '2026-06-11', 43, 10.30, 87.50, 37.30, 13.30, 'Batuk pilek ringan', '2026-07-05 17:00:00', 4, '2026-07-05 17:00:00', 4),
(33, 33, 4, '2026-06-11', 19, 17.70, 101.20, 33.30, 13.20, 'Tidak ada keluhan', '2026-06-28 17:00:00', 4, '2026-06-28 17:00:00', 4),
(34, 34, 5, '2026-06-11', 24, 6.10, 101.70, 36.20, 14.10, 'Nafsu makan menurun', '2026-07-03 17:00:00', 5, '2026-07-03 17:00:00', 5),
(35, 35, 5, '2026-06-11', 23, 5.00, 94.20, 40.60, 16.20, 'Tidak ada keluhan', '2026-06-23 17:00:00', 5, '2026-06-23 17:00:00', 5),
(36, 36, 4, '2026-07-15', 31, 16.50, 74.20, 33.40, 10.00, 'Diare ringan', '2026-07-13 17:00:00', 4, '2026-07-13 17:00:00', 4),
(37, 37, 6, '2026-07-15', 25, 7.50, 53.40, 38.20, 12.20, 'Rewel', '2026-05-31 17:00:00', 6, '2026-05-31 17:00:00', 6),
(38, 38, 5, '2026-05-14', 48, 8.10, 68.90, 47.10, 11.40, 'Tidak ada keluhan', '2026-06-18 17:00:00', 5, '2026-06-18 17:00:00', 5),
(39, 39, 5, '2026-03-12', 23, 4.00, 68.40, 46.00, 10.50, 'Susah tidur malam', '2026-06-17 17:00:00', 5, '2026-06-17 17:00:00', 5),
(40, 40, 3, '2026-02-12', 17, 4.50, 95.10, 37.30, 16.50, 'Tidak ada keluhan', '2026-06-17 17:00:00', 3, '2026-06-17 17:00:00', 3),
(41, 41, 6, '2026-03-12', 32, 7.70, 91.40, 44.80, 13.00, 'Tidak ada keluhan', '2026-07-10 17:00:00', 6, '2026-07-10 17:00:00', 6),
(42, 42, 6, '2026-02-12', 58, 16.10, 78.20, 36.10, 10.60, 'Tidak ada keluhan', '2026-06-26 17:00:00', 6, '2026-06-26 17:00:00', 6),
(43, 43, 6, '2026-04-15', 39, 14.30, 83.70, 37.30, 10.30, 'Tidak ada keluhan', '2026-06-08 17:00:00', 6, '2026-06-08 17:00:00', 6),
(44, 44, 4, '2026-04-15', 30, 9.20, 61.90, 36.80, 15.20, 'Tidak ada keluhan', '2026-06-16 17:00:00', 4, '2026-06-16 17:00:00', 4),
(45, 45, 6, '2026-06-11', 41, 6.60, 74.00, 43.00, 10.80, 'Tidak ada keluhan', '2026-06-10 17:00:00', 6, '2026-06-10 17:00:00', 6),
(46, 2, 4, '2026-02-12', 43, 8.26, 53.77, 44.95, 16.78, 'Susah tidur malam', '2026-02-12 01:00:00', 4, '2026-02-12 01:00:00', 4),
(47, 2, 4, '2026-04-15', 46, 8.96, 54.51, 45.22, 17.03, 'Batuk pilek ringan', '2026-04-15 01:00:00', 4, '2026-04-15 01:00:00', 4),
(48, 7, 4, '2026-05-14', 59, 4.81, 61.90, 33.95, 15.75, 'Tidak ada keluhan', '2026-05-14 01:00:00', 4, '2026-05-14 01:00:00', 4),
(49, 7, 4, '2026-06-11', 59, 5.17, 62.59, 34.22, 16.12, 'Demam ringan', '2026-06-11 01:00:00', 4, '2026-06-11 01:00:00', 4),
(50, 12, 4, '2026-02-12', 10, 17.81, 62.54, 35.91, 16.61, 'Tidak ada keluhan', '2026-02-12 01:00:00', 4, '2026-02-12 01:00:00', 4),
(51, 12, 4, '2026-05-14', 12, 18.02, 64.53, 36.18, 16.98, 'Diare ringan', '2026-05-14 01:00:00', 4, '2026-05-14 01:00:00', 4),
(52, 18, 6, '2026-04-15', 57, 11.18, 104.60, 42.18, 15.03, 'Rewel', '2026-04-15 01:00:00', 6, '2026-04-15 01:00:00', 6),
(53, 18, 6, '2026-07-15', 59, 11.68, 106.57, 42.49, 15.20, 'Nafsu makan menurun', '2026-07-15 01:00:00', 6, '2026-07-15 01:00:00', 6),
(54, 24, 4, '2026-04-15', 21, 14.23, 84.44, 33.88, 16.16, 'Rewel', '2026-04-15 01:00:00', 4, '2026-04-15 01:00:00', 4),
(55, 24, 4, '2026-05-14', 24, 14.96, 85.59, 34.00, 16.46, 'Nafsu makan menurun', '2026-05-14 01:00:00', 4, '2026-05-14 01:00:00', 4),
(56, 30, 5, '2026-04-15', 50, 4.06, 84.94, 36.49, 14.46, 'Susah tidur malam', '2026-04-15 01:00:00', 5, '2026-04-15 01:00:00', 5),
(57, 30, 5, '2026-05-14', 52, 4.43, 86.42, 36.69, 14.79, 'Tidak ada keluhan', '2026-05-14 01:00:00', 5, '2026-05-14 01:00:00', 5),
(58, 36, 4, '2026-03-12', 32, 17.05, 75.49, 33.80, 10.30, 'Rewel', '2026-03-12 01:00:00', 4, '2026-03-12 01:00:00', 4),
(59, 36, 4, '2026-04-15', 35, 17.34, 77.23, 34.19, 10.55, 'Nafsu makan menurun', '2026-04-15 01:00:00', 4, '2026-04-15 01:00:00', 4),
(60, 42, 6, '2026-03-12', 59, 16.33, 79.66, 36.58, 10.81, 'Nafsu makan menurun', '2026-03-12 01:00:00', 6, '2026-03-12 01:00:00', 6),
(61, 42, 6, '2026-04-15', 59, 17.01, 81.28, 36.88, 11.07, 'Rewel', '2026-04-15 01:00:00', 6, '2026-04-15 01:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_awal_ibu_hamil`
--

CREATE TABLE `pemeriksaan_awal_ibu_hamil` (
  `id` bigint UNSIGNED NOT NULL,
  `ibu_hamil_id` bigint UNSIGNED NOT NULL,
  `kader_id` bigint UNSIGNED NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `usia_kehamilan` int DEFAULT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tekanan_darah` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan_awal_ibu_hamil`
--

INSERT INTO `pemeriksaan_awal_ibu_hamil` (`id`, `ibu_hamil_id`, `kader_id`, `tanggal_periksa`, `usia_kehamilan`, `berat_badan`, `tekanan_darah`, `keluhan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 5, '2026-04-15', 13, 60.80, '100/65', 'Tidak ada keluhan', '2026-06-06 17:00:00', 5, '2026-06-06 17:00:00', 5),
(2, 2, 5, '2026-05-14', 7, 81.40, '110/60', 'Pusing ringan', '2026-06-27 17:00:00', 5, '2026-06-27 17:00:00', 5),
(3, 3, 6, '2026-06-11', 8, 54.60, '130/80', 'Tidak ada keluhan', '2026-07-06 17:00:00', 6, '2026-07-06 17:00:00', 6),
(4, 4, 3, '2026-07-15', 18, 70.20, '100/80', 'Tidak ada keluhan', '2026-06-14 17:00:00', 3, '2026-06-14 17:00:00', 3),
(5, 5, 3, '2026-07-15', 39, 79.30, '115/80', 'Mual di pagi hari', '2026-07-04 17:00:00', 3, '2026-07-04 17:00:00', 3),
(6, 6, 3, '2026-06-11', 40, 57.30, '110/65', 'Tidak ada keluhan', '2026-07-06 17:00:00', 3, '2026-07-06 17:00:00', 3),
(7, 7, 4, '2026-06-11', 27, 48.90, '105/60', 'Tidak ada keluhan', '2026-06-13 17:00:00', 4, '2026-06-13 17:00:00', 4),
(8, 8, 6, '2026-05-14', 38, 62.10, '120/85', 'Tidak ada keluhan', '2026-06-29 17:00:00', 6, '2026-06-29 17:00:00', 6),
(9, 9, 5, '2026-04-15', 23, 54.90, '110/70', 'Pusing ringan', '2026-07-06 17:00:00', 5, '2026-07-06 17:00:00', 5),
(10, 10, 5, '2026-07-15', 37, 64.80, '120/85', 'Kaki bengkak ringan', '2026-07-08 17:00:00', 5, '2026-07-08 17:00:00', 5),
(11, 11, 3, '2026-03-12', 11, 65.50, '110/80', 'Mual di pagi hari', '2026-07-01 17:00:00', 3, '2026-07-01 17:00:00', 3),
(12, 12, 6, '2026-03-12', 6, 83.50, '105/90', 'Tidak ada keluhan', '2026-06-20 17:00:00', 6, '2026-06-20 17:00:00', 6),
(13, 13, 5, '2026-05-14', 26, 68.80, '125/65', 'Pusing ringan', '2026-06-17 17:00:00', 5, '2026-06-17 17:00:00', 5),
(14, 14, 6, '2026-06-11', 8, 47.40, '115/85', 'Kaki bengkak ringan', '2026-07-15 17:00:00', 6, '2026-07-15 17:00:00', 6),
(15, 15, 6, '2026-02-12', 26, 45.90, '125/80', 'Mual di pagi hari', '2026-07-09 17:00:00', 6, '2026-07-09 17:00:00', 6),
(16, 16, 3, '2026-06-11', 35, 47.40, '115/70', 'Susah tidur', '2026-06-15 17:00:00', 3, '2026-06-15 17:00:00', 3),
(17, 17, 6, '2026-03-12', 29, 81.70, '125/65', 'Mual di pagi hari', '2026-06-28 17:00:00', 6, '2026-06-28 17:00:00', 6),
(18, 18, 6, '2026-06-11', 39, 56.10, '110/80', 'Tidak ada keluhan', '2026-06-17 17:00:00', 6, '2026-06-17 17:00:00', 6),
(19, 19, 6, '2026-05-14', 26, 72.30, '120/70', 'Mual di pagi hari', '2026-06-05 17:00:00', 6, '2026-06-05 17:00:00', 6),
(20, 20, 4, '2026-05-14', 13, 54.30, '110/60', 'Sesak nafas ringan', '2026-07-07 17:00:00', 4, '2026-07-07 17:00:00', 4),
(21, 21, 4, '2026-07-15', 20, 56.30, '110/80', 'Tidak ada keluhan', '2026-06-23 17:00:00', 4, '2026-06-23 17:00:00', 4),
(22, 22, 5, '2026-05-14', 12, 72.60, '130/60', 'Sesak nafas ringan', '2026-07-13 17:00:00', 5, '2026-07-13 17:00:00', 5),
(23, 23, 6, '2026-05-14', 29, 61.00, '105/85', 'Nafsu makan menurun', '2026-06-25 17:00:00', 6, '2026-06-25 17:00:00', 6),
(24, 24, 3, '2026-06-11', 16, 47.70, '110/85', 'Mual di pagi hari', '2026-06-07 17:00:00', 3, '2026-06-07 17:00:00', 3),
(25, 25, 5, '2026-02-12', 7, 49.10, '110/90', 'Pusing ringan', '2026-06-23 17:00:00', 5, '2026-06-23 17:00:00', 5),
(26, 26, 3, '2026-07-15', 8, 80.00, '120/70', 'Nafsu makan menurun', '2026-06-16 17:00:00', 3, '2026-06-16 17:00:00', 3),
(27, 27, 5, '2026-06-11', 27, 64.00, '105/85', 'Sesak nafas ringan', '2026-06-30 17:00:00', 5, '2026-06-30 17:00:00', 5),
(28, 28, 6, '2026-06-11', 23, 48.40, '105/80', 'Susah tidur', '2026-06-16 17:00:00', 6, '2026-06-16 17:00:00', 6),
(29, 29, 6, '2026-04-15', 14, 65.70, '110/90', 'Sering buang air kecil', '2026-06-09 17:00:00', 6, '2026-06-09 17:00:00', 6),
(30, 30, 3, '2026-04-15', 37, 56.90, '105/75', 'Tidak ada keluhan', '2026-06-23 17:00:00', 3, '2026-06-23 17:00:00', 3),
(31, 31, 4, '2026-04-15', 26, 75.90, '130/90', 'Tidak ada keluhan', '2026-06-21 17:00:00', 4, '2026-06-21 17:00:00', 4),
(32, 32, 4, '2026-03-12', 16, 77.20, '120/70', 'Nyeri punggung', '2026-07-03 17:00:00', 4, '2026-07-03 17:00:00', 4),
(33, 33, 6, '2026-06-11', 26, 74.20, '100/75', 'Sesak nafas ringan', '2026-06-16 17:00:00', 6, '2026-06-16 17:00:00', 6),
(34, 34, 4, '2026-05-14', 26, 62.90, '120/80', 'Pusing ringan', '2026-06-14 17:00:00', 4, '2026-06-14 17:00:00', 4),
(35, 35, 3, '2026-07-15', 18, 63.80, '120/70', 'Sesak nafas ringan', '2026-07-09 17:00:00', 3, '2026-07-09 17:00:00', 3),
(36, 36, 3, '2026-02-12', 34, 81.40, '120/65', 'Nafsu makan menurun', '2026-06-07 17:00:00', 3, '2026-06-07 17:00:00', 3),
(37, 37, 6, '2026-06-11', 16, 64.10, '110/80', 'Nafsu makan menurun', '2026-06-21 17:00:00', 6, '2026-06-21 17:00:00', 6),
(38, 38, 3, '2026-06-11', 29, 63.50, '105/70', 'Mual di pagi hari', '2026-06-08 17:00:00', 3, '2026-06-08 17:00:00', 3),
(39, 39, 3, '2026-04-15', 13, 68.60, '125/70', 'Tidak ada keluhan', '2026-07-08 17:00:00', 3, '2026-07-08 17:00:00', 3),
(40, 40, 6, '2026-05-14', 26, 51.20, '130/70', 'Tidak ada keluhan', '2026-05-31 17:00:00', 6, '2026-05-31 17:00:00', 6),
(41, 41, 3, '2026-06-11', 37, 75.00, '110/80', 'Nyeri punggung', '2026-06-13 17:00:00', 3, '2026-06-13 17:00:00', 3),
(42, 42, 3, '2026-07-15', 20, 53.50, '130/70', 'Tidak ada keluhan', '2026-06-20 17:00:00', 3, '2026-06-20 17:00:00', 3),
(43, 43, 5, '2026-04-15', 38, 61.80, '110/60', 'Susah tidur', '2026-06-22 17:00:00', 5, '2026-06-22 17:00:00', 5),
(44, 44, 6, '2026-05-14', 37, 61.80, '130/70', 'Tidak ada keluhan', '2026-06-09 17:00:00', 6, '2026-06-09 17:00:00', 6),
(45, 45, 3, '2026-06-11', 32, 76.10, '100/70', 'Mual di pagi hari', '2026-06-09 17:00:00', 3, '2026-06-09 17:00:00', 3),
(46, 46, 6, '2026-06-11', 11, 67.30, '120/90', 'Tidak ada keluhan', '2026-07-05 17:00:00', 6, '2026-07-05 17:00:00', 6),
(47, 47, 6, '2026-04-15', 10, 80.30, '100/70', 'Nyeri punggung', '2026-06-17 17:00:00', 6, '2026-06-17 17:00:00', 6),
(48, 48, 3, '2026-05-14', 10, 65.30, '130/60', 'Pusing ringan', '2026-06-28 17:00:00', 3, '2026-06-28 17:00:00', 3),
(49, 49, 5, '2026-03-12', 36, 69.20, '110/75', 'Sesak nafas ringan', '2026-07-02 17:00:00', 5, '2026-07-02 17:00:00', 5),
(50, 50, 6, '2026-05-14', 36, 82.70, '130/75', 'Tidak ada keluhan', '2026-06-12 17:00:00', 6, '2026-06-12 17:00:00', 6),
(51, 2, 5, '2026-06-11', 13, 83.20, '110/80', 'Pusing ringan', '2026-06-11 01:00:00', 5, '2026-06-11 01:00:00', 5),
(52, 2, 5, '2026-07-15', 16, 84.40, '110/80', 'Mual di pagi hari', '2026-07-15 01:00:00', 5, '2026-07-15 01:00:00', 5),
(53, 7, 4, '2026-04-15', 33, 50.15, '105/60', 'Sering buang air kecil', '2026-04-15 01:00:00', 4, '2026-04-15 01:00:00', 4),
(54, 7, 4, '2026-07-15', 37, 52.18, '105/60', 'Kaki bengkak ringan', '2026-07-15 01:00:00', 4, '2026-07-15 01:00:00', 4),
(55, 13, 5, '2026-04-15', 30, 70.51, '125/65', 'Kaki bengkak ringan', '2026-04-15 01:00:00', 5, '2026-04-15 01:00:00', 5),
(56, 13, 5, '2026-07-15', 34, 71.91, '125/65', 'Sering buang air kecil', '2026-07-15 01:00:00', 5, '2026-07-15 01:00:00', 5),
(57, 19, 6, '2026-04-15', 31, 75.21, '120/70', 'Sesak nafas ringan', '2026-04-15 01:00:00', 6, '2026-04-15 01:00:00', 6),
(58, 19, 6, '2026-06-11', 34, 77.17, '120/70', 'Sesak nafas ringan', '2026-06-11 01:00:00', 6, '2026-06-11 01:00:00', 6),
(59, 25, 5, '2026-05-14', 10, 51.70, '110/90', 'Nafsu makan menurun', '2026-05-14 01:00:00', 5, '2026-05-14 01:00:00', 5),
(60, 25, 5, '2026-06-11', 16, 54.31, '110/90', 'Mual di pagi hari', '2026-06-11 01:00:00', 5, '2026-06-11 01:00:00', 5),
(61, 31, 4, '2026-02-12', 32, 78.87, '130/90', 'Kaki bengkak ringan', '2026-02-12 01:00:00', 4, '2026-02-12 01:00:00', 4),
(62, 31, 4, '2026-03-12', 38, 81.54, '130/90', 'Tidak ada keluhan', '2026-03-12 01:00:00', 4, '2026-03-12 01:00:00', 4),
(63, 38, 3, '2026-02-12', 35, 66.05, '105/70', 'Tidak ada keluhan', '2026-02-12 01:00:00', 3, '2026-02-12 01:00:00', 3),
(64, 38, 3, '2026-07-15', 40, 68.62, '105/70', 'Pusing ringan', '2026-07-15 01:00:00', 3, '2026-07-15 01:00:00', 3),
(65, 44, 6, '2026-02-12', 40, 64.03, '130/70', 'Nyeri punggung', '2026-02-12 01:00:00', 6, '2026-02-12 01:00:00', 6),
(66, 44, 6, '2026-06-11', 40, 66.88, '130/70', 'Kaki bengkak ringan', '2026-06-11 01:00:00', 6, '2026-06-11 01:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_lanjutan_balita`
--

CREATE TABLE `pemeriksaan_lanjutan_balita` (
  `id` bigint UNSIGNED NOT NULL,
  `balita_id` bigint UNSIGNED NOT NULL,
  `pemeriksaan_awal_id` bigint UNSIGNED NOT NULL,
  `bidan_id` bigint UNSIGNED NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `status_gizi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imunisasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vitamin_a` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindak_lanjut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_bidan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan_lanjutan_balita`
--

INSERT INTO `pemeriksaan_lanjutan_balita` (`id`, `balita_id`, `pemeriksaan_awal_id`, `bidan_id`, `tanggal_periksa`, `status_gizi`, `imunisasi`, `vitamin_a`, `tindak_lanjut`, `catatan_bidan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 7, '2026-04-24', 'Gizi Baik', 'Lengkap sesuai usia', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Anjurkan hindari main gadget sebelum tidur.', '2026-06-28 02:30:00', 7, '2026-04-24 02:30:00', 7),
(2, 2, 2, 9, '2026-05-21', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-08-10 02:30:00', 9, '2026-05-21 02:30:00', 9),
(3, 3, 3, 7, '2026-06-01', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Belum diberikan', 'Tidak Lanjut', 'Batuk pilek ringan, anjurkan istirahat cukup.', '2026-07-12 02:30:00', 7, '2026-06-01 02:30:00', 7),
(4, 4, 4, 7, '2026-07-26', 'Gizi Baik', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Kondisi balita baik dan aktif.', '2026-07-19 02:30:00', 7, '2026-07-26 02:30:00', 7),
(5, 5, 5, 9, '2026-08-02', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Tidak Lanjut', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-16 02:30:00', 9, '2026-08-02 02:30:00', 9),
(6, 6, 6, 9, '2026-06-24', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Tidak Lanjut', 'Batuk pilek ringan, anjurkan istirahat cukup.', '2026-07-04 02:30:00', 9, '2026-06-24 02:30:00', 9),
(7, 7, 7, 7, '2026-07-24', 'Gizi Kurang', 'Imunisasi dasar lengkap', 'Belum diberikan', 'Rujuk ke Puskesmas', 'Kondisi balita baik dan aktif.', '2026-06-28 02:30:00', 7, '2026-07-24 02:30:00', 7),
(8, 8, 8, 7, '2026-06-27', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Rujuk ke Puskesmas', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-08-04 02:30:00', 7, '2026-06-27 02:30:00', 7),
(9, 9, 9, 9, '2026-05-25', 'Gizi Kurang', 'Imunisasi dasar lengkap', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Sarankan minum air hangat dan jaga kehangatan tubuh.', '2026-07-16 02:30:00', 9, '2026-05-25 02:30:00', 9),
(10, 10, 10, 7, '2026-06-21', 'Gizi Kurang', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-06-30 02:30:00', 7, '2026-06-21 02:30:00', 7),
(11, 11, 11, 9, '2026-05-29', 'Gizi Kurang', 'BCG, Polio 1, DPT-HB-Hib 1', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Perlu pemantauan berat badan lebih ketat.', '2026-06-19 02:30:00', 9, '2026-05-29 02:30:00', 9),
(12, 12, 12, 7, '2026-04-26', 'Gizi Baik', 'Belum lengkap', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-08 02:30:00', 7, '2026-04-26 02:30:00', 7),
(13, 13, 13, 9, '2026-04-23', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Kondisi balita baik dan aktif.', '2026-06-30 02:30:00', 9, '2026-04-23 02:30:00', 9),
(14, 14, 14, 9, '2026-07-22', 'Gizi Buruk', 'DPT-HB-Hib 2, Polio 2', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Pantau tanda dehidrasi.', '2026-07-03 02:30:00', 9, '2026-07-22 02:30:00', 9),
(15, 15, 15, 7, '2026-05-20', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Tidak Lanjut', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-09 02:30:00', 7, '2026-05-20 02:30:00', 7),
(16, 16, 16, 7, '2026-05-21', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Rewel kemungkinan tumbuh gigi, pantau suhu tubuh.', '2026-07-03 02:30:00', 7, '2026-05-21 02:30:00', 7),
(17, 17, 17, 9, '2026-05-21', 'Gizi Kurang', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Sarankan minum air hangat dan jaga kehangatan tubuh.', '2026-08-01 02:30:00', 9, '2026-05-21 02:30:00', 9),
(18, 18, 18, 7, '2026-03-20', 'Gizi Lebih', 'BCG, Polio 1, DPT-HB-Hib 1', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Kondisi balita baik dan aktif.', '2026-07-16 02:30:00', 7, '2026-03-20 02:30:00', 7),
(19, 19, 19, 9, '2026-05-29', 'Gizi Baik', 'Campak, Polio 4', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-07-15 02:30:00', 9, '2026-05-29 02:30:00', 9),
(20, 20, 20, 9, '2026-04-23', 'Gizi Kurang', 'Belum lengkap', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Kondisi umum baik, keluhan tidur ringan.', '2026-06-28 02:30:00', 9, '2026-04-23 02:30:00', 9),
(21, 21, 21, 9, '2026-06-16', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Tidak Lanjut', 'Kondisi balita baik dan aktif.', '2026-06-27 02:30:00', 9, '2026-06-16 02:30:00', 9),
(22, 22, 22, 7, '2026-05-26', 'Gizi Lebih', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Tidak Lanjut', 'Sarankan minum air hangat dan jaga kehangatan tubuh.', '2026-07-22 02:30:00', 7, '2026-05-26 02:30:00', 7),
(23, 23, 23, 7, '2026-06-29', 'Gizi Baik', 'Campak, Polio 4', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-30 02:30:00', 7, '2026-06-29 02:30:00', 7),
(24, 24, 24, 7, '2026-07-29', 'Gizi Buruk', 'Lengkap sesuai usia', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-07-30 02:30:00', 7, '2026-07-29 02:30:00', 7),
(25, 25, 25, 9, '2026-06-18', 'Gizi Buruk', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Tidak Lanjut', 'Pantau suhu tubuh secara berkala.', '2026-06-28 02:30:00', 9, '2026-06-18 02:30:00', 9),
(26, 26, 26, 7, '2026-06-20', 'Gizi Lebih', 'Campak, Polio 4', 'Sudah diberikan', 'Tidak Lanjut', 'Pantau tanda dehidrasi.', '2026-07-23 02:30:00', 7, '2026-06-20 02:30:00', 7),
(27, 27, 27, 9, '2026-03-21', 'Gizi Baik', 'Lengkap sesuai usia', 'Belum diberikan', 'Tidak Lanjut', 'Diare ringan, anjurkan cukup cairan dan oralit.', '2026-07-02 02:30:00', 9, '2026-03-21 02:30:00', 9),
(28, 28, 28, 9, '2026-06-16', 'Gizi Baik', 'Campak, Polio 4', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-03 02:30:00', 9, '2026-06-16 02:30:00', 9),
(29, 29, 29, 7, '2026-04-22', 'Gizi Buruk', 'Campak, Polio 4', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Sarankan jaga kebersihan makanan dan minuman.', '2026-08-13 02:30:00', 7, '2026-04-22 02:30:00', 7),
(30, 30, 30, 9, '2026-06-22', 'Gizi Kurang', 'Lengkap sesuai usia', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Anjurkan orang tua tetap tenang dan sabar.', '2026-07-11 02:30:00', 9, '2026-06-22 02:30:00', 9),
(31, 31, 31, 9, '2026-05-27', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Kondisi balita baik dan aktif.', '2026-07-03 02:30:00', 9, '2026-05-27 02:30:00', 9),
(32, 32, 32, 9, '2026-06-21', 'Gizi Baik', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Belum perlu obat, pantau 3 hari ke depan.', '2026-07-28 02:30:00', 9, '2026-06-21 02:30:00', 9),
(33, 33, 33, 7, '2026-06-25', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Tidak Lanjut', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-15 02:30:00', 7, '2026-06-25 02:30:00', 7),
(34, 34, 34, 9, '2026-06-25', 'Gizi Baik', 'Lengkap sesuai usia', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Perlu pemantauan berat badan lebih ketat.', '2026-08-02 02:30:00', 9, '2026-06-25 02:30:00', 9),
(35, 35, 35, 7, '2026-06-21', 'Gizi Lebih', 'Campak, Polio 4', 'Belum diberikan', 'Rujuk ke Puskesmas', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-17 02:30:00', 7, '2026-06-21 02:30:00', 7),
(36, 36, 36, 9, '2026-07-22', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Sarankan jaga kebersihan makanan dan minuman.', '2026-08-07 02:30:00', 9, '2026-07-22 02:30:00', 9),
(37, 37, 37, 7, '2026-07-31', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Rewel kemungkinan tumbuh gigi, pantau suhu tubuh.', '2026-06-21 02:30:00', 7, '2026-07-31 02:30:00', 7),
(38, 38, 38, 9, '2026-06-01', 'Gizi Kurang', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Tidak Lanjut', 'Kondisi balita baik dan aktif.', '2026-07-11 02:30:00', 9, '2026-06-01 02:30:00', 9),
(39, 39, 39, 9, '2026-03-25', 'Gizi Baik', 'Campak, Polio 4', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Kondisi umum baik, keluhan tidur ringan.', '2026-07-09 02:30:00', 9, '2026-03-25 02:30:00', 9),
(40, 40, 40, 9, '2026-02-26', 'Gizi Buruk', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Tidak Lanjut', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-03 02:30:00', 9, '2026-02-26 02:30:00', 9),
(41, 41, 41, 9, '2026-03-27', 'Gizi Kurang', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-07-28 02:30:00', 9, '2026-03-27 02:30:00', 9),
(42, 42, 42, 9, '2026-02-27', 'Gizi Buruk', 'Campak, Polio 4', 'Belum diberikan', 'Tidak Lanjut', 'Kondisi balita baik dan aktif.', '2026-07-16 02:30:00', 9, '2026-02-27 02:30:00', 9),
(43, 43, 43, 9, '2026-05-01', 'Gizi Baik', 'Imunisasi dasar lengkap', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Kondisi balita baik dan aktif.', '2026-07-08 02:30:00', 9, '2026-05-01 02:30:00', 9),
(44, 44, 44, 9, '2026-04-20', 'Gizi Buruk', 'Lengkap sesuai usia', 'Belum diberikan', 'Rujuk ke Puskesmas', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-03 02:30:00', 9, '2026-04-20 02:30:00', 9),
(45, 45, 45, 7, '2026-06-23', 'Gizi Baik', 'Belum lengkap', 'Belum diberikan', 'Tidak Lanjut', 'Balita sehat, lanjutkan pemantauan rutin.', '2026-07-11 02:30:00', 7, '2026-06-23 02:30:00', 7),
(46, 2, 46, 9, '2026-02-20', 'Gizi Buruk', 'Lengkap sesuai usia', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Anjurkan hindari main gadget sebelum tidur.', '2026-02-20 02:30:00', 9, '2026-02-20 02:30:00', 9),
(47, 2, 47, 9, '2026-04-23', 'Gizi Baik', 'Lengkap sesuai usia', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Batuk pilek ringan, anjurkan istirahat cukup.', '2026-04-23 02:30:00', 9, '2026-04-23 02:30:00', 9),
(48, 7, 48, 7, '2026-05-31', 'Gizi Baik', 'Lengkap sesuai usia', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-05-31 02:30:00', 7, '2026-05-31 02:30:00', 7),
(49, 7, 49, 9, '2026-06-22', 'Gizi Baik', 'DPT-HB-Hib 2, Polio 2', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Pantau suhu tubuh secara berkala.', '2026-06-22 02:30:00', 9, '2026-06-22 02:30:00', 9),
(50, 12, 50, 9, '2026-02-18', 'Gizi Kurang', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Tidak Lanjut', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-02-18 02:30:00', 9, '2026-02-18 02:30:00', 9),
(51, 12, 51, 7, '2026-05-19', 'Gizi Kurang', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Diare ringan, anjurkan cukup cairan dan oralit.', '2026-05-19 02:30:00', 7, '2026-05-19 02:30:00', 7),
(52, 18, 52, 7, '2026-04-24', 'Gizi Baik', 'Lengkap sesuai usia', 'Belum diberikan', 'Lanjut Pemeriksaan', 'Rewel kemungkinan tumbuh gigi, pantau suhu tubuh.', '2026-04-24 02:30:00', 7, '2026-04-24 02:30:00', 7),
(53, 18, 53, 7, '2026-07-30', 'Gizi Buruk', 'Belum lengkap', 'Belum diberikan', 'Tidak Lanjut', 'Anjurkan variasi menu MPASI.', '2026-07-30 02:30:00', 7, '2026-07-30 02:30:00', 7),
(54, 24, 54, 7, '2026-04-26', 'Gizi Lebih', 'Lengkap sesuai usia', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Rewel kemungkinan tumbuh gigi, pantau suhu tubuh.', '2026-04-26 02:30:00', 7, '2026-04-26 02:30:00', 7),
(55, 24, 55, 9, '2026-05-28', 'Gizi Baik', 'Campak, Polio 4', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Perlu pemantauan berat badan lebih ketat.', '2026-05-28 02:30:00', 9, '2026-05-28 02:30:00', 9),
(56, 30, 56, 7, '2026-04-24', 'Gizi Baik', 'BCG, Polio 1, DPT-HB-Hib 1', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Anjurkan hindari main gadget sebelum tidur.', '2026-04-24 02:30:00', 7, '2026-04-24 02:30:00', 7),
(57, 30, 57, 9, '2026-06-01', 'Gizi Baik', 'Belum lengkap', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Pertumbuhan sesuai usia, tidak ada keluhan.', '2026-06-01 02:30:00', 9, '2026-06-01 02:30:00', 9),
(58, 36, 58, 9, '2026-03-29', 'Gizi Baik', 'Belum lengkap', 'Sudah diberikan', 'Tidak Lanjut', 'Anjurkan orang tua tetap tenang dan sabar.', '2026-03-29 02:30:00', 9, '2026-03-29 02:30:00', 9),
(59, 36, 59, 7, '2026-04-28', 'Gizi Buruk', 'DPT-HB-Hib 2, Polio 2', 'Sudah diberikan', 'Rujuk ke Puskesmas', 'Anjurkan variasi menu MPASI.', '2026-04-28 02:30:00', 7, '2026-04-28 02:30:00', 7),
(60, 42, 60, 7, '2026-03-27', 'Gizi Baik', 'DPT-HB-Hib 2, Polio 2', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Perlu pemantauan berat badan lebih ketat.', '2026-03-27 02:30:00', 7, '2026-03-27 02:30:00', 7),
(61, 42, 61, 7, '2026-05-01', 'Gizi Buruk', 'Campak, Polio 4', 'Sudah diberikan', 'Lanjut Pemeriksaan', 'Anjurkan orang tua tetap tenang dan sabar.', '2026-05-01 02:30:00', 7, '2026-05-01 02:30:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_lanjutan_ibu_hamil`
--

CREATE TABLE `pemeriksaan_lanjutan_ibu_hamil` (
  `id` bigint UNSIGNED NOT NULL,
  `ibu_hamil_id` bigint UNSIGNED NOT NULL,
  `bidan_id` bigint UNSIGNED NOT NULL,
  `pemeriksaan_awal_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_periksa` date NOT NULL,
  `lila` decimal(5,2) NOT NULL,
  `tfu` decimal(5,2) NOT NULL,
  `djj` int DEFAULT NULL,
  `catatan_bidan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindak_lanjut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan_lanjutan_ibu_hamil`
--

INSERT INTO `pemeriksaan_lanjutan_ibu_hamil` (`id`, `ibu_hamil_id`, `bidan_id`, `pemeriksaan_awal_id`, `tanggal_periksa`, `lila`, `tfu`, `djj`, `catatan_bidan`, `tindak_lanjut`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(51, 1, 7, 1, '2026-04-29', 25.58, 14.96, 154, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Rujuk ke Puskesmas', '2026-06-21 02:00:00', 7, '2026-04-29 02:00:00', 7),
(52, 2, 7, 2, '2026-05-26', 21.17, 9.41, NULL, 'Pusing ringan, disarankan istirahat cukup.', 'Tidak Lanjut', '2026-07-12 02:00:00', 7, '2026-05-26 02:00:00', 7),
(53, 3, 9, 3, '2026-06-25', 25.86, 10.02, NULL, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Rujuk ke Puskesmas', '2026-07-24 02:00:00', 9, '2026-06-25 02:00:00', 9),
(54, 4, 9, 4, '2026-08-01', 31.64, 18.28, 144, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Lanjut Pemeriksaan', '2026-07-03 02:00:00', 9, '2026-08-01 02:00:00', 9),
(55, 5, 9, 5, '2026-07-27', 23.87, 38.29, 144, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Rujuk ke Puskesmas', '2026-07-28 02:00:00', 9, '2026-07-27 02:00:00', 9),
(56, 6, 9, 6, '2026-06-17', 24.09, 35.82, 138, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Tidak Lanjut', '2026-07-30 02:00:00', 9, '2026-06-17 02:00:00', 9),
(57, 7, 7, 7, '2026-06-29', 28.90, 26.48, 142, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Rujuk ke Puskesmas', '2026-07-04 02:00:00', 7, '2026-06-29 02:00:00', 7),
(58, 8, 7, 8, '2026-05-20', 28.04, 35.31, 144, 'Tidak ada keluhan berarti, lanjutkan pola makan sehat.', 'Tidak Lanjut', '2026-07-23 02:00:00', 7, '2026-05-20 02:00:00', 7),
(59, 9, 7, 9, '2026-04-24', 30.03, 22.40, 122, 'Kemungkinan kurang istirahat, pantau tekanan darah.', 'Lanjut Pemeriksaan', '2026-07-31 02:00:00', 7, '2026-04-24 02:00:00', 7),
(60, 10, 7, 10, '2026-07-27', 28.32, 36.52, 151, 'Anjurkan kurangi berdiri lama dan angkat kaki saat istirahat.', 'Tidak Lanjut', '2026-07-26 02:00:00', 7, '2026-07-27 02:00:00', 7),
(61, 11, 9, 11, '2026-03-28', 25.60, 14.37, 157, 'Mual ringan, tidak perlu obat khusus.', 'Tidak Lanjut', '2026-07-18 02:00:00', 9, '2026-03-28 02:00:00', 9),
(62, 12, 9, 12, '2026-03-27', 31.98, 9.49, NULL, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Tidak Lanjut', '2026-07-10 02:00:00', 9, '2026-03-27 02:00:00', 9),
(63, 13, 7, 13, '2026-05-20', 29.28, 25.88, 144, 'Anjurkan minum air putih lebih banyak.', 'Tidak Lanjut', '2026-07-12 02:00:00', 7, '2026-05-20 02:00:00', 7),
(64, 14, 9, 14, '2026-06-16', 23.60, 10.47, NULL, 'Pantau tekanan darah lebih ketat.', 'Tidak Lanjut', '2026-08-07 02:00:00', 9, '2026-06-16 02:00:00', 9),
(65, 15, 9, 15, '2026-02-28', 24.84, 29.14, 136, 'Sarankan hindari makanan berlemak.', 'Tidak Lanjut', '2026-07-25 02:00:00', 9, '2026-02-28 02:00:00', 9),
(66, 16, 7, 16, '2026-06-27', 30.65, 37.90, 129, 'Anjurkan hindari kafein di malam hari.', 'Tidak Lanjut', '2026-07-13 02:00:00', 7, '2026-06-27 02:00:00', 7),
(67, 17, 7, 17, '2026-03-21', 23.67, 32.82, 139, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Lanjut Pemeriksaan', '2026-07-22 02:00:00', 7, '2026-03-21 02:00:00', 7),
(68, 18, 7, 18, '2026-06-26', 30.44, 40.13, 128, 'Ibu sehat, tetap kontrol rutin.', 'Lanjut Pemeriksaan', '2026-07-03 02:00:00', 7, '2026-06-26 02:00:00', 7),
(69, 19, 7, 19, '2026-05-28', 28.66, 29.00, 132, 'Sarankan hindari makanan berlemak.', 'Lanjut Pemeriksaan', '2026-06-24 02:00:00', 7, '2026-05-28 02:00:00', 7),
(70, 20, 9, 20, '2026-05-29', 27.34, 13.42, 141, 'Sesak nafas ringan wajar di trimester ini, tetap dipantau.', 'Rujuk ke Puskesmas', '2026-07-29 02:00:00', 9, '2026-05-29 02:00:00', 9),
(71, 21, 7, 21, '2026-08-02', 24.10, 20.68, 124, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Tidak Lanjut', '2026-07-17 02:00:00', 7, '2026-08-02 02:00:00', 7),
(72, 22, 7, 22, '2026-05-26', 29.19, 13.41, 156, 'Sarankan kurangi aktivitas berat.', 'Lanjut Pemeriksaan', '2026-08-05 02:00:00', 7, '2026-05-26 02:00:00', 7),
(73, 23, 9, 23, '2026-05-23', 24.30, 30.89, 147, 'Sarankan konsumsi makanan bergizi tinggi kalori.', 'Lanjut Pemeriksaan', '2026-07-22 02:00:00', 9, '2026-05-23 02:00:00', 9),
(74, 24, 7, 24, '2026-06-27', 28.99, 16.75, 141, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Lanjut Pemeriksaan', '2026-07-02 02:00:00', 7, '2026-06-27 02:00:00', 7),
(75, 25, 7, 25, '2026-02-23', 27.09, 9.43, NULL, 'Pusing ringan, disarankan istirahat cukup.', 'Lanjut Pemeriksaan', '2026-07-16 02:00:00', 7, '2026-02-23 02:00:00', 7),
(76, 26, 7, 26, '2026-07-30', 28.09, 10.44, NULL, 'Nafsu makan menurun, anjurkan porsi kecil sering.', 'Lanjut Pemeriksaan', '2026-07-01 02:00:00', 7, '2026-07-30 02:00:00', 7),
(77, 27, 9, 27, '2026-06-21', 26.91, 25.60, 120, 'Anjurkan posisi tidur miring kiri.', 'Lanjut Pemeriksaan', '2026-07-22 02:00:00', 9, '2026-06-21 02:00:00', 9),
(78, 28, 9, 28, '2026-06-16', 31.64, 26.52, 151, 'Susah tidur, sarankan relaksasi sebelum tidur.', 'Lanjut Pemeriksaan', '2026-07-05 02:00:00', 9, '2026-06-16 02:00:00', 9),
(79, 29, 7, 29, '2026-04-27', 28.11, 16.43, 123, 'Tidak ada tanda infeksi saluran kemih.', 'Lanjut Pemeriksaan', '2026-06-24 02:00:00', 7, '2026-04-27 02:00:00', 7),
(80, 30, 7, 30, '2026-04-25', 24.18, 33.68, 124, 'Ibu sehat, tetap kontrol rutin.', 'Tidak Lanjut', '2026-07-08 02:00:00', 7, '2026-04-25 02:00:00', 7),
(81, 31, 9, 31, '2026-04-22', 28.34, 29.07, 159, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Lanjut Pemeriksaan', '2026-07-07 02:00:00', 9, '2026-04-22 02:00:00', 9),
(82, 32, 9, 32, '2026-03-26', 29.19, 17.06, 145, 'Nyeri punggung, sarankan posisi duduk yang baik.', 'Rujuk ke Puskesmas', '2026-08-01 02:00:00', 9, '2026-03-26 02:00:00', 9),
(83, 33, 9, 33, '2026-06-17', 29.89, 23.85, 159, 'Sarankan kurangi aktivitas berat.', 'Tidak Lanjut', '2026-07-08 02:00:00', 9, '2026-06-17 02:00:00', 9),
(84, 34, 7, 34, '2026-05-26', 25.75, 29.76, 135, 'Kemungkinan kurang istirahat, pantau tekanan darah.', 'Lanjut Pemeriksaan', '2026-07-07 02:00:00', 7, '2026-05-26 02:00:00', 7),
(85, 35, 9, 35, '2026-07-20', 26.07, 21.03, 155, 'Anjurkan posisi tidur miring kiri.', 'Tidak Lanjut', '2026-08-06 02:00:00', 9, '2026-07-20 02:00:00', 9),
(86, 36, 7, 36, '2026-02-20', 20.83, 35.95, 129, 'Sarankan konsumsi makanan bergizi tinggi kalori.', 'Lanjut Pemeriksaan', '2026-07-06 02:00:00', 7, '2026-02-20 02:00:00', 7),
(87, 37, 7, 37, '2026-06-28', 29.34, 18.07, 136, 'Nafsu makan menurun, anjurkan porsi kecil sering.', 'Lanjut Pemeriksaan', '2026-07-17 02:00:00', 7, '2026-06-28 02:00:00', 7),
(88, 38, 9, 38, '2026-06-20', 23.53, 30.30, 136, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Tidak Lanjut', '2026-07-06 02:00:00', 9, '2026-06-20 02:00:00', 9),
(89, 39, 9, 39, '2026-04-22', 20.72, 17.52, 154, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Tidak Lanjut', '2026-07-31 02:00:00', 9, '2026-04-22 02:00:00', 9),
(90, 40, 7, 40, '2026-05-30', 21.39, 28.83, 133, 'Ibu sehat, tetap kontrol rutin.', 'Lanjut Pemeriksaan', '2026-06-21 02:00:00', 7, '2026-05-30 02:00:00', 7),
(91, 41, 7, 41, '2026-06-19', 31.02, 41.79, 129, 'Nyeri punggung, sarankan posisi duduk yang baik.', 'Tidak Lanjut', '2026-07-03 02:00:00', 7, '2026-06-19 02:00:00', 7),
(92, 42, 7, 42, '2026-07-26', 25.02, 23.15, 146, 'Ibu sehat, tetap kontrol rutin.', 'Tidak Lanjut', '2026-07-19 02:00:00', 7, '2026-07-26 02:00:00', 7),
(93, 43, 7, 43, '2026-04-26', 29.46, 40.98, 150, 'Susah tidur, sarankan relaksasi sebelum tidur.', 'Lanjut Pemeriksaan', '2026-07-11 02:00:00', 7, '2026-04-26 02:00:00', 7),
(94, 44, 9, 44, '2026-06-01', 30.26, 34.89, 132, 'Tidak ada keluhan berarti, lanjutkan pola makan sehat.', 'Lanjut Pemeriksaan', '2026-06-29 02:00:00', 9, '2026-06-01 02:00:00', 9),
(95, 45, 7, 45, '2026-06-23', 28.95, 34.51, 154, 'Mual ringan, tidak perlu obat khusus.', 'Tidak Lanjut', '2026-07-06 02:00:00', 7, '2026-06-23 02:00:00', 7),
(96, 46, 7, 46, '2026-06-17', 25.02, 12.01, 158, 'Tidak ada keluhan berarti, lanjutkan pola makan sehat.', 'Lanjut Pemeriksaan', '2026-08-03 02:00:00', 7, '2026-06-17 02:00:00', 7),
(97, 47, 9, 47, '2026-04-22', 27.85, 13.39, 132, 'Anjurkan kompres hangat pada area nyeri.', 'Lanjut Pemeriksaan', '2026-07-08 02:00:00', 9, '2026-04-22 02:00:00', 9),
(98, 48, 9, 48, '2026-05-26', 30.36, 13.91, 132, 'Kemungkinan kurang istirahat, pantau tekanan darah.', 'Lanjut Pemeriksaan', '2026-07-13 02:00:00', 9, '2026-05-26 02:00:00', 9),
(99, 49, 9, 49, '2026-03-23', 30.71, 41.20, 152, 'Anjurkan posisi tidur miring kiri.', 'Rujuk ke Puskesmas', '2026-07-26 02:00:00', 9, '2026-03-23 02:00:00', 9),
(100, 50, 9, 50, '2026-05-27', 28.21, 35.50, 144, 'Ibu sehat, tetap kontrol rutin.', 'Tidak Lanjut', '2026-07-03 02:00:00', 9, '2026-05-27 02:00:00', 9),
(101, 2, 9, 51, '2026-06-26', 25.12, 13.61, 148, 'Pusing ringan, disarankan istirahat cukup.', 'Lanjut Pemeriksaan', '2026-06-26 02:00:00', 9, '2026-06-26 02:00:00', 9),
(102, 2, 7, 52, '2026-07-25', 24.10, 14.27, 144, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Rujuk ke Puskesmas', '2026-07-25 02:00:00', 7, '2026-07-25 02:00:00', 7),
(103, 7, 9, 53, '2026-04-27', 24.23, 28.72, 141, 'Tidak ada tanda infeksi saluran kemih.', 'Lanjut Pemeriksaan', '2026-04-27 02:00:00', 9, '2026-04-27 02:00:00', 9),
(104, 7, 9, 54, '2026-07-22', 31.27, 37.06, 139, 'Pantau tekanan darah lebih ketat.', 'Tidak Lanjut', '2026-07-22 02:00:00', 9, '2026-07-22 02:00:00', 9),
(105, 13, 9, 55, '2026-04-30', 30.40, 31.41, 132, 'Kaki bengkak ringan, waspada tanda preeklampsia.', 'Tidak Lanjut', '2026-04-30 02:00:00', 9, '2026-04-30 02:00:00', 9),
(106, 13, 9, 56, '2026-07-31', 20.58, 30.80, 136, 'Sering BAK adalah hal normal di kehamilan.', 'Rujuk ke Puskesmas', '2026-07-31 02:00:00', 9, '2026-07-31 02:00:00', 9),
(107, 19, 7, 57, '2026-04-23', 21.86, 28.44, 150, 'Sarankan kurangi aktivitas berat.', 'Tidak Lanjut', '2026-04-23 02:00:00', 7, '2026-04-23 02:00:00', 7),
(108, 19, 7, 58, '2026-06-29', 31.23, 34.22, 132, 'Anjurkan posisi tidur miring kiri.', 'Tidak Lanjut', '2026-06-29 02:00:00', 7, '2026-06-29 02:00:00', 7),
(109, 25, 9, 59, '2026-05-25', 24.22, 8.82, 128, 'Nafsu makan menurun, anjurkan porsi kecil sering.', 'Lanjut Pemeriksaan', '2026-05-25 02:00:00', 9, '2026-05-25 02:00:00', 9),
(110, 25, 9, 60, '2026-06-26', 24.83, 15.35, 121, 'Mual pagi hari masih wajar, anjurkan makan sedikit tapi sering.', 'Tidak Lanjut', '2026-06-26 02:00:00', 9, '2026-06-26 02:00:00', 9),
(111, 31, 7, 61, '2026-02-17', 25.99, 28.74, 157, 'Anjurkan kurangi berdiri lama dan angkat kaki saat istirahat.', 'Lanjut Pemeriksaan', '2026-02-17 02:00:00', 7, '2026-02-17 02:00:00', 7),
(112, 31, 9, 62, '2026-03-24', 30.43, 36.23, 152, 'Kondisi ibu baik, kehamilan berjalan normal.', 'Lanjut Pemeriksaan', '2026-03-24 02:00:00', 9, '2026-03-24 02:00:00', 9),
(113, 38, 7, 63, '2026-02-19', 22.30, 30.59, 123, 'Tidak ada keluhan berarti, lanjutkan pola makan sehat.', 'Rujuk ke Puskesmas', '2026-02-19 02:00:00', 7, '2026-02-19 02:00:00', 7),
(114, 38, 7, 64, '2026-07-23', 23.86, 34.78, 148, 'Anjurkan minum air putih lebih banyak.', 'Lanjut Pemeriksaan', '2026-07-23 02:00:00', 7, '2026-07-23 02:00:00', 7),
(115, 44, 7, 65, '2026-02-28', 27.82, 40.46, 152, 'Nyeri punggung, sarankan posisi duduk yang baik.', 'Rujuk ke Puskesmas', '2026-02-28 02:00:00', 7, '2026-02-28 02:00:00', 7),
(116, 44, 9, 66, '2026-06-18', 26.84, 36.53, 135, 'Anjurkan kurangi berdiri lama dan angkat kaki saat istirahat.', 'Lanjut Pemeriksaan', '2026-06-18 02:00:00', 9, '2026-06-18 02:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('A4gVObdZQ5Tpxrp80A7WRP6JvcqgNrJE9ECvCmKD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibldyYWNUOHZuMWNEMFJsZVFhRDhTUTNpTmtxb014NWZTSEJxRGUyUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777865288),
('KsdEF6Bony8TP0ydp6VAxm6uLwhClqLiVJ9e1Mg6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkkzNm9UcjY5QWtLZVFJbDBtelp2V3gxeWNXZXZhUmpsYXVybkNtbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777865205);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('ketua','kader','bidan','orang_tua') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kader',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Titin Muryani', 'ketua@gmail.com', '081284751932', '$2y$12$Op2dy.793JksLRm1Q2p37.0Mfxv4o3KYbaxC1AkfwAFt42BvFSroe', 'ketua', 'aktif', '2026-07-13 14:55:13', '2026-07-13 14:55:13'),
(2, 'Silvia Rahayu', 'silviarahayu@gmail.com', '081234567802', '$2y$12$IZfvZDmjhmlaea15AubwDOu9sC8O9y3tCCM4Yhm0lTD/AMOQY1Kwm', 'orang_tua', 'aktif', '2026-07-13 15:04:44', '2026-07-13 15:06:36'),
(3, 'Ira Ayu Lestari', 'kader01@gmail.com', '081234567805', '$2y$12$9G6wPa2L.j1MVFD7aEFL8O13iLiajuCaUnbsoGHvjEMkFBFfnO8P6', 'kader', 'aktif', '2026-07-13 15:12:10', '2026-07-13 15:12:10'),
(4, 'Delia Putri Anjani', 'kader02@gmail.com', '081234567804', '$2y$12$OQC.7EkngMBz70cmAEnJouBRCaqTkVIOQGuO8hPJAPOfI/XPg/zga', 'kader', 'aktif', '2026-07-13 15:12:42', '2026-07-13 15:12:42'),
(5, 'Juleha', 'kader03@gmail.com', '081234567810', '$2y$12$0pzcK4uMPFxKZXS24G.02e7bFAKvfrXf8sbWo0vLmYYWgXM//W3g6', 'kader', 'aktif', '2026-07-13 15:13:08', '2026-07-13 15:13:08'),
(6, 'Salamah', 'kader04@gmail.com', '081234567813', '$2y$12$NyDU.fcQoCTlpOyCXZAGQ.IWc4GyJizncH.IWUjrlyWoAFMdyOou6', 'kader', 'aktif', '2026-07-13 15:13:33', '2026-07-13 15:13:33'),
(7, 'Helen Revita, S.Tr, Keb', 'bidan01@gmail.com', '081234567806', '$2y$12$oe08YfTx9qmZGswCbhPIn.i.iYc9QRQC8V.aP8E8E54cXaXcCl7sG', 'bidan', 'aktif', '2026-07-13 15:15:36', '2026-07-13 15:15:36'),
(9, 'Dwi Mulya Sugih Rahayu, S.Tr, Keb', 'bidan02@gmail.com', '0812345678029', '$2y$12$LAoOWsSzkxI/jgevGt89teCezQWpprmDoWiHZnm71CdrCb05rurIC', 'bidan', 'aktif', '2026-07-13 15:17:44', '2026-07-14 00:59:55'),
(10, 'Siti Aminah', NULL, '081234500001', '$2y$12$RUHrBlnI/E0F5Kz5IWfEYOQCvnehY4Lz4fKuf8EZGRMuVH49BDmGu', 'orang_tua', 'aktif', '2026-07-13 15:25:36', '2026-07-14 01:51:27'),
(11, 'Dewi Lestari', NULL, '081234500002', '$2y$12$Kkhhkp7504UXc8A6eOGo/eF8fjUTiqq25mFruFEBtlxM2AiZ4erMi', 'orang_tua', 'aktif', '2026-07-13 15:25:36', '2026-07-14 01:51:28'),
(12, 'Rina Marlina', NULL, '081234500003', '$2y$12$fLgm43jJHAktwf9x/.7Txuy/ADlVDpehdVnMGi4FqfN/uGKEewsZm', 'orang_tua', 'aktif', '2026-07-13 15:25:36', '2026-07-14 01:51:28'),
(13, 'Yuni Kartika', NULL, '081234500004', '$2y$12$GqLeX936Dq6WyIaB9iMxq.hjAHLMEPX3x/RChJ9plotit36Vre/Q6', 'orang_tua', 'aktif', '2026-07-13 15:25:36', '2026-07-14 01:51:28'),
(14, 'Wulan Sari', NULL, '081234500005', '$2y$12$PMs036YhjJXYYYbHmFKbM.Ldxir7kEVf/aMSz2Yo.DtNCiUNANAFu', 'orang_tua', 'aktif', '2026-07-13 15:25:36', '2026-07-14 01:51:28'),
(15, 'Puji Anggraini', NULL, '081234500006', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-07 17:00:00', '2026-07-07 17:00:00'),
(16, 'Dewi Suryani', NULL, '081234500007', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-25 17:00:00', '2026-06-25 17:00:00'),
(17, 'Dwi Safitri', NULL, '081234500008', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-23 17:00:00', '2026-06-23 17:00:00'),
(18, 'Wahyu Pratiwi', NULL, '081234500009', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-14 17:00:00', '2026-06-14 17:00:00'),
(19, 'Yulia Anggraini', NULL, '081234500010', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-08 17:00:00', '2026-06-08 17:00:00'),
(20, 'Tika Suryani', NULL, '081234500011', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-02 17:00:00', '2026-07-02 17:00:00'),
(21, 'Intan Kurniawati', NULL, '081234500012', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-01 17:00:00', '2026-07-01 17:00:00'),
(22, 'Ani Yulianti', NULL, '081234500013', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-05 17:00:00', '2026-06-05 17:00:00'),
(23, 'Susi Kusuma', NULL, '081234500014', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-03 17:00:00', '2026-06-03 17:00:00'),
(24, 'Dewi Ramadhani', NULL, '081234500015', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-07 17:00:00', '2026-06-07 17:00:00'),
(25, 'Lestari Safitri', NULL, '081234500016', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-09 17:00:00', '2026-06-09 17:00:00'),
(26, 'Devi Fadillah', NULL, '081234500017', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-10 17:00:00', '2026-07-10 17:00:00'),
(27, 'Dewi Kurniawati', NULL, '081234500018', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-10 17:00:00', '2026-06-10 17:00:00'),
(28, 'Indah Mardiana', NULL, '081234500019', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-13 17:00:00', '2026-07-13 17:00:00'),
(29, 'Rani Mardiana', NULL, '081234500020', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-27 17:00:00', '2026-06-27 17:00:00'),
(30, 'Hesti Utami', NULL, '081234500021', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-08 17:00:00', '2026-07-08 17:00:00'),
(31, 'Wahyu Cahyani', NULL, '081234500022', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-04 17:00:00', '2026-06-04 17:00:00'),
(32, 'Kartika Maharani', NULL, '081234500023', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-24 17:00:00', '2026-06-24 17:00:00'),
(33, 'Citra Febriyanti', NULL, '081234500024', '$2y$12$8kfvaSLT9r45ao0HWSlbzeTSvAF6QZa3rm5dzpz0A5X5ydlf00AGy', 'orang_tua', 'aktif', '2026-06-24 17:00:00', '2026-07-17 04:17:20'),
(34, 'Siti Widiastuti', NULL, '081234500025', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-08 17:00:00', '2026-07-08 17:00:00'),
(35, 'Citra Handayani', NULL, '081234500026', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-29 17:00:00', '2026-06-29 17:00:00'),
(36, 'Umi Utami', NULL, '081234500027', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-03 17:00:00', '2026-07-03 17:00:00'),
(37, 'Yanti Maharani', NULL, '081234500028', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-16 17:00:00', '2026-06-16 17:00:00'),
(38, 'Ayu Puspita', NULL, '081234500029', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-05 17:00:00', '2026-07-05 17:00:00'),
(39, 'Zahra Susanti', NULL, '081234500030', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-05-31 17:00:00', '2026-05-31 17:00:00'),
(40, 'Sri Ramadhani', NULL, '081234500031', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-13 17:00:00', '2026-07-13 17:00:00'),
(41, 'Maya Anggraini', NULL, '081234500032', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-16 17:00:00', '2026-07-16 17:00:00'),
(42, 'Erna Febriyanti', NULL, '081234500033', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-07 17:00:00', '2026-06-07 17:00:00'),
(43, 'Erna Fadillah', NULL, '081234500034', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-13 17:00:00', '2026-07-13 17:00:00'),
(44, 'Eka Oktaviani', NULL, '081234500035', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-04 17:00:00', '2026-07-04 17:00:00'),
(45, 'Rina Suryani', NULL, '081234500036', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-17 17:00:00', '2026-06-17 17:00:00'),
(46, 'Ratih Kurniawati', NULL, '081234500037', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-11 17:00:00', '2026-07-11 17:00:00'),
(47, 'Nur Rosmawati', NULL, '081234500038', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-21 17:00:00', '2026-06-21 17:00:00'),
(48, 'Maya Ramadhani', NULL, '081234500039', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-07 17:00:00', '2026-06-07 17:00:00'),
(49, 'Ika Setiawati', NULL, '081234500040', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-18 17:00:00', '2026-06-18 17:00:00'),
(50, 'Elsa Zulaikha', NULL, '081234500041', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-27 17:00:00', '2026-06-27 17:00:00'),
(51, 'Oktavia Aisyah', NULL, '081234500042', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-10 17:00:00', '2026-06-10 17:00:00'),
(52, 'Gina Nuraini', NULL, '081234500043', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-29 17:00:00', '2026-06-29 17:00:00'),
(53, 'Julia Puspita', NULL, '081234500044', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-05-31 17:00:00', '2026-05-31 17:00:00'),
(54, 'Vina Ramadhani', NULL, '081234500045', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-16 17:00:00', '2026-07-16 17:00:00'),
(55, 'Rina Nabila', NULL, '081234500046', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-16 17:00:00', '2026-07-16 17:00:00'),
(56, 'Wahyu Widiastuti', NULL, '081234500047', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-16 17:00:00', '2026-06-16 17:00:00'),
(57, 'Tri Ramadhani', NULL, '081234500048', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-07-02 17:00:00', '2026-07-02 17:00:00'),
(58, 'Farah Safitri', NULL, '081234500049', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'orang_tua', 'aktif', '2026-06-11 17:00:00', '2026-06-11 17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balita`
--
ALTER TABLE `balita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balita_ibu_hamil_id_foreign` (`ibu_hamil_id`),
  ADD KEY `fk_balita_created_by` (`created_by`),
  ADD KEY `fk_balita_updated_by` (`updated_by`);

--
-- Indexes for table `ibu_hamil`
--
ALTER TABLE `ibu_hamil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ibu_hamil_nik_unique` (`nik`),
  ADD UNIQUE KEY `uq_ibu_hamil_user_id` (`user_id`),
  ADD KEY `fk_ibu_hamil_created_by` (`created_by`),
  ADD KEY `fk_ibu_hamil_updated_by` (`updated_by`);

--
-- Indexes for table `jadwal_posyandu`
--
ALTER TABLE `jadwal_posyandu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_created_by` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifikasi_user` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemeriksaan_awal_balita`
--
ALTER TABLE `pemeriksaan_awal_balita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaan_awal_balita_balita_id_foreign` (`balita_id`),
  ADD KEY `pemeriksaan_awal_balita_kader_id_foreign` (`kader_id`),
  ADD KEY `fk_pem_awal_balita_updated_by` (`updated_by`),
  ADD KEY `fk_pab_created_by` (`created_by`);

--
-- Indexes for table `pemeriksaan_awal_ibu_hamil`
--
ALTER TABLE `pemeriksaan_awal_ibu_hamil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaan_awal_ibu_hamil_ibu_hamil_id_foreign` (`ibu_hamil_id`),
  ADD KEY `pemeriksaan_awal_ibu_hamil_kader_id_foreign` (`kader_id`),
  ADD KEY `fk_pem_awal_ibu_hamil_updated_by` (`updated_by`),
  ADD KEY `fk_paih_created_by` (`created_by`);

--
-- Indexes for table `pemeriksaan_lanjutan_balita`
--
ALTER TABLE `pemeriksaan_lanjutan_balita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaan_lanjutan_balita_balita_id_foreign` (`balita_id`),
  ADD KEY `pemeriksaan_lanjutan_balita_bidan_id_foreign` (`bidan_id`),
  ADD KEY `fk_lanjutan_balita_awal` (`pemeriksaan_awal_id`),
  ADD KEY `fk_plb_updated_by` (`updated_by`),
  ADD KEY `fk_plb_created_by` (`created_by`);

--
-- Indexes for table `pemeriksaan_lanjutan_ibu_hamil`
--
ALTER TABLE `pemeriksaan_lanjutan_ibu_hamil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaan_lanjutan_ibu_hamil_ibu_hamil_id_foreign` (`ibu_hamil_id`),
  ADD KEY `pemeriksaan_lanjutan_ibu_hamil_bidan_id_foreign` (`bidan_id`),
  ADD KEY `fk_lanjutan_awal_ibu_hamil` (`pemeriksaan_awal_id`),
  ADD KEY `fk_pem_lanjutan_ibu_hamil_updated_by` (`updated_by`),
  ADD KEY `fk_plih_created_by` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_no_hp` (`no_hp`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balita`
--
ALTER TABLE `balita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ibu_hamil`
--
ALTER TABLE `ibu_hamil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `jadwal_posyandu`
--
ALTER TABLE `jadwal_posyandu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `pemeriksaan_awal_balita`
--
ALTER TABLE `pemeriksaan_awal_balita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pemeriksaan_awal_ibu_hamil`
--
ALTER TABLE `pemeriksaan_awal_ibu_hamil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `pemeriksaan_lanjutan_balita`
--
ALTER TABLE `pemeriksaan_lanjutan_balita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pemeriksaan_lanjutan_ibu_hamil`
--
ALTER TABLE `pemeriksaan_lanjutan_ibu_hamil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balita`
--
ALTER TABLE `balita`
  ADD CONSTRAINT `balita_ibu_hamil_id_foreign` FOREIGN KEY (`ibu_hamil_id`) REFERENCES `ibu_hamil` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_balita_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_balita_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ibu_hamil`
--
ALTER TABLE `ibu_hamil`
  ADD CONSTRAINT `fk_ibu_hamil_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_ibu_hamil_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_ibu_hamil_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_posyandu`
--
ALTER TABLE `jadwal_posyandu`
  ADD CONSTRAINT `fk_jadwal_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `fk_notifikasi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemeriksaan_awal_balita`
--
ALTER TABLE `pemeriksaan_awal_balita`
  ADD CONSTRAINT `fk_pab_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pem_awal_balita_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pemeriksaan_awal_balita_balita_id_foreign` FOREIGN KEY (`balita_id`) REFERENCES `balita` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_awal_balita_kader_id_foreign` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pemeriksaan_awal_ibu_hamil`
--
ALTER TABLE `pemeriksaan_awal_ibu_hamil`
  ADD CONSTRAINT `fk_paih_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pem_awal_ibu_hamil_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pemeriksaan_awal_ibu_hamil_ibu_hamil_id_foreign` FOREIGN KEY (`ibu_hamil_id`) REFERENCES `ibu_hamil` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_awal_ibu_hamil_kader_id_foreign` FOREIGN KEY (`kader_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pemeriksaan_lanjutan_balita`
--
ALTER TABLE `pemeriksaan_lanjutan_balita`
  ADD CONSTRAINT `fk_lanjutan_balita_awal` FOREIGN KEY (`pemeriksaan_awal_id`) REFERENCES `pemeriksaan_awal_balita` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_plb_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plb_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pemeriksaan_lanjutan_balita_balita_id_foreign` FOREIGN KEY (`balita_id`) REFERENCES `balita` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemeriksaan_lanjutan_balita_bidan_id_foreign` FOREIGN KEY (`bidan_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pemeriksaan_lanjutan_ibu_hamil`
--
ALTER TABLE `pemeriksaan_lanjutan_ibu_hamil`
  ADD CONSTRAINT `fk_lanjutan_awal_ibu_hamil` FOREIGN KEY (`pemeriksaan_awal_id`) REFERENCES `pemeriksaan_awal_ibu_hamil` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pem_lanjutan_ibu_hamil_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_plih_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pemeriksaan_lanjutan_ibu_hamil_bidan_id_foreign` FOREIGN KEY (`bidan_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pemeriksaan_lanjutan_ibu_hamil_ibu_hamil_id_foreign` FOREIGN KEY (`ibu_hamil_id`) REFERENCES `ibu_hamil` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
