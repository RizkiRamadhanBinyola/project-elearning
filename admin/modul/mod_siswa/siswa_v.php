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

  <?php
  $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
  if ($update) {
    $sql = $connect->query("SELECT * FROM siswa,login WHERE siswa.username=login.username and siswa.nis='$_GET[key]'");
    $row = $sql->fetch_assoc();
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nisn = mysqli_real_escape_string($connect, $_POST['nisn']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $kelamin = $_POST['kelamin'];
    $email = htmlspecialchars($_POST['email']);
    $telp = mysqli_real_escape_string($connect, $_POST['telp']);
    $status = $_POST['status'];

    // Cek apakah input kosong
    if (empty($nisn) || empty($nama) || empty($username) || empty($kelamin) || empty($email) || empty($telp) || empty($status)) {
      echo "
      <script>
          alert('Form tidak boleh kosong');
          window.location.href='media.php?module=siswa';
      </script>
    ";
      exit; // Hentikan eksekusi jika input kosong
    }

    if ($update) {
      $sql = "UPDATE siswa SET nisn='$nisn', nama='$nama', username='$username', kelamin='$kelamin', email='$email', telp='$telp', status='$status' WHERE nis='$_GET[key]'";
    } else {
      $nis = mysqli_real_escape_string($connect, $_POST['nis']);
      $password = md5($nis);
      $tg = date('Y-m-d H:i:s');
      echo "<script>alert('Berhasil!'); window.location = 'media.php?module=siswa'</script>";

      $connect->query("INSERT INTO login VALUES ('$nis', '$password', 'siswa', '$tg', 'aktif')");
      $connect->query("INSERT INTO rombel VALUES ('$nis', '$_POST[kd_kelas]', '$_POST[kd_tajar]')");
    }

    if ($connect->query($sql)) {
      if ($update) {
        $sql = "UPDATE login SET password='$_POST[password]' WHERE username='$_POST[username]'";
      } else {
        $password = md5($_POST['nis']);
        $tg = date('Y-m-d H:i:s');
        echo "<script>alert('Berhasil!'); window.location = 'media.php?module=siswa'</script>";

        $connect->query("INSERT INTO login VALUES ('$_POST[nis]', '$password', 'siswa', '$tg', 'aktif')");
        $connect->query("INSERT INTO rombel VALUES ('$_POST[nis]', '$_POST[kd_kelas]', '$_POST[kd_tajar]')");
      }
    } else {
      echo "<script>alert('Gagal!'); window.location = 'media.php?module=siswa'</script>";
    }
  }
  if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connect->query("DELETE FROM siswa WHERE nis='$_GET[key]'");
    echo "<script>alert('Berhasil!'); window.location = 'media.php?module=siswa'</script>";
  }
  ?>


  <div class="container mt-5">
    <div class="content-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="card border-secondary mb-3">

              <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
                <?= ($update) ? "EDIT" : "TAMBAH" ?> MATA PELAJARAN
              </div>
              <div class="card-body text-secondary">
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">

                  <div class="form-group mb-3">
                    <label>NIS</label>
                    <input class="form-control" placeholder="Masukkan NIS" name="nis" type="text" <?= (!$update) ?: 'value="' . $row["nis"] . '"' ?> />
                  </div>
                  <div class="form-group mb-3">
                    <label>NISN</label>
                    <input class="form-control" placeholder="Masukkan NISN" name="nisn" type="text" <?= (!$update) ?: 'value="' . $row["nisn"] . '"' ?> />
                  </div>


                  <div class="form-group mb-3">
                    <label>Nama Siswa </label>
                    <input class="form-control" placeholder="Masukkan Nama Siswa" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> />
                  </div>
                  <div class="form-group mb-3">
                    <label>Username </label>
                    <input class="form-control" placeholder="Masukkan Username" name="username" type="text" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?> />
                  </div>
                  <div class="form-group mb-3">
                    <label>Password </label>
                    <input class="form-control" placeholder="Masukkan Password" name="password" type="text" <?= (!$update) ?: 'value="' . $row["password"] . '"' ?> />
                  </div>

                  <div class="form-group mb-3">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="kelamin">
                      <option>--Pilih Jenis Kelamin--</option>
                      <option value="L">--Laki - Laki--</option>
                      <option value="P">--Perempuan--</option>



                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label>E-Mail</label>
                    <input class="form-control" placeholder="Masukkan E-Mail" name="email" type="text" <?= (!$update) ?: 'value="' . $row["email"] . '"' ?> />
                  </div>

                  <div class="form-group mb-3">
                    <label>Tlp</label>
                    <input class="form-control" placeholder="Masukkan Telepon" name="telp" type="text" <?= (!$update) ?: 'value="' . $row["telp"] . '"' ?> />
                  </div>
                  <div class="form-group mb-3">
                    <label>Status </label>
                    <select class="form-control" name="status">
                      <option>--Pilih Status--</option>
                      <option value="Aktif">--Aktif--</option>
                      <option value="NonAktif">--Non Aktif--</option>


                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label>Kelas </label>
                    <select class="form-control" name="kd_kelas">
                      <option>--Pilih Kelas--</option>
                      <?php $query3 = $connect->query("SELECT * FROM kelas");
                      while ($data3 = $query3->fetch_assoc()) : ?>
                        <option value="<?= $data3["kd_kelas"] ?>" <?= (!$update) ?: (($data3["kd_kelas"] != $data3["kd_kelas"]) ?: 'selected="on"') ?>><?= $data3["nama_kelas"] ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label>Tahun Ajaran</label>
                    <select class="form-control" name="kd_tajar">
                      <option>--Pilih Tahun Ajaran--</option>
                      <?php $query5 = $connect->query("SELECT * FROM tahun_ajar");
                      while ($data5 = $query5->fetch_assoc()) : ?>
                        <option value="<?= $data5["kd_tajar"] ?>" <?= (!$update) ?: (($data5["kd_tajar"] != $data5["kd_tajar"]) ?: 'selected="on"') ?>><?= $data5["tahun_ajar"] ?></option>
                      <?php endwhile; ?>
                    </select>
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
                      <th>NIS</th>
                      <th>NISN</th>
                      <th>Nama Siswa</th>
                      <th>Username</th>
                      <th>Jenis Kelamin</th>

                      <th>E-mail</th>
                      <th>Foto</th>
                      <th>Telp</th>
                      <th>Status</th>

                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php $no = 1; ?>
                      <?php if ($query = $connect->query("SELECT * FROM siswa")) : ?>
                        <?php while ($row = $query->fetch_assoc()) : ?>
                          <td><?= $no++;?></td>
                          <td><?= $row['nis'] ?></td>
                          <td><?= $row['nisn'] ?></td>
                          <td><?= $row['nama'] ?></td>
                          <td><?= $row['username'] ?></td>

                          <td><?= $row['kelamin'] ?></td>

                          <td><?= $row['email'] ?></td>
                          <td><?= $row['foto'] ?></td>
                          <td><?= $row['telp'] ?></td>
                          <td><?= $row['status'] ?></td>
                          <td class="hidden-print">
                            <div class="btn-group">
                              <a href="?module=siswa&action=update&key=<?= $row['nis'] ?>" class="btn btn-warning btn-xs">Edit</a>
                              <a href="?module=siswa&action=delete&key=<?= $row['nis'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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

<?php } ?>