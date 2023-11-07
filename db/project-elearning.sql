-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Nov 2023 pada 06.58
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
(1, '2023-09-16', '2023-09-16 08:51:41', '', ''),
(2, '2023-09-16', '2023-09-16 14:09:45', '', ''),
(3, '2023-09-21', '2023-09-21 14:45:49', '', ''),
(4, '2023-09-21', '2023-09-21 14:53:04', '', ''),
(5, '2023-09-26', '2023-09-26 10:36:43', '', ''),
(6, '2023-09-26', '2023-09-26 14:12:09', '', ''),
(7, '2023-09-27', '2023-09-27 14:02:34', '', ''),
(8, '2023-10-22', '2023-10-22 08:47:55', '', ''),
(9, '2023-10-22', '2023-10-22 09:11:22', '', ''),
(10, '2023-10-22', '2023-10-22 09:52:10', '', ''),
(11, '2023-10-22', '2023-10-22 10:03:21', '', ''),
(12, '2023-10-22', '2023-10-22 15:54:31', '', ''),
(13, '2023-10-23', '2023-10-23 03:05:27', '', ''),
(14, '2023-10-25', '2023-10-25 09:00:01', '', ''),
(15, '2023-10-25', '2023-10-25 09:01:34', '', ''),
(16, '2023-10-25', '2023-10-25 09:01:58', '', ''),
(17, '2023-10-25', '2023-10-25 09:02:19', '', ''),
(18, '2023-10-25', '2023-10-25 09:13:58', '', ''),
(19, '2023-10-30', '2023-10-30 01:48:23', '', ''),
(20, '2023-10-30', '2023-10-30 02:14:31', '', ''),
(21, '2023-10-30', '2023-10-30 04:49:52', '', ''),
(22, '2023-10-31', '2023-10-31 01:18:30', '', ''),
(23, '2023-10-31', '2023-10-31 02:02:51', '', ''),
(24, '2023-10-31', '2023-10-31 02:29:06', '', ''),
(25, '2023-11-02', '2023-11-02 01:17:25', '', ''),
(26, '2023-11-02', '2023-11-02 01:49:02', '', ''),
(27, '2023-11-02', '2023-11-02 02:09:33', '', ''),
(28, '2023-11-02', '2023-11-02 05:42:22', '', ''),
(29, '2023-11-02', '2023-11-02 06:15:59', '', ''),
(30, '2023-11-02', '2023-11-02 06:26:23', '', ''),
(31, '2023-11-03', '2023-11-03 04:22:57', '', ''),
(32, '2023-11-03', '2023-11-03 05:15:37', '', ''),
(33, '2023-11-03', '2023-11-03 07:04:39', '', ''),
(34, '2023-11-06', '2023-11-06 02:15:06', '', ''),
(35, '2023-11-06', '2023-11-06 04:56:01', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_soal`
--

CREATE TABLE `detail_soal` (
  `kd_detail_soal` varchar(100) NOT NULL,
  `kd_soal` varchar(30) NOT NULL,
  `soal` text NOT NULL,
  `pil_A` varchar(100) NOT NULL,
  `pil_B` varchar(100) NOT NULL,
  `pil_C` varchar(100) NOT NULL,
  `pil_D` varchar(100) NOT NULL,
  `pil_E` varchar(100) NOT NULL,
  `kunci` varchar(5) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(100) NOT NULL DEFAULT 'T',
  `C` varchar(30) NOT NULL DEFAULT '-',
  `P` varchar(30) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_soal`
--

INSERT INTO `detail_soal` (`kd_detail_soal`, `kd_soal`, `soal`, `pil_A`, `pil_B`, `pil_C`, `pil_D`, `pil_E`, `kunci`, `keterangan`, `gambar`, `C`, `P`) VALUES
('442020GR089001', '142020GR089001', 'Pertanyaan 1', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, '442020GR089001_87390136.jpg', '-', '-'),
('442020GR089002', '142020GR089001', 'Pertanyaan 2', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089003', '142020GR089001', 'Pertanyaan 3', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089004', '142020GR089001', 'Pertanyaan 4', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089005', '142020GR089001', 'Pertanyaan 5', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089006', '142020GR089001', 'Pertanyaan 6', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, '442020GR089006_51773071.jpg', '-', '-'),
('442020GR089007', '142020GR089001', 'Pertanyaan 7', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089008', '142020GR089001', 'Pertanyaan 8', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089009', '142020GR089001', 'Pertanyaan 9', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442020GR089010', '142020GR089001', 'Pertanyaan 10', 'Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E', 'a', NULL, 'T', '-', '-'),
('442021GR090001', '142021GR090001', 'abcd', 'a', 'b', 'c', 'd', 'e', 'a', NULL, 'T', '-', '-');

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
('GR001', 'smktpg2aa', '12345', '12345', 'Ahmad Amin Iswanto', '089122211234', 'rizkiramadhanbinyola@gmail.com', 'default.jpg', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_ke` int(11) NOT NULL,
  `kd_guru` varchar(20) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `judul_materi` varchar(100) NOT NULL,
  `jml_siswa` int(11) NOT NULL,
  `nm_siswa_tdhdr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id_jurnal`, `tanggal`, `jam_ke`, `kd_guru`, `kd_mapel`, `kd_kelas`, `judul_materi`, `jml_siswa`, `nm_siswa_tdhdr`) VALUES
(9, '2021-01-13', 1, 'GR090', 'bing', 'xakl1', 'testing', 20, '					test						');

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
('AKL', 'Akutansi'),
('BDP', 'Bisnis daring dan pemasaran'),
('DKV', 'Desain Komunikasi Visual'),
('MM', 'Multimedia'),
('OTKP', 'Otomatisasi dan Tata Kelola Perkantoran '),
('PBK', 'Perbankan'),
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
('xdkv', 'X DKV', 'X', 'DKV'),
('xiibdp', 'XII BDP', 'XII', 'BDP'),
('xiimm', 'XII MM', 'XII', 'MM'),
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
('1220208168001', '022020GR090001', '8168', '1220208168001.png', 90, 'N'),
('1220208168002', '022020GR090002', '8168', 'T', 0, 'T'),
('1220208168003', '022020GR090003', '8168', 'T', 0, 'T'),
('1220208170001', '022020GR090001', '8170', 'T', 0, 'T'),
('1220208170002', '022020GR090002', '8170', 'T', 0, 'T'),
('1220208170003', '022020GR090003', '8170', '1220208170003.jpg', 80, 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(200) NOT NULL,
  `penulis_komentar` varchar(100) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` varchar(100) NOT NULL,
  `id_post` int(100) NOT NULL,
  `pp_penulis` text NOT NULL,
  `penulis_post` varchar(100) NOT NULL,
  `lihat_komentar` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `penulis_komentar`, `isi_komentar`, `tanggal_komentar`, `id_post`, `pp_penulis`, `penulis_post`, `lihat_komentar`) VALUES
(0, 'smkwsb91', 'test', '2:49 17/12/2020', 0, '', 'smkwsb91', 1),
(0, 'smkwsb91', 't', '2:50 17/12/2020', 0, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'tu', '2:50 17/12/2020', 0, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'tuk', '2:50 17/12/2020', 0, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'ddd', '3:01 17/12/2020', 0, '', 'smkwsb91', 1),
(0, '8170', 'gg', '3:51 17/12/2020', 2, '', '8170', 1),
(0, '8170', 'ggk', '3:51 17/12/2020', 2, '', '8170', 1),
(0, '8170', 'ggkp', '3:51 17/12/2020', 2, '', '8170', 1),
(0, '8170', 'ggkpi', '3:51 17/12/2020', 2, '', '8170', 1),
(0, '8170', 'hai', '20:55 17/12/2020', 2, '', '8170', 1),
(0, 'smkwsb91', 'ok 1', '11:21 18/12/2020', 4, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'ok 2', '11:22 18/12/2020', 4, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'ok 3', '11:22 18/12/2020', 4, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'ok 4', '11:22 18/12/2020', 4, '', 'smkwsb91', 1),
(0, '8170', 'baik pak ibu guru', '11:23 18/12/2020', 4, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'hai', '17:49 29/12/2020', 4, '', 'smkwsb91', 1),
(0, 'smkwsb91', 'hai', '12:05 12/01/2021', 5, '', 'smkwsb91', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lihat`
--

CREATE TABLE `lihat` (
  `user_lihat` varchar(100) NOT NULL,
  `lihat` int(5) NOT NULL,
  `apa_lihat` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
('12345', '827ccb0eea8a706c4c34a16891f84e7b', 'siswa', '2023-10-25 04:39:47', 'aktif'),
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2020-12-14 09:45:15', 'Aktif'),
('smktpg2aa', '827ccb0eea8a706c4c34a16891f84e7b', 'guru', '2023-10-25 09:01:26', 'aktif');

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
('Bindo', 'Bahasa Indonesia'),
('Bing', 'Bahasa Inggris'),
('Pbo', 'Pemrograman berbasis objek'),
('Pkn', 'Pendidikan Kewarganegaraan'),
('Pweb', 'Pemrograman Web');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `kd_materi` varchar(30) NOT NULL,
  `nama_materi` varchar(300) NOT NULL,
  `deskripsi` text NOT NULL,
  `ForL` varchar(5) NOT NULL DEFAULT 'file',
  `materi` varchar(50) NOT NULL,
  `tgl_up` datetime NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`kd_materi`, `nama_materi`, `deskripsi`, `ForL`, `materi`, `tgl_up`, `kd_mapel`, `kd_kelas`, `kd_guru`) VALUES
('KM-001', 'afaaf', 'etAa', 'file', 'Logika matematika_82853981.pdf', '2023-11-06 02:30:34', 'Pbo', 'xiirpl', 'GR001'),
('KM-002', 'tes', 'tes', 'link', 'https://github.com/ndeet/unzipper/blob/master/unzi', '2023-11-06 05:59:56', 'Pbo', 'xiirpl', 'GR001'),
('KM-003', 'tes', 'tes', 'file', 'kantin_pradita-master.zip', '2023-11-06 06:46:32', 'Pbo', 'xiirpl', 'GR001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi_v2`
--

CREATE TABLE `materi_v2` (
  `kode_materi` varchar(25) NOT NULL,
  `nama_materi` varchar(250) NOT NULL,
  `judul_materi` varchar(250) NOT NULL,
  `size` int(11) NOT NULL,
  `ekstensi` varchar(25) NOT NULL,
  `berkas` varchar(2000) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_jurusan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `materi_v2`
--

INSERT INTO `materi_v2` (`kode_materi`, `nama_materi`, `judul_materi`, `size`, `ekstensi`, `berkas`, `kd_kelas`, `kd_mapel`, `kd_jurusan`) VALUES
('BG01', 'Tes', 'Logika matematika_82853981.pdf', 4487, 'pdf', 'files/materi/Logika matematika_82853981.pdf', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_ujian`
--

CREATE TABLE `nilai_ujian` (
  `kd_nilai_ujian` varchar(30) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `kd_ujian` varchar(50) NOT NULL,
  `tgl_mengerjakan` datetime NOT NULL,
  `nilai` int(11) NOT NULL,
  `salah` int(11) NOT NULL,
  `benar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajaran`
--

CREATE TABLE `pengajaran` (
  `kd_pengajaran` int(11) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL,
  `kd_silabus` varchar(30) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajaran`
--

INSERT INTO `pengajaran` (`kd_pengajaran`, `kd_mapel`, `kd_kelas`, `kd_guru`, `kd_silabus`) VALUES
(11, 'bing', 'xakl1', 'GR090', '1'),
(12, 'bind', 'xakl1', 'GR090,GR079', '042021GR090001'),
(13, 'bk', 'xan1', 'GR089', '1'),
(16, 'bind', 'xiakl1', 'GR001', '1'),
(17, 'bing', 'xiiakl1', 'GR096', '1'),
(20, 'Pbo', 'xirpl', 'GR001', '1'),
(21, 'Pbo', 'xiirpl', 'GR001', '1'),
(22, 'Bing', 'xiirpl', 'GR001', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `post`
--

CREATE TABLE `post` (
  `id_post` int(200) NOT NULL,
  `kd_pengajaran` int(11) NOT NULL,
  `judul_post` varchar(200) NOT NULL,
  `isi_post` text NOT NULL,
  `penulis_post` varchar(100) NOT NULL,
  `tanggal_post` varchar(100) NOT NULL,
  `gambar_post` text NOT NULL,
  `suka_post` int(10) NOT NULL,
  `laporkan` varchar(20) NOT NULL,
  `tgl_lapor` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `post`
--

INSERT INTO `post` (`id_post`, `kd_pengajaran`, `judul_post`, `isi_post`, `penulis_post`, `tanggal_post`, `gambar_post`, `suka_post`, `laporkan`, `tgl_lapor`) VALUES
(1, 2, 'j', '<p>k</p>\r\n', '8170', '3:50 17/12/2020', '', 0, '0', '0000-00-00 00:00:00'),
(2, 2, 'o', '<p>p</p>\r\n', '8170', '3:51 17/12/2020', '', 0, '0', '0000-00-00 00:00:00'),
(3, 2, 'test', '<p>test</p>\r\n', '8170', '20:59 17/12/2020', '', 1, '0', '0000-00-00 00:00:00'),
(4, 7, 'selamat pagi siswa', '<p>coba 1</p>\r\n', 'smkwsb91', '11:20 18/12/2020', '20201218_112051daftar_soal.JPG', 1, '0', '0000-00-00 00:00:00'),
(5, 9, 'test', '<p>s</p>\r\n', 'smkwsb91', '12:05 12/01/2021', '', 0, '0', '0000-00-00 00:00:00');

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
-- Struktur dari tabel `silabus`
--

CREATE TABLE `silabus` (
  `kd_silabus` varchar(30) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_jurusan` varchar(10) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `judul` varchar(32) NOT NULL,
  `nama_file` varchar(50) NOT NULL,
  `tanggal_upload` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `silabus`
--

INSERT INTO `silabus` (`kd_silabus`, `kd_mapel`, `kd_jurusan`, `tingkat`, `judul`, `nama_file`, `tanggal_upload`) VALUES
('042021GR090001', 'bind', 'akl', 'X', 'test', 'bind_X_akl.pdf', '2021-02-17 07:47:52'),
('1', 'default', 'default', 'defaut', 'Belum Upload Silabus', 'silabus-default.pdf', '2020-12-14 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(10) NOT NULL,
  `nisn` varchar(10) NOT NULL DEFAULT '-',
  `nama` varchar(100) NOT NULL,
  `kelamin` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '-',
  `foto` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `telp` varchar(20) NOT NULL DEFAULT '-',
  `status` varchar(10) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `nisn`, `nama`, `kelamin`, `email`, `foto`, `telp`, `status`) VALUES
('12345', '12345', 'Rizki Ramadhan Binyola', 'L', 'rizkiramadhanbinyola@gmail.com', '', '089122211234', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `kd_soal` varchar(30) NOT NULL,
  `nama_soal` varchar(100) NOT NULL,
  `acak` varchar(5) NOT NULL DEFAULT 'T',
  `kd_mapel` varchar(10) NOT NULL,
  `kd_guru` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`kd_soal`, `nama_soal`, `acak`, `kd_mapel`, `kd_guru`) VALUES
('142020GR089001', 'Soal Bhs Ing', 'T', 'bing', 'GR089'),
('142021GR090001', 'ppkn1', 'T', 'ppkn', 'GR090');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suka_post`
--

CREATE TABLE `suka_post` (
  `id_suka` bigint(20) UNSIGNED NOT NULL,
  `user_suka` varchar(100) NOT NULL,
  `id_post` int(200) NOT NULL,
  `post_suka` int(5) NOT NULL,
  `penulis_post` varchar(100) NOT NULL,
  `tanggal_suka` varchar(100) NOT NULL,
  `lihat_suka` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `suka_post`
--

INSERT INTO `suka_post` (`id_suka`, `user_suka`, `id_post`, `post_suka`, `penulis_post`, `tanggal_suka`, `lihat_suka`) VALUES
(0, 'smkwsb91', 0, 0, 'smkwsb91', '2:45 17/12/2020', 1),
(0, 'smkwsb91', 3, 1, '8170', '7:07 18/12/2020', 1),
(0, 'smkwsb91', 4, 1, 'smkwsb91', '11:21 18/12/2020', 1);

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
('2022-2023-ganjil', '2022-2023', 1, 'N'),
('2022-2023-genap', '2022-2023', 2, 'N'),
('2023-2024-ganjil', '2023-2024', 1, 'Y'),
('2023-2024-genap', '2023-2024', 2, 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tes`
--

CREATE TABLE `tes` (
  `kode_buku` varchar(25) NOT NULL,
  `nama_buku` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `size` int(11) NOT NULL,
  `ekstensi` varchar(25) NOT NULL,
  `berkas` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `kd_tugas` varchar(30) NOT NULL,
  `nama_tugas` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
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

INSERT INTO `tugas` (`kd_tugas`, `nama_tugas`, `deskripsi`, `batas_awal`, `batas_ahir`, `file`, `tgl_up`, `kd_kelas`, `kd_mapel`, `kd_guru`) VALUES
('022020GR090001', 'Tugas 1', 'Integer ultrices lobortis eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin semper, ante vitae sollicitudin posuere, metus quam iaculis nibh, vitae scelerisque nunc massa eget pede. Sed velit urna, interdum vel, ultricies vel, faucibus at, quam. Donec elit est, consectetuer eget, consequat quis, tempus quis, wisi.', '2020-12-16 08:00:00', '2020-12-17 23:59:00', 'Tugas 1_83469434.pdf', '2020-12-16 06:07:49', 'xakl1', 'bing', 'GR090'),
('022020GR090002', 'Tugas 2', 'silahkan dikerjakan', '2020-12-18 06:48:00', '2020-12-18 06:48:00', 'Tugas 2_38766479.pdf', '2020-12-18 06:48:46', 'xakl1', 'bing', 'GR090'),
('022020GR090003', 'Tugas 3', 'dikerjakan', '2020-12-18 06:51:00', '2020-12-18 07:51:00', 'Tugas 3_77841186.pdf', '2020-12-18 06:51:35', 'xakl1', 'bing', 'GR090'),
('022021GR090001', 'tugas1', 'ok', '2021-01-12 05:45:00', '2021-01-14 11:46:00', 'tugas1_90667724.png', '2021-01-12 11:46:14', 'xdpib1', 'mtk', 'GR090');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `kd_ujian` varchar(50) NOT NULL,
  `nama_ujian` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `tgl_ujian` datetime NOT NULL,
  `tgl_ahir` datetime NOT NULL,
  `jam` int(11) NOT NULL,
  `menit` int(11) NOT NULL,
  `detik` int(11) NOT NULL,
  `kd_soal` varchar(50) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `kd_guru` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ujian`
--

INSERT INTO `ujian` (`kd_ujian`, `nama_ujian`, `deskripsi`, `tgl_ujian`, `tgl_ahir`, `jam`, `menit`, `detik`, `kd_soal`, `kd_kelas`, `kd_mapel`, `kd_guru`) VALUES
('072020GR090001', 'Ujian Matematika', 'Ujian MTK', '2020-12-28 22:10:00', '2020-12-28 23:10:00', 1, 0, 0, '142020GR090001', 'xakl1', 'mtk', 'GR090'),
('072020GR089001', 'Ujian Bahasa Inggris 1', 'aksdalksjdaladasdjladsad', '2020-12-29 07:05:00', '2020-12-29 22:06:00', 1, 0, 0, '142020GR089001', 'xakl1', 'bing', 'GR089'),
('072021GR090001', 'uj_ppkn', 'semangat', '2021-01-13 04:23:00', '2021-01-14 04:23:00', 1, 10, 0, '142021GR090001', 'xakl1', 'ppkn', 'GR090');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `kd_guru` varchar(20) NOT NULL,
  `kd_kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`kd_absensi`);

--
-- Indeks untuk tabel `detail_soal`
--
ALTER TABLE `detail_soal`
  ADD PRIMARY KEY (`kd_detail_soal`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`kd_guru`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `kd_guru` (`kd_guru`,`kd_mapel`),
  ADD KEY `kd_kelas` (`kd_kelas`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kd_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kd_kelas`);

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
  ADD PRIMARY KEY (`kd_materi`);

--
-- Indeks untuk tabel `materi_v2`
--
ALTER TABLE `materi_v2`
  ADD PRIMARY KEY (`kode_materi`);

--
-- Indeks untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD PRIMARY KEY (`kd_nilai_ujian`);

--
-- Indeks untuk tabel `pengajaran`
--
ALTER TABLE `pengajaran`
  ADD PRIMARY KEY (`kd_pengajaran`),
  ADD KEY `kd_silabus` (`kd_silabus`);

--
-- Indeks untuk tabel `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- Indeks untuk tabel `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `silabus`
--
ALTER TABLE `silabus`
  ADD PRIMARY KEY (`kd_silabus`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`kd_soal`);

--
-- Indeks untuk tabel `tahun_ajar`
--
ALTER TABLE `tahun_ajar`
  ADD PRIMARY KEY (`kd_tajar`);

--
-- Indeks untuk tabel `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id_timeline`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `kd_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengajaran`
--
ALTER TABLE `pengajaran`
  MODIFY `kd_pengajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id_timeline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
