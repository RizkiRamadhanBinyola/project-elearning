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

?>

  <div class="container mt-5">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              MANAJEMEN PENGAJAR
            </div>
            <div class="card-body text-secondary">
              <form action="modul/mod_pengajaran/aksi.php?act=add" method="POST" role="form">

                <div class="form-group mb-3">
                  <label> Mata Pelajaran</label>
                  <select class="form-control" name="kd_mapel" id="cbbmapelajar">
                    <option selected hidden>Pilih Matapelajaran</option>
                    <?php if ($query = $connect->query("SELECT * FROM mapel ORDER BY nama_mapel")) : ?>
                      <?php while ($row = $query->fetch_assoc()) : ?>
                        <option value="<?php echo $row['kd_mapel']; ?>"><?php echo $row['nama_mapel']; ?></option>
                      <?php endwhile ?>
                    <?php endif ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label> Jurusan </label>
                  <select class="form-control" name="kd_jurusan" id="cbbjurusan" data-mapel="">
                    <option selected hidden>Pilih Jurusan</option>
                    <?php if ($query = $connect->query("SELECT * FROM jurusan ORDER BY nama_jurusan")) : ?>
                      <?php while ($row = $query->fetch_assoc()) : ?>
                        <option value="<?php echo $row['kd_jurusan']; ?>"><?php echo $row['nama_jurusan']; ?></option>
                      <?php endwhile ?>
                    <?php endif ?>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <label>Kelas </label>
                  <select class="form-control" name="kd_kls[]" id="cbbkelas" data-kelas="">
                    <option selected hidden>Pilih Kelas</option>
                    <?php if ($query = $connect->query("SELECT * FROM kelas ORDER BY kd_kelas")) : ?>
                    <?php while ($row = $query->fetch_assoc()) : ?>
                        <option value="<?php echo $row['kd_kelas']; ?>"><?= $row['nama_kelas'] ?></option>
                    <?php endwhile ?>
                    <?php endif ?>
                  </select>
                  
                </div>
                <div class="form-group mb-3">
                  <label>Guru </label>
                  <select class="form-control" name="kd_guru">
                    <option selected hidden>Pilih Guru Pengajar</option>
                    <?php
                    $query = mysqli_query($connect, "SELECT kd_guru,nama FROM guru WHERE status='Aktif' ORDER BY nama");
                    $c = mysqli_num_rows($query);
                    if ($c > 0) {
                      while ($rsl = mysqli_fetch_array($query)) {
                        echo "<option value='$rsl[kd_guru]'>$rsl[nama]</option>";
                      }
                    }
                    ?>
                  </select>
                </div>

                <input type="submit" name="submit" value="Tambah" class="btn btn-info">

              </form>
            </div>
          </div>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              TABEL PENGAJAR
            </div>
            <div class="card-body text-secondary">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Guru</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  function namaGuru($con, $kd)
                  {
                    $query = mysqli_query($con, "SELECT nama FROM guru WHERE kd_guru='$kd'");
                    $guru = mysqli_fetch_array($query);
                    return $guru['nama'];
                  }
                  $fkelas = "";
                  if (isset($_GET['fkelas'])) {
                    if ($_GET['fkelas'] == 'all') {
                      $fkelas = "";
                    } else {
                      $fkelas = " AND pengajaran.kd_kelas='$_GET[fkelas]' ";
                    }
                  }
                  $no = 1;
                  if ($query = $connect->query("SELECT * FROM pengajaran,mapel,kelas where pengajaran.kd_mapel=mapel.kd_mapel AND pengajaran.kd_kelas=kelas.kd_kelas " . $fkelas . " ORDER BY pengajaran.kd_kelas")) : ?>
                    <?php while ($row = $query->fetch_assoc()) : ?>
                      <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['nama_mapel'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?php
                            $kd_guru = explode(",", $row['kd_guru']);
                            $j = 1;
                            foreach ($kd_guru as $kd) {
                              echo $j == 2 ? "<br>" : " ";
                              echo namaGuru($connect, $kd) . " 
                              </td>
                              <td>
                                <div class='hidden-print'>
                                  <div class='btn-group'>
                                  <a href='modul/mod_pengajaran/aksi.php?act=del&kd=$row[kd_pengajaran]&kdg=$kd' class='btn btn-danger btn-xs'>Hapus</a>
                              ";
                              $j++;
                            }
                            ?>
                                    <a href="?module=pengajaran&eid=<?php echo $row['kd_pengajaran'] ?>" class="btn btn-warning btn-xs">Edit</a>
                                </div>
                              </div>
                          </td>

                      </tr>
                    <?php $no++;
                    endwhile ?>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>