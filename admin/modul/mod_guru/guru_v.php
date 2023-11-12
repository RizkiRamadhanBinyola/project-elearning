<!-- CSS -->

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
include "../koneksi/koneksi.php";

// Cek apakah user memiliki sesi login yang valid
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    echo "<script>alert('Kembalilah Kejalan yang benar!!!'); window.location = '../../index.php';</script>";
} else {
    // Variabel awal untuk kode guru
    $kode_guru_awal = "";

    // Cek apakah mode update aktif
    $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
    if ($update) {
        // Jika mode update aktif, ambil data guru yang akan diupdate
        $sql = $connect->query("SELECT * FROM guru WHERE kd_guru='$_GET[key]'");
        $row = $sql->fetch_assoc();
        $kode_guru_awal = $row["kd_guru"];
    }

    // Cek apakah form dikirim
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $kd_guru = mysqli_real_escape_string($connect, $_POST['kd_guru']);
        $nip = mysqli_real_escape_string($connect, $_POST['nip']);
        $username = strtolower(stripslashes($_POST['username']));
        $nama = htmlspecialchars($_POST['nama']);
        $telp = mysqli_real_escape_string($connect, $_POST['telp']);
        $email = htmlspecialchars($_POST['email']);
        $status = $_POST['status'];

        // Validasi kolom yang harus diisi
        if (empty($kd_guru) || empty($nip) || empty($username) || empty($nama) || empty($telp) || empty($email) || empty($status)) {
            echo "<script>alert('Form tidak boleh kosong'); window.location.href='media.php?module=guru';</script>";
            exit; // Hentikan eksekusi jika ada kolom yang harus diisi yang kosong
        }

        // Hash NIP menggunakan MD5 untuk kolom nip_password
        $hashedNIP = $nip ? md5($nip) : $row['nip_password'];

        // Query SQL untuk update atau insert data guru
        if ($update) {
            $sql = "UPDATE guru SET kd_guru='$kd_guru', username='$username', nip_password='$hashedNIP', nip='$nip', nama='$nama', telp='$telp', email='$email', status='$status' WHERE kd_guru='$_GET[key]'";
        } else {
            $tg = date('Y-m-d H:i:s');
            $sql = "INSERT INTO guru (kd_guru, username, nip_password, nip, nama, telp, email, foto, status) VALUES ('$kd_guru', '$username', '$hashedNIP', '$nip', '$nama', '$telp', '$email', 'default.jpg', '$status')";
        }

        // Jalankan query SQL
        if ($connect->query($sql)) {
            $tg = date('Y-m-d H:i:s');
            echo "<script>alert('Berhasil'); window.location = 'media.php?module=guru'</script>";
            $connect->query("INSERT INTO login VALUES ('$username', MD5('$nip'), 'guru', '$tg', 'aktif')");
        } else {
            echo "<script>alert('Gagal'); window.location = 'media.php?module=guru'</script>";
        }
    }

    // Cek apakah mode delete aktif
    if (isset($_GET['action']) and $_GET['action'] == 'delete') {
        // Jika mode delete aktif, hapus data guru yang dipilih
        $connect->query("DELETE FROM guru WHERE kd_guru='$_GET[key]'");
        echo "<script>alert('Berhasil'); window.location = 'media.php?module=guru'</script>";
    }
?>

<!-- HTML -->
<div class="container mt-5">
  <div class="cotent-wrapper">
    <div class="row">
      <!-- Form Guru -->
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="card border-secondary mb-3">
          <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
            <?= ($update) ? "EDIT" : "TAMBAH" ?> GURU
          </div>
          <div class="card-body text-secondary">
            <!-- Form untuk mengisi atau mengedit data guru -->
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
              <!-- Input untuk Kode Guru -->
              <div class="form-group mb-3">
                <label>Kode Guru</label>
                <?php
                  // Langkah 3: Gunakan $kode_guru_awal sebagai nilai awal pada inputan "Kode Guru"
                  if ($update) {
                    $kd = $kode_guru_awal;
                  }
                ?>
                <input class="form-control" value="<?php echo $kd; ?>" name="kd_guru" type="text" />
              </div>
              <!-- Input untuk NIP -->
              <div class="form-group mb-3">
                <label>NIP</label>
                <input class="form-control" placeholder="Masukkan NIP" name="nip" type="text" <?= (!$update) ?: 'value="' . $row["nip"] . '"' ?> />
              </div>
              <!-- Input untuk Username -->
              <div class="form-group mb-3">
                <label>Username</label>
                <input class="form-control" placeholder="Masukkan Username" name="username" type="text" <?= (!$update) ?: 'value="' . $row["username"] . '"' ?> />
              </div>
              <!-- Input untuk Nama Guru -->
              <div class="form-group mb-3">
                <label>Nama Guru</label>
                <input class="form-control" placeholder="Masukkan Nama Guru" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> />
              </div>
              <!-- Input untuk Telepon -->
              <div class="form-group mb-3">
                <label>Telepon</label>
                <input class="form-control" placeholder="Masukkan Telepon" name="telp" type="text" <?= (!$update) ?: 'value="' . $row["telp"] . '"' ?> />
              </div>
              <!-- Input untuk E-Mail -->
              <div class="form-group mb-3">
                <label>E-Mail</label>
                <input class="form-control" placeholder="Masukkan E-Mail" name="email" type="text" <?= (!$update) ?: 'value="' . $row["email"] . '"' ?> />
              </div>
              <!-- Input untuk Status -->
              <div class="form-group mb-3">
                <label>Status</label>
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
              <!-- Tombol Simpan -->
              <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
              <!-- Tombol Batal (hanya muncul jika mode update aktif) -->
              <?php if ($update) : ?>
                <a href="media.php?module=guru" class="btn btn-info btn-block">Batal</a>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>

      <!-- Tabel Guru -->
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="card border-secondary mb-3">
          <div class="card-header text-bg-secondary">
            TABEL GURU
          </div>
          <div class="card-body text-secondary">
            <!-- Tabel untuk menampilkan data guru -->
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
                      <!-- Menampilkan data guru dalam setiap baris tabel -->
                      <td></td>
                      <td><?= $row['kd_guru'] ?></td>
                      <td><?= $row['nip'] ?></td>
                      <td><?= $row['nama'] ?></td>
                      <td><?= $row['telp'] ?></td>
                      <td><?= $row['email'] ?></td>
                      <td><?= $row['foto'] ?></td>
                      <td><?= $row['status'] ?></td>
                      <td class="hidden-print">
                        <!-- Tombol aksi untuk mengedit atau menghapus data guru -->
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
