-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Agu 2022 pada 06.12
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yukbelajar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `course`
--

CREATE TABLE `course` (
  `id_kursus` int(5) NOT NULL,
  `nm_kursus` varchar(50) NOT NULL,
  `ket_kursus` text NOT NULL,
  `lama_kursus` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `course`
--

INSERT INTO `course` (`id_kursus`, `nm_kursus`, `ket_kursus`, `lama_kursus`) VALUES
(3, 'Java', 'Deskripsi Kursus Java', 4),
(4, 'PHP', 'Deskripsi Kursus PHP', 5),
(5, 'C#', 'Deskripsi Kursus C#', 6),
(6, 'Python', 'Deskripsi Kursus Python', 4),
(7, 'Javascript', 'Deskripsi Kursus Javascript', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(5) NOT NULL,
  `id_kursus` int(5) NOT NULL,
  `waktu_kursus` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_kursus`, `waktu_kursus`) VALUES
(3, 4, '2022-08-26'),
(4, 6, '2022-08-19'),
(5, 3, '2022-08-22'),
(6, 7, '2022-08-27'),
(7, 5, '2022-08-31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(5) NOT NULL,
  `id_pelajar` int(5) NOT NULL,
  `id_jadwal` int(5) NOT NULL,
  `krs_pelajar` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_pelajar`, `id_jadwal`, `krs_pelajar`, `status`) VALUES
(55, 1, 4, 'a', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelajar`
--

CREATE TABLE `pelajar` (
  `id_pelajar` int(5) NOT NULL,
  `nm_pelajar` varchar(50) NOT NULL,
  `kls_pelajar` varchar(6) NOT NULL,
  `nim_pelajar` varchar(40) NOT NULL,
  `role` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelajar`
--

INSERT INTO `pelajar` (`id_pelajar`, `nm_pelajar`, `kls_pelajar`, `nim_pelajar`, `role`) VALUES
(1, 'Moona Hoshinova', 'IDGEN1', '13853765', 'pelajar'),
(2, 'admin', '', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_kursus`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD UNIQUE KEY `id_kursus` (`id_kursus`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `pelajar`
--
ALTER TABLE `pelajar`
  ADD PRIMARY KEY (`id_pelajar`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `course`
--
ALTER TABLE `course`
  MODIFY `id_kursus` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `pelajar`
--
ALTER TABLE `pelajar`
  MODIFY `id_pelajar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
