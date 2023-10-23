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

  $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
  if ($update) {
    $sql = $connect->query("SELECT * FROM rombel WHERE nis='$_GET[key]'");
    $row = $sql->fetch_assoc();
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($update) {
      $sql = "UPDATE rombel SET kd_kelas='$_POST[kd_kelas]',kd_tajar='$_POST[kd_tajar]' WHERE nis='$_GET[key]'";
    } else {
      $sql = "INSERT INTO rombel VALUES ('$_POST[nis]', '$_POST[kd_kelas]', '$_POST[kd_tajar]')";
    }
    if ($connect->query($sql)) {
      echo "<script>alert('Berhasil'); window.location = 'media.php?module=rombel&kls=$_POST[kd_kelas]'</script>";
    } else {
      echo "<script>alert('Gagal'); window.location = 'media.php?module=rombel&kls=$_POST[kd_kelas]'</script>";
    }
  }
  if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connect->query("DELETE FROM rombel WHERE nis='$_GET[key]' AND kd_kelas='$_GET[kd_kelas]' AND kd_tajar='$thn_ajar'");
    echo "<script>alert('Berhasil'); window.location = 'media.php?module=rombel&kls=$_GET[kd_kelas]'</script>";
  }
?>

  <div class="content-wrapper">
    <div class="container mt-5">
      <div class="row pad-botm">

      </div>
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3 card-<?= ($update) ? "warning" : "info" ?>">
            <div class="card-header text-bg-secondary">
              <?= ($update) ? "EDIT" : "TAMBAH" ?> ROMBEL
            </div>
            <div class="card-body  text-center recent-users-sec">
              <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" role="form">

                <div class="form-group mb-3">
                  <label>Siswa</label>
                  <select class="form-control" name="nis">
                    <option selected hidden>--Pilih Siswa--</option>
                    <?php
                    $siswaQuery = $connect->query("SELECT * FROM siswa");
                    while ($siswaData = $siswaQuery->fetch_assoc()) {
                      $nis = $siswaData["nis"];
                      $nama = $siswaData["nama"];

                      // Cek apakah siswa sedang diedit
                      $isDisabled = false;
                      if ($update && $nis == $row["nis"]) {
                        $isDisabled = true;
                      }

                      // Cek apakah siswa sudah diinputkan ke dalam rombel
                      $rombelCheck = $connect->query("SELECT * FROM rombel WHERE nis = '$nis' AND kd_tajar = '$thn_ajar'");
                      if ($rombelCheck->num_rows > 0) {
                        $isDisabled = true;
                      }

                      echo '<option value="' . $nis . '" ' . ($isDisabled ? 'disabled' : '') . ' ' . ($update && $nis == $row["nis"] ? 'selected' : '') . '>' . $nis . ' - ' . $nama . '</option>';
                    }
                    ?>
                  </select>
                </div>




                <div class="form-group mb-3">
                  <label>Kelas </label>
                  <select class="form-control" name="kd_kelas" id="cbbkls">
                    <option selected hidden>--Pilih Kelas--</option>
                    <?php $query3 = $connect->query("SELECT * FROM kelas ORDER BY tingkat");
                    while ($data3 = $query3->fetch_assoc()) : ?>
                      <option value="<?= $data3["kd_kelas"] ?>" <?= (!$update) ? (!isset($_GET['kls']) ?: ($data3["kd_kelas"] != $_GET['kls'] ?: 'selected=""'))  : (($data3["kd_kelas"] != $data3["kd_kelas"]) ?: 'selected="on"') ?>><?= $data3["nama_kelas"] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Tahun Ajaran</label>
                  <input type="text" class="form-control" name="" value="<?= $thn_ajar; ?>" disabled="">
                  <input type="hidden" class="form-control" name="kd_tajar" value="<?= $thn_ajar; ?>">
                </div>




                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                <?php if ($update) : ?>
                  <a href="?module=rombel" class="btn btn-info btn-block">Batal</a>
                <?php endif; ?>


              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="panel panel-success">
            <div class="panel-body">
              <div class="table-responsive">
                <div class="card border-secondary mb-3">
                  <div class="card-header text-bg-secondary">
                    <?php
                    $sql = "SELECT * FROM rombel,kelas,tahun_ajar,siswa 
                    where rombel.kd_kelas=kelas.kd_kelas
                    and siswa.nis=rombel.nis
                    and rombel.kd_tajar=tahun_ajar.kd_tajar AND rombel.kd_tajar='$thn_ajar'";
            
                    echo isset($_GET['kls']) ? ("Kelas: " . $_GET['kls']) : "ROMBEL";
                    ?> | Tahun Ajaran <?= $thn_ajar; ?>
                  </div>
                  <div class="card-body text-secondary">
                    <!-- Table 2 -->
                    <table id="datatablesSimple">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>NIS</th>
                          <th>Nama Siswa</th>
                          <th>Kelas</th>
                          <th>Tahun Ajaran</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($query = $connect->query($sql)) : ?>
                          <?php while ($row = $query->fetch_assoc()) : ?>
                            <tr>
                              <td></td>
                              <td><?= $row['nis'] ?></td>
                              <td><?= $row['nama'] ?></td>
                              <td><?= $row['nama_kelas'] ?></td>
                              <td><?= $row['kd_tajar'] ?></td>
                              <td class="hidden-print">
                                <div class="btn-group">
                                  <a href="?module=rombel&action=update&key=<?= $row['nis'] ?>" class="btn btn-warning btn-xs">Edit</a>
                                  <a href="?module=rombel&action=delete&key=<?= $row['nis'] ?>&kd_kelas=<?= $row['kd_kelas'] ?>" class="btn btn-danger btn-xs">Hapus</a>
                                </div>
                              </td>
                            </tr>
                          <?php endwhile ?>
                        <?php endif ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>

  </div>

<?php } ?>