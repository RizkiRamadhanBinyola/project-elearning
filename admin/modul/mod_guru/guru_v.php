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

  $kode_guru_awal = ""; // Langkah 1: Inisialisasi variabel kode guru awal

  $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
  if ($update) {
    $sql = $connect->query("SELECT * FROM guru WHERE kd_guru='$_GET[key]'");
    $row = $sql->fetch_assoc();

    // Langkah 2: Isi $kode_guru_awal dengan kode guru yang akan diubah
    $kode_guru_awal = $row["kd_guru"];
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kd_guru = mysqli_real_escape_string($connect, $_POST['kd_guru']);
    $nip = mysqli_real_escape_string($connect, $_POST['nip']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $password2 = mysqli_real_escape_string($connect, $_POST['password2']);
    $username = strtolower(stripslashes($_POST['username']));
    $nama = htmlspecialchars($_POST['nama']);
    $telp = mysqli_real_escape_string($connect, $_POST['telp']);
    $email = htmlspecialchars($_POST['email']);
    $status = $_POST['status'];

    if ($update) {
      $sql = "UPDATE guru SET kd_guru='$kd_guru',username='$username', nip='$nip', nama='$nama', telp='$telp', email='$email', status='$status' WHERE kd_guru='$_GET[key]'";
    } else {
      $tg = date('Y-m-d H:i:s');
      $passwordHash = md5($_POST['password']);
      $sql = "INSERT INTO guru (kd_guru, username, password, nip, nama, telp, email, foto, status) VALUES ('$kd_guru', '$username', '$passwordHash', '$nip','$nama', '$telp', '$email', 'default.jpg', '$status')";

      
    }
    // Mengecek repeat password
    if ($password !== $password2) {
      echo "
          <script>
              alert('Konfirmasi Password Salah');
              document.location.href='media.php?module=guru';
          </script>
          ";
      return false;
    }

    if ($connect->query($sql)) {
      $passwordHash = md5($_POST['password']); // Meng-hash password
      $tg = date('Y-m-d H:i:s');
      echo "<script>alert('Berhasil'); window.location = 'media.php?module=guru'</script>";
      $connect->query("INSERT INTO login VALUES ('$username', '$passwordHash', 'guru', '$tg', 'aktif')");
    } else {
      echo "<script>alert('Gagal'); window.location = 'media.php?module=guru'</script>";
    }
    
  }
  if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $connect->query("DELETE FROM guru WHERE kd_guru='$_GET[key]'");
    echo "<script>alert('Berhasil'); window.location = 'media.php?module=guru'</script>";
  }
?>

  <div class="container mt-5">
    <div class="cotent-wrapper">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
              <?= ($update) ? "EDIT" : "TAMBAH" ?> GURU
            </div>
            <div class="card-body text-secondary">
              <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                  <label>Kode Guru</label>
                  <?php
                  $sql = "SELECT * FROM guru ORDER BY kd_guru DESC LIMIT 0,1";
                  $results = mysqli_query($connect, $sql) or die("Error: " . mysqli_error($connect));
                  $data = mysqli_fetch_array($results);

                  if (empty($data['kd_guru'])) {
                    // Jika kd_guru kosong, atur kode awal
                    $kd = 'GR001'; // Atur kode awal sesuai dengan kebutuhan Anda
                  } else {
                    $kodeawal = substr($data['kd_guru'], 3, 4) + 1;
                    if ($kodeawal < 10) {
                      $kd = 'GR00' . $kodeawal;
                    } elseif ($kodeawal > 9 && $kodeawal <= 99) {
                      $kd = 'GR0' . $kodeawal;
                    } else {
                      $kd = 'GR' . $kodeawal;
                    }
                  }

                  // Langkah 3: Gunakan $kode_guru_awal sebagai nilai awal pada inputan "Kode Guru"
                  if ($update) {
                    $kd = $kode_guru_awal;
                  }
                  ?>
                  <input class="form-control" value="<?php echo $kd; ?>" name="kd_guru" type="text" />
                </div>
                <div class="form-group mb-3">
                  <label>NIP</label>
                  <input class="form-control" placeholder="Masukkan NIP" name="nip" type="text" <?= (!$update) ?: 'value="' . $row["nip"] . '"' ?> />
                </div>
                <div class="form-group mb-3">
                  <label>Username</label>
                  <input class="form-control" placeholder="Masukkan Username" name="username" type="text" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?> />
                </div>
                <div class="form-group mb-3">
                  <label class="mx-2" for="floatingPassword">Password</label>
                  <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                </div>
                <div class="form-group mb-3">
                  <label class="mx-2" for="rfloatingPassword">Repeat Password</label>
                  <input type="password" name="password2" class="form-control" id="rfloatingPassword" placeholder="Repeat Password">
                </div>
                <div class="form-group mb-3">
                  <label>Nama Guru </label>
                  <input class="form-control" placeholder="Masukkan Nama Guru" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> />
                </div>
                <div class="form-group mb-3">
                  <label>Telepon </label>
                  <input class="form-control" placeholder="Masukkan Telepon" name="telp" type="text" <?= (!$update) ?: 'value="' . $row["telp"] . '"' ?> />
                </div>
                <div class="form-group mb-3">
                  <label>E-Mail </label>
                  <input class="form-control" placeholder="Masukkan E-Mail" name="email" type="text" <?= (!$update) ?: 'value="' . $row["email"] . '"' ?> />
                </div>
                <div class="form-group mb-3">
                  <label>Status </label>
                  <select class="form-control" name="status">
                    <option selected hidden>--Pilih Status--</option>
                    <?php 
                    $query5 = $connect->query("SELECT * FROM guru group by status");
                    while ($data5 = $query5->fetch_assoc()) : 
                    ?>
                      <?php if ($data5["status"] == 'Aktif') { ?>
                        <option value="Aktif" <?= (!$update) ?: (($data5["status"] != $data5["status"]) ?: 'selected="on"') ?>>Aktif</option>
                        <option value="NonAktif">NonAktif</option>
                      <?php } else { ?>
                        <option value="NonAktif" <?= (!$update) ?: (($data5["status"] != $data5["status"]) ?: 'selected="on"') ?>>NonAktif</option>
                        <option value="Aktif">Aktif</option>
                      <?php } ?>
                    <?php endwhile; ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                <?php if ($update) : ?>
                  <a href="media.php?module=guru" class="btn btn-info btn-block">Batal</a>
                <?php endif; ?>
              </form>

            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              TABEL GURU
            </div>
            <div class="card-body text-secondary">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>

                    <th>NIP</th>

                    <th>Nama</th>


                    <th>Telp</th>
                    <th>E-Mail</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php $no = 1; ?>
                    <?php if ($query = $connect->query("SELECT * FROM guru")) : ?>
                      <?php while ($row = $query->fetch_assoc()) : ?>
                        <td></td>
                        <td><?= $row['kd_guru'] ?></td>

                        <td><?= $row['nip'] ?></td>

                        <td><?= $row['nama'] ?></td>


                        <td><?= $row['telp'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['foto'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td class="hidden-print">
                          <div class="btn-group">
                            <a href="?module=guru&action=update&key=<?= $row['kd_guru'] ?>" class="btn btn-warning btn-xs">Edit</a>
                            <a href="?module=guru&action=delete&key=<?= $row['kd_guru'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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