<?php
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {

?>

  <?php
  $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
  if ($update) {
    $sql = $connect->query("SELECT * FROM kelas WHERE kd_kelas='$_GET[key]'");
    $row = $sql->fetch_assoc();
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tingkat = isset($_POST['tingkat']) ? mysqli_real_escape_string($connect, $_POST['tingkat']) : '';
    $kd_jurusan = isset($_POST['kd_jurusan']) ? mysqli_real_escape_string($connect, $_POST['kd_jurusan']) : '';
    $kd_kelas = isset($_POST['kd_kelas']) ? mysqli_real_escape_string($connect, $_POST['kd_kelas']) : '';
    $nama_kelas = isset($_POST['nama_kelas']) ? htmlspecialchars($_POST['nama_kelas']) : '';

    // Cek apakah input kosong
    if (empty($tingkat) || empty($kd_jurusan) || empty($kd_kelas) || empty($nama_kelas)) {
      echo "
      <script>
          alert('Form tidak boleh kosong');
          window.location.href='media.php?module=kelas';
      </script>
    ";
      exit; // Hentikan eksekusi jika input kosong
    }

    if ($update) {
      $sql = "UPDATE kelas SET nama_kelas='$nama_kelas', tingkat='$tingkat', kd_jurusan='$kd_jurusan' WHERE kd_kelas='$_GET[key]'";
    } else {
      $sql = "INSERT INTO kelas VALUES ('$kd_kelas', '$nama_kelas', '$tingkat', '$kd_jurusan')";
    }
    if ($connect->query($sql)) {
      echo "<script>alert('Berhasil'); window.location = 'media.php?module=kelas'</script>";
    } else {
      echo "<script>alert('Gagal'); window.location = 'media.php?module=kelas'</script>";
    }
  }
  if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connect->query("DELETE FROM kelas WHERE kd_kelas='$_GET[key]'");
    echo "<script>alert('Berhasil'); window.location = 'media.php?module=kelas'</script>";
  }
  ?>

  <div class="container mt-5">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
              <?= ($update) ? "EDIT" : "TAMBAH" ?> KELAS
            </div>
            <div class="card-body text-secondary">
              <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" role="form">

                <div class="form-group mb-3">
                  <label>Tingkat </label>
                  <select class="form-control" name="tingkat">
                    <option selected hidden disabled>--Pilih Tingkat--</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>


                </div>

                <div class="form-group mb-3">
                  <label>Jurusan </label>
                  <select class="form-control" name="kd_jurusan">
                    <option selected hidden disabled>--Pilih Jurusan--</option>
                    <?php $query = $connect->query("SELECT * FROM jurusan");
                    while ($data = $query->fetch_assoc()) : ?>
                      <option value="<?= $data["kd_jurusan"] ?>" <?= (!$update) ?: (($row["kd_jurusan"] != $data["kd_jurusan"]) ?: 'selected="on"') ?>><?= $data["nama_jurusan"] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <label>Kode Kelas</label>
                  <input class="form-control" placeholder="Masukkan Kode Kelas" name="kd_kelas" type="text" <?= (!$update) ?: 'value="' . $row["kd_kelas"] . '"' ?> />
                </div>


                <div class="form-group mb-3">
                  <label>Nama Kelas </label>
                  <input class="form-control" placeholder="Masukkan Nama Kelas" name="nama_kelas" type="text" <?= (!$update) ?: 'value="' . $row["nama_kelas"] . '"' ?> />
                </div>


                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                <?php if ($update) : ?>
                  <a href="?module=akun" class="btn btn-info btn-block">Batal</a>
                <?php endif; ?>


              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              TABEL MATA PELAJARAN

            </div>
            <div class="card-body text-secondary">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Kelas</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php if ($query = $connect->query("SELECT * FROM kelas,jurusan where kelas.kd_jurusan=jurusan.kd_jurusan")) : ?>
                    <?php while ($row = $query->fetch_assoc()) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kd_kelas'] ?> <br><a href="?module=rombel&kls=<?= $row['kd_kelas'] ?>" class="btn btn-xs btn-info">Lihat</a> </td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['tingkat'] ?></td>
                        <td><?= $row['nama_jurusan'] ?></td>
                        <td class="hidden-print">
                          <div class="btn-group">
                            <a href="?module=kelas&action=update&key=<?= $row['kd_kelas'] ?>" class="btn btn-warning btn-xs">Edit</a>
                            <a href="?module=kelas&action=delete&key=<?= $row['kd_kelas'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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

<?php } ?>