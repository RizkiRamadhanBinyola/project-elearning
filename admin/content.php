<?php
// Memeriksa apakah variabel sesi 'username', 'level', dan 'login' kosong
if (empty($_SESSION['username']) AND empty($_SESSION['level']) AND $_SESSION['login']==0){
  // Jika kosong, tampilkan pesan kesalahan dan kembalikan ke halaman index.php
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
}
else {
  // Jika tidak kosong, lanjutkan dengan mengeksekusi kode berikutnya

  // Ambil nilai parameter 'module' dari URL
  $modul=$_GET['module'];

  // Kode switch ($_SESSION['level']) untuk melakukan seleksi atau percabangan berdasarkan nilai dari variabel $_SESSION['level']
  switch ($_SESSION['level']) {
    case 'guru':
      // Jika level pengguna adalah 'guru'
      switch ($modul) {
        case 'home':
          // Jika modul adalah 'home', sertakan file home_v.php untuk tampilan halaman home guru
          include "modul/mod_home/home_v.php";
          break;

        case 'absensi':
          // Jika modul adalah 'absensi', sertakan file kehadiran_v.php untuk tampilan halaman absensi guru
          include "modul/kehadiran/kehadiran_v.php";
          break;

        case 'materi':
          // Jika modul adalah 'materi', sertakan file materi_v.php untuk tampilan halaman materi guru
          include "modul/mod_materi/materi_v.php";
          break;

        case 'tugas':
          // Jika modul adalah 'tugas', sertakan file tugas_v.php untuk tampilan halaman tugas guru
          include "modul/mod_tugas/tugas_v.php";
          break;

        case 'detailtugas':
          // Jika modul adalah 'detailtugas', sertakan file detailtugas.php untuk tampilan detail tugas guru
          include "modul/mod_tugas/detailtugas.php";
          break;

        default:
          // Jika modul tidak ditemukan, sertakan file mod_404.php untuk tampilan halaman 404
          include "modul/mod_404.php";
          break;
      }
      break;

    case 'admin':
      // Jika level pengguna adalah 'admin'
      switch ($modul) {
        case 'homeadm':
          // Jika modul adalah 'homeadm', sertakan file homeadm_v.php untuk tampilan halaman home admin
          include "modul/mod_homeadm/homeadm_v.php";
          break;

        case 'regadmin':
          // Jika modul adalah 'regadmin', sertakan file regadmin_v.php untuk tampilan halaman registrasi admin
          include "modul/mod_regadmin/regadmin_v.php";
          break;

        case 'jurusan':
          // Jika modul adalah 'jurusan', sertakan file jurusan_v.php untuk tampilan halaman data jurusan
          include "modul/mod_jurusan/jurusan_v.php";
          break;

        case 'siswa':
          // Jika modul adalah 'siswa', sertakan file siswa_v.php untuk tampilan halaman data siswa
          include "modul/mod_siswa/siswa_v.php";
          break;

        case 'guru':
          // Jika modul adalah 'guru', sertakan file guru_v.php untuk tampilan halaman data guru
          include "modul/mod_guru/guru_v.php";
          break;

        case 'kelas':
          // Jika modul adalah 'kelas', sertakan file kelas_v.php untuk tampilan halaman data kelas
          include "modul/mod_kelas/kelas_v.php";
          break;

        case 'mapel':
          // Jika modul adalah 'mapel', sertakan file mapel_v.php untuk tampilan halaman data mata pelajaran
          include "modul/mod_mapel/mapel_v.php";
          break;

        case 'rombel':
          // Jika modul adalah 'rombel', sertakan file rombel_v.php untuk tampilan halaman data rombel
          include "modul/mod_rombel/rombel_v.php";
          break;

        case 'tahun':
          // Jika modul adalah 'tahun', sertakan file tahun_v.php untuk tampilan halaman data tahun ajaran
          include "modul/mod_tahun_ajar/tahun_v.php";
          break;

        case 'pengajaran':
          // Jika modul adalah 'pengajaran', sertakan file pengajaran.php untuk tampilan halaman pengajaran
          include "modul/mod_pengajaran/pengajaran.php";
          break;

        default:
          // Jika modul tidak ditemukan, sertakan file mod_404.php untuk tampilan halaman 404
          include "modul/mod_404.php";
          break;
      }
      break;

    case 'siswa':
      // Jika level pengguna adalah 'siswa'
      $q = mysqli_query($connect, "SELECT * FROM siswa, rombel, kelas WHERE rombel.nis = siswa.nis AND rombel.kd_kelas = kelas.kd_kelas AND rombel.nis = '$_SESSION[kode]' AND rombel.kd_tajar = '$kd_tajar'");
      $rombel = "OK";
      if (mysqli_num_rows($q)) {
          $qkls = mysqli_fetch_array($q);
          $kode_kelas = $qkls['kd_kelas'];
          $nama_kelas = $qkls['nama_kelas'];
          $nama_siswa = $qkls['nama']; // Menggunakan 'nama' sebagai gantinya
          $nis = $qkls['nis'];
          $username = $qkls['nama']; // Menggunakan 'nama' sebagai gantinya
      } else {
          $rombel = "NULL";
          $kode_kelas = "kosong";
          $nama_kelas = "kosong";
          $username = "kosong";
      }
    
      switch ($modul) {
        case 'home':
          // Jika modul adalah 'home', sertakan file home_v.php untuk tampilan halaman home siswa
          include "modul/home_siswa/home_v.php";
          break;

        case 'materi':
          // Jika modul adalah 'materi', sertakan file materi_v.php untuk tampilan halaman materi siswa
          include "modul/mod_materi_siswa/materi_v.php";
          break;

        case 'tugas':
          // Jika modul adalah 'tugas', sertakan file tugas_v.php untuk tampilan halaman tugas siswa
          include "modul/mod_tugas_siswa/tugas_v.php";
          break;

        case 'detailtugas':
          // Jika modul adalah 'detailtugas', sertakan file detail_tugas.php untuk tampilan detail tugas siswa
          include "modul/mod_tugas_siswa/detail_tugas.php";
          break;

        case 'nilai':
          // Jika modul adalah 'nilai', sertakan file nilai_v.php untuk tampilan halaman nilai siswa
          include "modul/mod_nilai_siswa/nilai_v.php";
          break;

        default:
          // Jika modul tidak ditemukan, sertakan file mod_404.php untuk tampilan halaman 404
          include "modul/mod_404.php";
          break;
      }
      break;

    default:
      // Jika level tidak ditemukan, tampilkan pesan bahwa modul belum ada atau belum lengkap
      echo "<p><b><center>MODUL BELUM ADA ATAU BELUM LENGKAP</center></b></p>";
      break;
  }
}
?>