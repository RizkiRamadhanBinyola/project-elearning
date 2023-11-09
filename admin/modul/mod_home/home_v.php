<!-- CSS -->
<style type="text/css">
  .well:hover {
    box-shadow: 0px 2px 10px rgb(190, 190, 190) !important;
  }

  a {
    color: #666;
  }
</style>
<!-- CSS/ -->

<?php
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
  $qguru = mysqli_query($connect, "SELECT * FROM guru WHERE kd_guru='$_SESSION[kode]'");
  $guru = mysqli_fetch_array($qguru);
  ?>

  <div class="content-wrapper">
    <div class="container">
      <div class="row pad-botm">
        <div class="col-md-12">
          <h4 class="header-line">SELAMAT DATANG DI DASHBOARD ADMINISTRATOR</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3 card-info">
            <div class="card-header text-bg-secondary">
              DATA ROMBEL
            </div>
            <div class="card-body text-center recent-users-sec">
              <div class="text-start">
              <p>
                Nama : <?php echo $guru['nama'] ?>
              </p>
              <p> Password : <?php echo $guru['nip'] ?> </p>
              </div>
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
                  $qget = mysqli_query($connect, "SELECT * FROM mapel,kelas,pengajaran WHERE pengajaran.kd_mapel=mapel.kd_mapel AND pengajaran.kd_kelas=kelas.kd_kelas AND pengajaran.kd_guru LIKE '%$guru[kd_guru]%'");
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
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              Data Kelas
            </div>
            <div class="card-body text-secondary">
              <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $qbacakurikulum = "SELECT kls.kd_kelas,kls.nama_kelas,m.nama_mapel,m.kd_mapel 
                FROM pengajaran as p, kelas as kls, mapel as m 
                WHERE kls.kd_kelas=p.kd_kelas AND m.kd_mapel=p.kd_mapel AND p.kd_guru LIKE '%$guru[kd_guru]%'";

                $datakurikulum = mysqli_query($connect, $qbacakurikulum);
                while ($rkur = mysqli_fetch_array($datakurikulum)) {
                  ?>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <h6><?= $rkur['nama_kelas'] ?> - <?= $rkur['nama_mapel'] ?></h6>
                      </div>
                      <div class="card-body">
                        <p><a class='btn btn-xs btn-info form-control'
                            href='?module=materi&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Materi </a></p>
                        <p><a class='btn btn-xs btn-info form-control'
                            href='?module=tugas&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Tugas </a></p>
                        <p><a class='btn btn-xs btn-info form-control'
                            href='?module=ujian&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Ujian </a></p>
                        <p><a class='btn btn-xs btn-info form-control'
                            href='?module=absensi&mp=<?= $rkur['kd_mapel'] ?>&kls=<?= $rkur['kd_kelas'] ?>'> Absensi </a></p>
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

    <script>
      // JavaScript to handle the select box change
      document.getElementById("cbbkls").addEventListener("change", function () {
        const selectedKelas = this.value;
        if (selectedKelas) {
          // Redirect to the selected class
          window.location.href = `media.php?module=rombel&kls=${selectedKelas}`;
        } else {
          // Redirect to the default URL
          window.location.href = 'rombel';
        }
      });
    </script>

    <?php
}
?>