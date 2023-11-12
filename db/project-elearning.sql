-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Nov 2023 pada 18.00
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-elearning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `kd_absensi` int(11) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `tgl_absensi` datetime NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`kd_absensi`, `nis`, `tgl_absensi`, `kd_kelas`, `kd_mapel`) VALUES
(82, '12345', '2023-11-12 22:05:23', 'xiirpl', 'Pbo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `kd_guru` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nip_password` varchar(50) NOT NULL DEFAULT '-',
  `nip` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL DEFAULT '-',
  `email` varchar(30) NOT NULL DEFAULT '-',
  `foto` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`kd_guru`, `username`, `nip_password`, `nip`, `nama`, `telp`, `email`, `foto`, `status`) VALUES
('GR001', 'smktpg2aa', '827ccb0eea8a706c4c34a16891f84e7b', '12345', 'Ahmad Amin Iswanto', '08979912254', 'rizkibinyola25@gmail.com', 'default.jpg', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `kd_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`kd_jurusan`, `nama_jurusan`) VALUES
('RPL', 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kd_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `tingkat` varchar(5) NOT NULL,
  `kd_jurusan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kd_kelas`, `nama_kelas`, `tingkat`, `kd_jurusan`) VALUES
('xiirpl', 'XII RPL', 'XII', 'RPL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kerja_tugas`
--

CREATE TABLE `kerja_tugas` (
  `kd_kerja` varchar(30) NOT NULL,
  `kd_tugas` varchar(30) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `file_kerja` varchar(100) NOT NULL DEFAULT 'T',
  `nilai` int(11) NOT NULL DEFAULT 0,
  `status_kerja` varchar(20) NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kerja_tugas`
--

INSERT INTO `kerja_tugas` (`kd_kerja`, `kd_tugas`, `nis`, `file_kerja`, `nilai`, `status_kerja`) VALUES
('12202312345001', '022023GR001001', '12345', 'T', 0, 'T');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` varchar(10) NOT NULL,
  `last` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`username`, `password`, `level`, `last`, `status`) VALUES
('', 'd41d8cd98f00b204e9800998ecf8427e', 'guru', '2023-11-12 14:29:26', 'aktif'),
('12345', '827ccb0eea8a706c4c34a16891f84e7b', 'siswa', '2023-11-12 05:20:53', 'aktif'),
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2020-12-14 09:45:15', 'Aktif'),
('smktpg2aa', '827ccb0eea8a706c4c34a16891f84e7b', 'guru', '2023-11-12 05:29:16', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `kd_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`kd_mapel`, `nama_mapel`) VALUES
('Bing1', 'Bahasa Inggris'),
('Pbo1', 'Pemrograman berbasis objek'),
('Pweb', 'Pemrograman Web');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `kd_materi` varchar(30) NOT NULL,
  `nama_materi` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `ForL` varchar(5) NOT NULL DEFAULT 'file',
  `materi` varchar(300) NOT NULL,
  `tgl_up` datetime NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`kd_materi`, `nama_materi`, `deskripsi`, `ForL`, `materi`, `tgl_up`, `kd_mapel`, `kd_kelas`, `kd_guru`) VALUES
('KM-001', 'tes', 'tes', 'file', 'NILAI BCF 2.xlsx', '2023-11-12 14:33:31', 'Pweb', 'xiirpl', 'GR001'),
('KM-002', 'tes', 'tes', 'link', 'https://github.com/RizkiRamadhanBinyola/project-elearning/tree/Rizkirb_laptop', '2023-11-12 14:37:04', 'Pweb', 'xiirpl', 'GR001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajaran`
--

CREATE TABLE `pengajaran` (
  `kd_pengajaran` int(11) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajaran`
--

INSERT INTO `pengajaran` (`kd_pengajaran`, `kd_mapel`, `kd_kelas`, `kd_guru`) VALUES
(28, 'Pbo', 'xiirpl', 'GR001'),
(30, 'Pweb', 'xiirpl', 'GR001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rombel`
--

CREATE TABLE `rombel` (
  `nis` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_tajar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rombel`
--

INSERT INTO `rombel` (`nis`, `kd_kelas`, `kd_tajar`) VALUES
('12345', 'xiirpl', '2023-2024-ganjil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(10) NOT NULL,
  `nisn` varchar(10) NOT NULL DEFAULT '-',
  `nisn_password` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelamin` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '-',
  `telp` varchar(20) NOT NULL DEFAULT '-',
  `status` varchar(10) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `nisn`, `nisn_password`, `nama`, `kelamin`, `email`, `telp`, `status`) VALUES
('12345', '12345', '827ccb0eea', 'Rizki Ramadhan Binyola', 'L', 'rizkibinyola25@gmail.com', '08979912254', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajar`
--

CREATE TABLE `tahun_ajar` (
  `kd_tajar` varchar(20) NOT NULL,
  `tahun_ajar` varchar(15) NOT NULL,
  `kd_semester` int(11) NOT NULL,
  `aktif` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_ajar`
--

INSERT INTO `tahun_ajar` (`kd_tajar`, `tahun_ajar`, `kd_semester`, `aktif`) VALUES
('2023-2024-ganjil', '2023-2024', 1, 'Y'),
('2023-2024-genap', '2023-2024', 2, 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `timeline`
--

CREATE TABLE `timeline` (
  `id_timeline` int(11) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `id_jenis` varchar(30) NOT NULL,
  `waktu` datetime NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `timeline`
--

INSERT INTO `timeline` (`id_timeline`, `jenis`, `id_jenis`, `waktu`, `kd_kelas`, `kd_mapel`, `kd_guru`) VALUES
(43, 'tugas', '022023GR001001', '2023-11-12 21:26:47', 'xiirpl', 'Pweb', 'GR001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `kd_tugas` varchar(30) NOT NULL,
  `nama_tugas` varchar(100) NOT NULL,
  `batas_awal` datetime NOT NULL,
  `batas_ahir` datetime NOT NULL,
  `file` varchar(50) NOT NULL,
  `tgl_up` datetime NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_guru` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`kd_tugas`, `nama_tugas`, `batas_awal`, `batas_ahir`, `file`, `tgl_up`, `kd_kelas`, `kd_mapel`, `kd_guru`) VALUES
('022023GR001001', 'tes', '2023-11-12 21:26:00', '2023-11-15 23:29:00', '022023GR001001_6550e0a7171f0.doc', '2023-11-12 21:26:47', 'xiirpl', 'Pweb', 'GR001');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`kd_absensi`),
  ADD KEY `kd_mapel` (`kd_mapel`),
  ADD KEY `kd_kelas` (`kd_kelas`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`kd_guru`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kd_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kd_kelas`),
  ADD KEY `kd_jurusan` (`kd_jurusan`);

--
-- Indeks untuk tabel `kerja_tugas`
--
ALTER TABLE `kerja_tugas`
  ADD PRIMARY KEY (`kd_kerja`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kd_mapel`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`kd_materi`),
  ADD KEY `kd_guru` (`kd_guru`),
  ADD KEY `kd_kelas` (`kd_kelas`),
  ADD KEY `kd_mapel` (`kd_mapel`);

--
-- Indeks untuk tabel `pengajaran`
--
ALTER TABLE `pengajaran`
  ADD PRIMARY KEY (`kd_pengajaran`);

--
-- Indeks untuk tabel `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `tahun_ajar`
--
ALTER TABLE `tahun_ajar`
  ADD PRIMARY KEY (`kd_tajar`);

--
-- Indeks untuk tabel `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id_timeline`),
  ADD KEY `kd_guru` (`kd_guru`),
  ADD KEY `kd_kelas` (`kd_kelas`),
  ADD KEY `kd_mapel` (`kd_mapel`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kd_tugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `kd_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `pengajaran`
--
ALTER TABLE `pengajaran`
  MODIFY `kd_pengajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id_timeline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kd_guru`) REFERENCES `guru` (`kd_guru`),
  ADD CONSTRAINT `materi_ibfk_2` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`),
  ADD CONSTRAINT `materi_ibfk_3` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel` (`kd_mapel`);

--
-- Ketidakleluasaan untuk tabel `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`kd_guru`) REFERENCES `guru` (`kd_guru`),
  ADD CONSTRAINT `timeline_ibfk_2` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas` (`kd_kelas`),
  ADD CONSTRAINT `timeline_ibfk_3` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel` (`kd_mapel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
