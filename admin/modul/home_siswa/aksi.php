<?php
include "../../../koneksi/koneksi.php";

if (isset($_GET['act'])) {
  switch ($_GET['act']) {
    case 'absen':
      // Filter input dari GET
      $nis = mysqli_real_escape_string($connect, $_GET['nis']);
      $kelas = mysqli_real_escape_string($connect, $_GET['kls']);
      $mapel = mysqli_real_escape_string($connect, $_GET['mp']);
      date_default_timezone_set("Asia/Bangkok");
      $tgl = date('Y-m-d H:i:s');

      // Melakukan query untuk melakukan absensi
      $absensi = mysqli_query($connect, "INSERT INTO absensi (nis, tgl_absensi, kd_kelas, kd_mapel) VALUES ('$nis','$tgl','$kelas','$mapel')");
      if ($absensi) {
        echo "<script>alert('Berhasil absensi'); location='../../media.php?module=home'</script>";
      } else {
        echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
      }
      break;
  }
} else {
  echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
}
?>
