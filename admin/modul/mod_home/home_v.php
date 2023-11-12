<!-- Penjelasan fungsi dari file home.php -->

<!-- CSS Style -->
<style type="text/css">
  /* Memberikan efek bayangan ketika mouse diarahkan ke elemen dengan class "well" */
  .well:hover {
    box-shadow: 0px 2px 10px rgb(190, 190, 190) !important;
  }

  /* Mengatur warna teks untuk semua elemen <a> menjadi abu-abu tua (#666) */
  a {
    color: #666;
  }
</style>
<!-- CSS/ -->

<?php
// Mengecek apakah user memiliki sesi login yang valid
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  // Jika tidak, memberikan pesan dan mengarahkan ke halaman login
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
  // Jika valid, melakukan query untuk mendapatkan data guru berdasarkan kode guru dari sesi
  $qguru = mysqli_query($connect, "SELECT * FROM guru WHERE kd_guru='$_SESSION[kode]'");
  $guru = mysqli_fetch_array($qguru);
  ?>

  <!-- HTML Content -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Bagian Header -->
      <div class="row pad-botm">
        <div class="col-md-12">
          <h4 class="header-line">selamat datang di dashboard administrator</h4>
        </div>
      </div>

      <!-- Bagian Data Rombel dan Mata Pelajaran -->
      <div class="row">
        <!-- Bagian Data Rombel -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3 card-info">
            <div class="card-header text-bg-secondary">
              DATA ROMBEL
            </div>
            <div class="card-body text-center recent-users-sec">
              <!-- Menampilkan informasi nama guru -->
              <div class="text-start">
                <h6>
                  Nama :
                  <?php echo $guru['nama'] ?>
                </h6>
              </div>
              <!-- Tabel untuk menampilkan mata pelajaran yang diajar oleh guru -->
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  // Query untuk mendapatkan mata pelajaran yang diajar oleh guru
                  $qget = mysqli_query($connect, "SELECT * FROM mapel,kelas,pengajaran WHERE pengajaran.kd_mapel=mapel.kd_mapel AND pengajaran.kd_kelas=kelas.kd_kelas AND pengajaran.kd_guru LIKE '%$guru[kd_guru]'");
                  while ($ajar = mysqli_fetch_array($qget)) {
                    echo "<tr>";
                    echo "<td> $i </td>
                        <td>$ajar[nama_mapel] - $ajar[nama_kelas]</td>";
                    echo "</tr>";
                    $i++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Bagian Data Kelas -->
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              Data Kelas
            </div>
            <div class="card-body text-secondary">
              <!-- Menampilkan daftar kelas dan mata pelajaran yang diajar oleh guru -->
              <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                // Query untuk mendapatkan data kelas dan mata pelajaran yang diajar oleh guru
                $qbacakurikulum = "SELECT kls.kd_kelas,kls.nama_kelas,m.nama_mapel,m.kd_mapel 
                FROM pengajaran as p, kelas as kls, mapel as m 
                WHERE kls.kd_kelas=p.kd_kelas AND m.kd_mapel=p.kd_mapel AND p.kd_guru LIKE '%$guru[kd_guru]'";
                $datakurikulum = mysqli_query($connect, $qbacakurikulum);
                while ($rkur = mysqli_fetch_array($datakurikulum)) {
                  ?>
                  <!-- Menampilkan informasi kelas dan mata pelajaran -->
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <h6>
                          <?= $rkur['nama_kelas'] ?> -
                          <?= $rkur['nama_mapel'] ?>
                        </h6>
                      </div>
                      <div class="card-body">
                        <!-- Tombol untuk menuju halaman materi, tugas, dan absensi -->
                        <p><a class='btn btn-xs btn-info form-control' href='?module=materi&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Materi </a></p>
                        <p><a class='btn btn-xs btn-info form-control' href='?module=tugas&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Tugas </a></p>
                        <p><a class='btn btn-xs btn-info form-control' href='?module=absensi&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Absensi </a></p>
                      </div>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Script JavaScript untuk menangani perubahan pada kotak pilihan -->
    <script>
      document.getElementById("cbbkls").addEventListener("change", function () {
        const selectedKelas = this.value;
        if (selectedKelas) {
          // Mengarahkan ke kelas yang dipilih
          window.location.href = `media.php?module=rombel&kls=${selectedKelas}`;
        } else {
          // Mengarahkan ke URL default
          window.location.href = 'rombel';
        }
      });
    </script>

    <?php
  }
  ?>