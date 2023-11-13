<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../koneksi/koneksi.php";

// Cek apakah session username, passuser, dan login sudah di-set
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  // Jika tidak, redirect ke halaman login
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
  // Mengecek apakah parameter 'action' di-set dan memiliki nilai 'update'
  $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;

  // Jika parameter 'update' di-set, ambil data siswa berdasarkan 'key'
  if ($update) {
    $niss = $_GET['key'];
    
    // Using procedural style for the first query
    $sql = $connect->query("SELECT * FROM siswa, login WHERE siswa.nis=login.username and siswa.nis='$niss'");
    $row = $sql->fetch_assoc();

    // Buat ngambil status dari tabel siswa
    $stmt = $connect->prepare("SELECT nis, status FROM siswa WHERE nis = ?");
    $stmt->bind_param('s', $niss);
    $stmt->execute();
    $stmt->bind_result($nisss, $statusss);
    $stmt->fetch();

    $edit = [
        'nis' => $nisss,
        'status' => $statusss,
        // ... other columns ...
    ];

    $currentStatus = $edit['status'];
    
    // Close the statement
    $stmt->close();
  }
  $selectedStatus = (!$update || empty($row2["status"])) ? '' : $row2["status"];
  $selectedStatusAktif = ($selectedStatus === "aktif") ? 'selected="selected"' : '';
  $selectedStatusNonAktif = ($selectedStatus === "nonaktif") ? 'selected="selected"' : '';
  

  // Jika metode HTTP request adalah POST, artinya form telah di-submit
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai input dari form
    $nisn = mysqli_real_escape_string($connect, $_POST['nisn']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = mysqli_real_escape_string($connect, $_POST['nis']); // Menggunakan nis sebagai username
    $kelamin = $_POST['kelamin'];
    $email = htmlspecialchars($_POST['email']);
    $telp = mysqli_real_escape_string($connect, $_POST['telp']);
    $status = $_POST['status'];

    // Check if nis already exists
    $checkNISQuery = $connect->query("SELECT COUNT(*) as count FROM siswa WHERE nis = '$username'");
    $checkNISResult = $checkNISQuery->fetch_assoc();

    // Check if NIS already exists excluding the current record
    $checkNISQuery = $connect->query("SELECT COUNT(*) as count FROM siswa WHERE nis = '$username' AND nis != '$_GET[key]'");
    $checkNISResult = $checkNISQuery->fetch_assoc();

    // Jika NIS sudah ada, beri notifikasi dan hentikan eksekusi
    if ($checkNISResult['count'] > 0) {
      echo "<script>alert('NIS sudah ada. Gunakan NIS yang berbeda.'); window.location.href='media.php?module=siswa';</script>";
      exit;
    }

    // Cek apakah input kosong
    if (empty($nisn) || empty($nama) || empty($username) || empty($kelamin) || empty($email) || empty($telp) || empty($status)) {
      echo "<script>alert('Form tidak boleh kosong'); window.location.href='media.php?module=siswa';</script>";
      exit; // Hentikan eksekusi jika input kosong
    }

    // Mengenkripsi NISN untuk digunakan sebagai password
    $hashed_nisn_password = md5($nisn);

    // Check if the data has changed
    if ($update) {
      $currentDataQuery = $connect->query("SELECT * FROM siswa WHERE nis='$_GET[key]'");
      $currentData = $currentDataQuery->fetch_assoc();

      if (
        $nisn == $currentData['nisn'] &&
        $nama == $currentData['nama'] &&
        $kelamin == $currentData['kelamin'] &&
        $email == $currentData['email'] &&
        $telp == $currentData['telp'] &&
        $status == $currentData['status']
      ) {
        // No changes, skip the update
        echo "<script>alert('Tidak ada perubahan data.'); window.location = 'media.php?module=siswa'</script>";
        exit;
      }
    }

    // Menyusun query SQL untuk update atau insert data siswa
    if ($update) {
      $sql = "UPDATE siswa SET nisn='$nisn', nisn_password='$hashed_nisn_password', nama='$nama', kelamin='$kelamin', email='$email', telp='$telp', status='$status' WHERE nis='$_GET[key]'";
    } else {
      $sql = "INSERT INTO siswa (nis, nisn, nisn_password, nama, kelamin, email, telp, status) VALUES ('$username', '$nisn', '$hashed_nisn_password', '$nama', '$kelamin', '$email', '$telp', '$status')";
      // Setelah menyimpan siswa, tambahkan siswa ke tabel `rombel`
      $connect->query("INSERT INTO rombel VALUES ('$username', '$_POST[kd_kelas]', '$_POST[kd_tajar]')");
    }

    // Eksekusi query
    if ($connect->query($sql)) {
      if ($update) {
        $sql = "UPDATE login SET password='$username' WHERE username='$username'";
      } else {
        $password = md5($nisn);
        $tg = date('Y-m-d H:i:s');
        echo "<script>alert('Berhasil!'); window.location = 'media.php?module=siswa'</script>";

        $connect->query("INSERT INTO login VALUES ('$username', '$password', 'siswa', '$tg', 'aktif')");
        $connect->query("INSERT INTO rombel VALUES ('$username', '$_POST[kd_kelas]', '$_POST[kd_tajar]')");
      }
    } else {
      echo "<script>alert('Gagal!'); window.location = 'media.php?module=siswa'</script>";
    }
  }

  // Jika parameter 'action' di-set dan memiliki nilai 'delete'
  if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    // Hapus data siswa dari tabel siswa
    $connect->query("DELETE FROM siswa WHERE nis='$_GET[key]'");

    // Hapus data siswa dari tabel rombel
    $connect->query("DELETE FROM rombel WHERE nis='$_GET[key]'");

    echo "<script>alert('Berhasil!'); window.location = 'media.php?module=siswa'</script>";
  }
  ?>

  <!-- Bagian HTML untuk tampilan form dan tabel siswa -->
  <div class="container mt-5">
    <div class="content-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="card border-secondary mb-3">

              <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
                <?= ($update) ? "EDIT" : "TAMBAH" ?> SISWA
              </div>
              <div class="card-body text-secondary">
                <!-- Form untuk menginput atau mengedit data siswa -->
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
                  <!-- Input untuk NIS -->
                  <div class="form-group mb-3">
                    <label>NIS</label>
                    <input class="form-control" placeholder="Masukkan NIS" name="nis" type="text" <?= (!$update) ?: 'value="' . $row["nis"] . '"' ?> readonly />
                  </div>
                  <!-- Input untuk NISN -->
                  <div class="form-group mb-3">
                    <label>NISN</label>
                    <input class="form-control" placeholder="Masukkan NISN" name="nisn" type="text" <?= (!$update) ?: 'value="' . $row["nisn"] . '"' ?> />
                  </div>
                  <!-- Input untuk Nama Siswa -->
                  <div class="form-group mb-3">
                    <label>Nama Siswa </label>
                    <input class="form-control" placeholder="Masukkan Nama Siswa" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama"] . '"' ?> />
                  </div>
                  <!-- Select box untuk Jenis Kelamin -->
                  <div class="form-group mb-3">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="kelamin">
                      <option>--Pilih Jenis Kelamin--</option>
                      <option value="L" <?= (!$update) ?: (($row["kelamin"] != "L") ?: 'selected="on"') ?>>--Laki - Laki--
                      </option>
                      <option value="P" <?= (!$update) ?: (($row["kelamin"] != "P") ?: 'selected="on"') ?>>--Perempuan--
                      </option>
                    </select>
                  </div>
                  <!-- Input untuk E-Mail -->
                  <div class="form-group mb-3">
                    <label>E-Mail</label>
                    <input class="form-control" placeholder="Masukkan E-Mail" name="email" type="text" <?= (!$update) ?: 'value="' . $row["email"] . '"' ?> />
                  </div>
                  <!-- Input untuk Telepon -->
                  <div class="form-group mb-3">
                    <label>Tlp</label>
                    <input class="form-control" placeholder="Masukkan Telepon" name="telp" type="text" <?= (!$update) ?: 'value="' . $row["telp"] . '"' ?> />
                  </div>
                  <!-- Select box untuk Status -->
                  <div class="form-group mb-3">
                    <label>Status </label>
                    <select class="form-control" name="status">
                      <option value="" <?= (!$update || $currentStatus) ? 'selected="on"' : '' ?>>--Pilih Status--</option>
                      <option value="Aktif" <?= ($update && $currentStatus == 'Aktif') ? 'selected' : ''; ?>>--Aktif--</option>
                      <option value="NonAktif" <?= ($update && $currentStatus == 'NonAktif') ? 'selected' : ''; ?>>--Non Aktif--</option>
                    </select>
                  </div>

                  <!-- Select box untuk Kelas -->
                  <div class="form-group mb-3">
                    <label>Kelas</label>
                    <select class="form-control" name="kd_kelas">
                      <option>--Pilih Kelas--</option>
                      <?php
                      $query3 = $connect->query("SELECT * FROM kelas");
                      while ($data3 = $query3->fetch_assoc()):
                        ?>
                        <option value="<?= $data3["kd_kelas"] ?>" <?= (!$update) ?: (($data3["kd_kelas"] == $row["kd_kelas"]) ? 'selected="on"' : '') ?>>
                          <?= $data3["nama_kelas"] ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>

                  <!-- Select box untuk Tahun Ajaran -->
                  <div class="form-group mb-3">
                    <label>Tahun Ajaran</label>
                    <select class="form-control" name="kd_tajar">
                      <option>--Pilih Tahun Ajaran--</option>
                      <?php
                      $query5 = $connect->query("SELECT * FROM tahun_ajar");
                      while ($data5 = $query5->fetch_assoc()) {
                        $tahun_ajar = $data5["tahun_ajar"];
                        $kd_semester = $data5["kd_semester"];
                        $semester_label = ($kd_semester == 1) ? "Ganjil" : "Genap";
                        ?>
                        <option value="<?= $data5["kd_tajar"] ?>" <?= (!$update) ?: (($data5["kd_tajar"] == $row["kd_tajar"]) ? 'selected="on"' : '') ?>>
                          <?= $semester_label ?> -
                          <?= $tahun_ajar ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>


                  <!-- Tombol untuk menyimpan data siswa -->
                  <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                  <?php if ($update): ?>
                    <!-- Tombol untuk membatalkan edit -->
                    <a href="?module=siswa" class="btn btn-info btn-block">Batal</a>
                  <?php endif; ?>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="card border-secondary mb-3">
              <div class="card-header text-bg-secondary">
                TABEL SISWA


              </div>
              <div class="card-body text-secondary">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIS</th>
                      <th>NISN</th>
                      <th>Nama Siswa</th>
                      <th>Jenis Kelamin</th>
                      <th>E-mail</th>
                      <th>Telp</th>
                      <th>Status</th>
                      <th>Tahun Ajaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php if ($query = $connect->query("SELECT siswa.*, rombel.kd_tajar FROM siswa INNER JOIN rombel ON siswa.nis = rombel.nis")): ?>
                      <?php while ($row = $query->fetch_assoc()): ?>
                        <tr>
                          <td>
                            <?= $no++; ?>
                          </td>
                          <td>
                            <?= $row['nis'] ?>
                          </td>
                          <td>
                            <?= $row['nisn'] ?>
                          </td>
                          <td>
                            <?= $row['nama'] ?>
                          </td>
                          <td>
                            <?= $row['kelamin'] ?>
                          </td>
                          <td>
                            <?= $row['email'] ?>
                          </td>
                          <td>
                            <?= $row['telp'] ?>
                          </td>
                          <td>
                            <?= $row['status'] ?>
                          </td>
                          <td>
                            <?= $row['kd_tajar'] ?>
                          </td>
                          <td class="hidden-print">
                            <div class="btn-group">
                              <a href="?module=siswa&action=update&key=<?= $row['nis'] ?>"
                                class="btn btn-warning btn-xs">Edit</a>
                              <a href="?module=siswa&action=delete&key=<?= $row['nis'] ?>"
                                class="btn btn-danger btn-xs">Hapus</a>
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