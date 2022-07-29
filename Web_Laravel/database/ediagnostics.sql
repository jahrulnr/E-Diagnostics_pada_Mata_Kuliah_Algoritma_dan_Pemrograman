-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2022 at 10:17 PM
-- Server version: 10.3.34-MariaDB-cll-lve
-- PHP Version: 8.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jahruln1_ediagnostics`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nama_dsn` varchar(30) NOT NULL,
  `noHP` varchar(12) NOT NULL,
  `password` char(60) NOT NULL,
  `hak_akses` enum('admin','dosen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `nama_dsn`, `noHP`, `password`, `hak_akses`) VALUES
(1, 'jahruln6@gmail.com', 'Jahrulnrr', '082218', '$2a$12$royGgfCsGcm/KvDy9rcBjejcKh/2ARrFcwJLz9Wd389QbeZqlNovS', 'admin'),
(12, 'dosen@gmail.com', 'Dosen Pengampu', '0822', '$2a$12$sXTa.QjwwnyF2GUyLssl8.xmgrLyLa7H.5ORKQJhp7aR3B.AzLkba', 'dosen');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(10) NOT NULL,
  `npm` varchar(9) NOT NULL,
  `id_soal` int(10) NOT NULL,
  `jawaban_mhs` text NOT NULL,
  `bobot_jawaban` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `npm`, `id_soal`, `jawaban_mhs`, `bobot_jawaban`) VALUES
(54, '173510428', 20, '1950', 40),
(55, '173510428', 21, 'Intropeksi dan eksperimen psikologi', 60),
(56, '173510428', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 80),
(57, '173510428', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 20),
(58, '173510428', 26, 'T=5\r\nA=2\r\nB=5', 60),
(59, '173510428', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 40),
(60, '173510428', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 40),
(61, '173510428', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 60),
(62, '173510429', 20, '1950', 30),
(63, '173510429', 21, 'Intropeksi dan eksperimen psikologi', 50),
(64, '173510429', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 70),
(65, '173510429', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 15),
(66, '173510429', 26, 'T=5\r\nA=2\r\nB=5', 40),
(67, '173510429', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 35),
(68, '173510429', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 40),
(69, '173510429', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 50),
(70, '173510500', 20, '1950', 40),
(71, '173510500', 21, 'Intropeksi dan eksperimen psikologi', 55),
(72, '173510500', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 60),
(73, '173510500', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 15),
(74, '173510500', 26, 'T=5\r\nA=2\r\nB=5', 50),
(75, '173510500', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 35),
(76, '173510500', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 40),
(77, '173510500', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 60),
(78, '173510501', 20, '1950', 40),
(79, '173510501', 21, 'Intropeksi dan eksperimen psikologi', 60),
(80, '173510501', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 60),
(81, '173510501', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 10),
(82, '173510501', 26, 'T=5\r\nA=2\r\nB=5', 20),
(83, '173510501', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 40),
(84, '173510501', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 30),
(85, '173510501', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 60),
(86, '173510502', 20, '1950', 40),
(87, '173510502', 21, 'Intropeksi dan eksperimen psikologi', 50),
(88, '173510502', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 70),
(89, '173510502', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 20),
(90, '173510502', 26, 'T=5\r\nA=2\r\nB=5', 40),
(91, '173510502', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 40),
(92, '173510502', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 30),
(93, '173510502', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 50),
(94, '173510503', 20, '1950', 30),
(95, '173510503', 21, 'Intropeksi dan eksperimen psikologi', 55),
(96, '173510503', 22, 'Algoritma Menghitung_Gaji\r\n\r\nKAMUS DATA\r\n  iGol, iJam, iUpah, iGaji : Integer \r\n\r\nBEGIN    \r\n      	\r\n    Input(iGol)    \r\n    Input(iJam)\r\n\r\n    iUpah  0\r\n    \r\n    Case(iGol)\r\n          1: iUpah  3000	         \r\n          2: iUpah  3500	         \r\n          3: iUpah  4000	         \r\n          4: iUpah  5000	              \r\n    End case\r\n    \r\n    If (iJam > 40) Then\r\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \r\n    Else\r\n         iGaji  iJam * iUpah\r\n    End if                                       \r\n     \r\n    Output(iGaji)\r\n\r\nEND', 80),
(97, '173510503', 23, 'ALGORITMA Menghitung_Kuadran\r\n\r\nKAMUS DATA\r\n    ix, iy: Integer\r\n\r\nBEGIN        \r\n   Input(ix,iy)\r\n\r\n    If (ix >= 0)\r\n          If (iy >=0)\r\n              Output(“Kuadran I”)\r\n          else \r\n              Output(“Kuadran IV”)\r\n    else \r\n          if (iy >=0)\r\n	Output(“Kuadran II”)\r\n          else \r\n              Output(“Kuadran III”)\r\nEND', 20),
(98, '173510503', 26, 'T=5\r\nA=2\r\nB=5', 40),
(99, '173510503', 27, 'cout << 4 << endl\r\n<< 3 << endl\r\n<< 2 << endl\r\n<< 1 << endl;', 20),
(100, '173510503', 18, 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 20),
(101, '173510503', 28, '1. Mulai\r\n2. Masukkan harga mangga per kg (hrg)\r\n3. Masukkan berat pembelian (brt)\r\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\r\n5. Tampilkan nilai byr\r\n6. Selesai', 20),
(102, '173510501', 29, '1', NULL),
(103, '173510501', 30, '2', NULL),
(104, '173510501', 31, '3', NULL),
(105, '173510501', 24, 'interger', NULL),
(106, '173510501', 25, 'var', NULL),
(107, '173510501', 19, 'if/else', NULL),
(108, '173510429', 19, 'boolean', NULL),
(109, '173510429', 25, 'besar kecil karakter dibedakan oleh sistem', NULL),
(110, '173510429', 24, 'int', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(10) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `kelas` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `id_admin`, `kelas`) VALUES
(6, 12, 'C'),
(7, 12, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `npm` varchar(9) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nama_mhs` varchar(60) NOT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `password` char(60) NOT NULL DEFAULT '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `email`, `nama_mhs`, `id_kelas`, `password`) VALUES
('173510428', 'jahruln6@gmail.com', 'Jahrulnr', 6, '$2y$10$dnVtsdPyACR1NojsPlEFRuMxO.9zwf0N6FKPC.2i2oCiwOw6J1yzy'),
('173510429', 'mhs1@contoh.com', 'Ocha Alina', 6, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510500', 'mhs2@contoh.com', 'Bambang Irawan', 7, '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2'),
('173510501', 'mhs3@contoh.com', 'Wahyu Setiawan', 7, '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2'),
('173510502', 'mhs4@contoh.com', 'Ade Prayoga', 7, '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2'),
('173510503', 'mhs5@contoh.com', 'M. Saugy', 7, '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(10) NOT NULL,
  `judul_materi` varchar(60) NOT NULL,
  `pertemuan` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `judul_materi`, `pertemuan`) VALUES
(1, 'Pengantar Algoritma dan Pemrograman', 1),
(2, 'Dasar-dasar Algoritma', 2),
(3, 'Identifier, Tipe data, Operator dan Ekspresi', 3),
(4, 'Fungsi Input dan output', 4),
(5, 'Struktur Runtunan', 5),
(6, 'Konstruksi Pemilihan/Seleksi', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(10) NOT NULL,
  `npm` varchar(9) NOT NULL,
  `id_materi` int(10) NOT NULL,
  `nilai_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `npm`, `id_materi`, `nilai_akhir`) VALUES
(15, '173510502', 1, 90),
(16, '173510500', 1, 95),
(17, '173510503', 1, 85),
(18, '173510501', 1, 100),
(19, '173510502', 2, 90),
(20, '173510500', 2, 75),
(21, '173510503', 2, 100),
(22, '173510501', 2, 70),
(23, '173510502', 4, 80),
(24, '173510500', 4, 85),
(25, '173510503', 4, 60),
(26, '173510501', 4, 60),
(27, '173510502', 5, 80),
(28, '173510500', 5, 100),
(29, '173510503', 5, 40),
(30, '173510501', 5, 90),
(31, '173510428', 1, 100),
(32, '173510429', 1, 80),
(33, '173510428', 2, 100),
(34, '173510429', 2, 85),
(35, '173510428', 4, 100),
(36, '173510429', 4, 75),
(37, '173510428', 5, 100),
(38, '173510429', 5, 90);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(10) NOT NULL,
  `id_materi` int(10) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `soal` text NOT NULL,
  `jawaban_soal` text NOT NULL,
  `bobot` float NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `id_materi`, `id_admin`, `soal`, `jawaban_soal`, `bobot`) VALUES
(18, 5, 12, 'Ciri khas program terstruktur adalah ...', 'Mudah dipahami, mudah dibaca, memiliki rancangan sistematis, mudah dikoreksi', 40),
(19, 3, 12, 'Tipe data bahasa C++ untuk true false adalah ...', 'boolean', 25),
(20, 1, 12, 'Alan Turning merancang sebuah ujian untuk mengetahui sebuah mesin dapat berperilaku sebagai manusia pada tahun ...', '1950', 40),
(21, 1, 12, 'Proses berpikir manusia umumnya melewati 2 tahap, adalah ...', 'Instrospection dan pshycological experiment', 60),
(22, 2, 12, 'Sebuah perusahaan swasta menggaji karyawannya secara mingguan dengan hitungan sebagai berikut :\n\ngolongan 1 dengan upah per jam 3.000 rupiah\ngolongan 2 dengan upah per jam 3.500 rupiah\ngolongan 3 dengan upah per jam 4.000 rupiah\ngolongan 4 dengan upah per jam 5.000 rupiah\n\nBila seorang karyawan bekerja kurang atau sama dengan 40 jam per minggu, akan dihitung dengan upah per jam seperti di atas, tetapi apabila bekerja lebih dari 40 jam, maka lebihnya akan dihitung sebagai lembur dengan upah per jam 1½ kali upah biasa.\nTulis algoritma untuk menghitung gaji mingguan karyawan, bila golongan dan jam kerja diinput dari keyboard.', 'Algoritma Menghitung_Gaji\n\nKAMUS DATA\n  iGol, iJam, iUpah, iGaji : Integer \n\nBEGIN    \n      	\n    Input(iGol)    \n    Input(iJam)\n\n    iUpah  0\n    \n    Case(iGol)\n          1: iUpah  3000	         \n          2: iUpah  3500	         \n          3: iUpah  4000	         \n          4: iUpah  5000	              \n    End case\n    \n    If (iJam > 40) Then\n         iGaji   40 * iUpah + ((iJam - 40) * 1.5 * iUpah)           \n    Else\n         iGaji  iJam * iUpah\n    End if                                       \n     \n    Output(iGaji)\n\nEND', 80),
(23, 2, 12, 'Buat algoritma dengan masukan koordinat sebuah titik (x,y) dalam sebuah system koordinat kartesian, kemudian ditentukan di kuadran mana titik tersebut.\nContoh Masukan :\nKoordinat titik (x,y) : 10 -20\n\nContoh keluaran:\nTitik 10,-20 berada pada kuadran 4', 'ALGORITMA Menghitung_Kuadran\n\nKAMUS DATA\n    ix, iy: Integer\n\nBEGIN        \n   Input(ix,iy)\n\n    If (ix >= 0)\n          If (iy >=0)\n              Output(“Kuadran I”)\n          else \n              Output(“Kuadran IV”)\n    else \n          if (iy >=0)\n	Output(“Kuadran II”)\n          else \n              Output(“Kuadran III”)\nEND', 20),
(24, 3, 12, 'Tipe data dengan nilai bilangan bulat adalah ...', 'int', 25),
(25, 3, 12, 'Penulisan variabel dalam c++ bersifat case sensitive artinya?', 'Huruf besar dan kecil diperhitungkan', 50),
(26, 4, 12, 'Jika diketahui A=5, B=2, berapa isi A dan B dan T jika dikenai instruksi\r\nsebagai berikut:\r\nT=A\r\nA=B\r\nB=T', 'T=5\r\nA=2\r\nB=5', 60),
(27, 4, 12, 'Buatlah program untuk mencetak empat buah bilangan bulat!', 'cout << 4 << endl\n<< 3 << endl\n<< 2 << endl\n<< 1 << endl;', 40),
(28, 5, 12, 'Seorang pedagang mangga menjual dagangannya yang setiap kg mangga dihargai dengan harga tertentu. Setiap pembeli membayar harga mangga yang dibelinya berdasarkan berat. Tentukan perintah apa yang diberikan pedagang mangga kepada komputer agar ia dapat dengan mudah menentukan harga yang harus pembelinya.', '1. Mulai\n2. Masukkan harga mangga per kg (hrg)\n3. Masukkan berat pembelian (brt)\n4. Kalikan hrg dengan brt, simpan sebagai harga yang harus dibayar pembeli (byr)\n5. Tampilkan nilai byr\n6. Selesai', 60),
(29, 6, 12, 'Sebutkan 2 statement seleksi!', 'if-else dan switch-case', 40),
(30, 6, 12, 'Pemilihan (seleksi) adalah instruksi kode program yang akan dikerjakan apabila kondisi bernilai ...', 'true', 30),
(31, 6, 12, 'Apabila Pemilihan (seleksi) bernilai FALSE maka instruksi kode program tidak akan ... atau dialihkan pada kondisi berikutnya', 'dijalankan', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `j_npm` (`npm`),
  ADD KEY `j_soal` (`id_soal`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kls_id_admin` (`id_admin`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`npm`),
  ADD KEY `kls_mhs` (`id_kelas`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `n_materi` (`id_materi`),
  ADD KEY `n_mahasiswa` (`npm`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `s_materi` (`id_materi`) USING BTREE,
  ADD KEY `s_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `j_npm` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `j_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kls_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `kls_mhs` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `n_mahasiswa` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `n_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `s_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
