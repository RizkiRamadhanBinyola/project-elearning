<?php
// Memeriksa apakah parameter 'mp' telah diatur dalam URL ($_GET)
if (isset($_GET['mp'])) {
  // Jika 'mp' diatur, mengambil nilainya
  $mapel = $_GET['mp'];
} else {
  // Jika 'mp' tidak diatur, mengarahkan ke halaman tugas dengan mata pelajaran 'all'
  header("location:?module=tugas&mp=all");
  // Mengatur nilai $mapel menjadi 'all'
  $mapel = 'all';
}
?>

<!-- Bagian HTML untuk filter mata pelajaran -->
<div class="container mt-5">
  <div class="row">
    <!-- Kolom untuk filter mata pelajaran -->
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="card border-secondary mb-3">
        <!-- Judul card -->
        <div class="card-header text-bg-secondary">
          Tugas Untuk Kelas
          <?php echo $nama_kelas; ?>
        </div>
        <div class="card-body">
          <!-- Tombol untuk menampilkan semua tugas -->
          <a href="?module=tugas&mp=all" class="btn <?php echo $_GET['mp'] == 'all' ? "btn-light" : "btn-primary"; ?> btn-sm form-control mb-1">Semua</a>

          <?php
          // Query untuk mendapatkan daftar mata pelajaran
          $qmapel = mysqli_query($connect, "SELECT mapel.kd_mapel, mapel.nama_mapel 
        FROM mapel, pengajaran as p
        WHERE p.kd_mapel=mapel.kd_mapel AND p.kd_kelas='$kode_kelas'");
          while ($rmp = mysqli_fetch_array($qmapel)) {
            // Menentukan class tombol berdasarkan kondisi
            $mapel == $rmp['kd_mapel'] ? $cbtn = "btn-light" : $cbtn = "btn-primary";
            // Menampilkan tombol untuk setiap mata pelajaran
            echo "<a href='?module=tugas&mp=$rmp[kd_mapel]' class='btn $cbtn btn-sm form-control mb-1'>$rmp[nama_mapel]</a>  ";
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Kolom untuk menampilkan daftar tugas -->
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="card border-secondary mb-3 ">
        <!-- Judul card -->
        <div class="card-header text-bg-secondary">
          DAFTAR TUGAS
        </div>
        <div class="card-body">
          <!-- Tabel untuk menampilkan daftar tugas -->
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>Materi </th>
                <th>Mata Pelajaran </th>
                <th>Guru Pengampu </th>
                <th>File </th>
                <th>Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Query untuk mendapatkan daftar tugas berdasarkan mata pelajaran
              if ($mapel == 'all') {
                $qmat = "SELECT tugas.nama_tugas, tugas.file, tugas.tgl_up, mapel.nama_mapel, tugas.kd_tugas, kelas.nama_kelas , guru.nama
            FROM tugas, pengajaran as p, mapel, kelas, guru 
            WHERE p.kd_mapel=tugas.kd_mapel AND tugas.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=tugas.kd_kelas AND kelas.kd_kelas=p.kd_kelas AND tugas.kd_guru=p.kd_guru AND guru.kd_guru=p.kd_guru AND tugas.kd_kelas='$kode_kelas'";
              } else {
                $qmat = "SELECT tugas.nama_tugas, tugas.file, tugas.tgl_up, mapel.nama_mapel, tugas.kd_tugas, kelas.nama_kelas , guru.nama
            FROM tugas, pengajaran as p, mapel, kelas, guru 
            WHERE p.kd_mapel=tugas.kd_mapel AND tugas.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=tugas.kd_kelas AND kelas.kd_kelas=p.kd_kelas AND tugas.kd_guru=p.kd_guru AND guru.kd_guru=p.kd_guru AND tugas.kd_kelas='$kode_kelas' AND tugas.kd_mapel='$mapel'";
              }

              // Eksekusi query dan menampilkan hasilnya
              $mat = mysqli_query($connect, $qmat);
              while ($rmat = mysqli_fetch_array($mat)) {
                echo "<tr class='odd gradeX'>
              <td>$rmat[nama_tugas]</td>
              <td>$rmat[nama_mapel]</td>
              <td>$rmat[nama]</td>";

                echo "<td class='center'>$rmat[file]</td>
              <td class='center'><a class='btn btn-info btn-xs' href='?module=detailtugas&kd=$rmat[kd_tugas]'>Buka Tugas</a></td>";

                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
