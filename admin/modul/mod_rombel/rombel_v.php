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
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {

  $qtajar = mysqli_query($connect, "SELECT * FROM tahun_ajar WHERE aktif='Y'");
  $r = mysqli_fetch_assoc($qtajar);
  $thn_ajar = $r['kd_tajar'];
  $tahun = $r['tahun_ajar'];
  $semester = $r['kd_semester'];
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
              <form>
                <div class="form-group mb-3">
                  <label>Kelas</label>
                  <select class="form-control" name="kd_kelas" id="cbbkls">
                    <option selected hidden>--Pilih Kelas--</option>
                    <?php $query3 = $connect->query("SELECT * FROM kelas ORDER BY tingkat");
                    while ($data3 = $query3->fetch_assoc()) : ?>
                      <option value="<?= $data3["kd_kelas"] ?>"><?= $data3["nama_kelas"] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Tahun Ajaran</label>
                  <input type="text" class="form-control" name="" value="<?= $thn_ajar; ?>" disabled="">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              <?php
              if (isset($_GET['kls'])) {
                echo "Kelas: " . $_GET['kls'];
              } else {
                echo "DATA ROMBEL";
              }
              ?> | Tahun Ajaran <?= $thn_ajar; ?>
            </div>
            <div class="card-body text-secondary">
              <div class="table-responsive">
                <?php
                $kd_kelas_selected = isset($_GET['kls']) ? $_GET['kls'] : '';
                $sql = "
                  SELECT * FROM rombel, kelas, tahun_ajar, siswa 
                  where rombel.kd_kelas=kelas.kd_kelas
                  and siswa.nis=rombel.nis
                  and rombel.kd_tajar=tahun_ajar.kd_tajar AND rombel.kd_tajar='$thn_ajar'
                  " . ($kd_kelas_selected ? "AND rombel.kd_kelas='$kd_kelas_selected'" : '');

                $jum = mysqli_num_rows(mysqli_query($connect, $sql));
                if ($jum == 0 && $kd_kelas_selected) {
                  $tingkat = mysqli_query($connect, "SELECT tingkat FROM kelas WHERE kd_kelas='$kd_kelas_selected'");
                  $dtkt = mysqli_fetch_assoc($tingkat);
                  echo "<hr>";
                }
                ?>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>NIS</th>
                      <th>Nama Siswa</th>
                      <th>Kelas</th>
                      <th>Tahun Ajaran</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($query = $connect->query($sql)) : ?>
                      <?php if ($query->num_rows == 0) {
                        echo "<tr><td colspan='5'>Data siswa belum ditambahkan ke rombel.</td></tr>";
                      } else {
                        $no = 1;
                        while ($row = $query->fetch_assoc()) : ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td><?= $row['kd_tajar'] ?></td>
                          </tr>
                    <?php endwhile;
                      }
                    endif;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // JavaScript to handle the select box change
    document.getElementById("cbbkls").addEventListener("change", function() {
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
