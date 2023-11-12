<?php
// Memastikan bahwa user sudah login sebelum mengakses halaman ini
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
?>

<!-- Bagian HTML dan PHP untuk menampilkan form pengajaran -->
<div class="container mt-5">
  <div class="content-wrapper">
    <div class="row">
      <!-- Form untuk pengelolaan pengajaran -->
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="card border-secondary mb-3">
          <div class="card-header text-bg-secondary">
            MANAJEMEN PENGAJAR
          </div>
          <div class="card-body text-secondary">
            <!-- Jika ada parameter 'eid' (edit mode), tampilkan form edit -->
            <?php
            if (isset($_GET['eid'])) {
              $id = $_GET['eid'];
              // Fetch data untuk pengajaran yang dipilih
              $query = "SELECT * FROM pengajaran WHERE kd_pengajaran='$id'";
              $result = mysqli_query($connect, $query);
              $pengajaranData = mysqli_fetch_assoc($result);
            ?>
              <!-- Form untuk mengupdate pengajaran -->
              <form action="modul/mod_pengajaran/aksi.php?act=update" method="POST">
                <!-- Input field untuk kd_pengajaran -->
                <input type="hidden" name="kd_pengajaran" value="<?= $pengajaranData['kd_pengajaran'] ?>">
                <!-- Input field untuk kd_mapel -->
                <div class="form-group mb-3">
                  <label for="kd_mapel">Mata Pelajaran</label>
                  <select name="kd_mapel" class="form-control" required>
                    <?php
                    // Menampilkan pilihan mata pelajaran
                    $mapelQuery = "SELECT kd_mapel, nama_mapel FROM mapel ORDER BY nama_mapel";
                    $mapelResult = mysqli_query($connect, $mapelQuery);
                    while ($mapel = mysqli_fetch_assoc($mapelResult)) {
                      $selected = ($mapel['kd_mapel'] == $pengajaranData['kd_mapel']) ? 'selected' : '';
                      echo "<option value='{$mapel['kd_mapel']}' $selected>{$mapel['nama_mapel']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <!-- Input field untuk kd_kelas -->
                <div class="form-group mb-3">
                  <label for="kd_kelas">Kelas</label>
                  <select name="kd_kelas" class="form-control" required>
                    <?php
                    // Menampilkan pilihan kelas
                    $kelasQuery = "SELECT kd_kelas, nama_kelas FROM kelas ORDER BY nama_kelas";
                    $kelasResult = mysqli_query($connect, $kelasQuery);
                    while ($kelas = mysqli_fetch_assoc($kelasResult)) {
                      $selected = ($kelas['kd_kelas'] == $pengajaranData['kd_kelas']) ? 'selected' : '';
                      echo "<option value='{$kelas['kd_kelas']}' $selected>{$kelas['nama_kelas']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <!-- Input field untuk kd_jurusan -->
                <div class="form-group mb-3">
                  <label for="kd_jurusan">Jurusan</label>
                  <select name="kd_jurusan" class="form-control" required>
                    <?php
                    // Menampilkan pilihan jurusan
                    $jurusanQuery = "SELECT kd_jurusan, nama_jurusan FROM jurusan ORDER BY nama_jurusan";
                    $jurusanResult = mysqli_query($connect, $jurusanQuery);
                    while ($jurusan = mysqli_fetch_assoc($jurusanResult)) {
                      $selected = ($jurusan['kd_jurusan'] == $pengajaranData['kd_jurusan']) ? 'selected' : '';
                      echo "<option value='{$jurusan['kd_jurusan']}' $selected>{$jurusan['nama_jurusan']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <!-- Input field untuk kd_guru -->
                <div class="form-group mb-3">
                  <label for="kd_guru">Guru Pengajar</label>
                  <select name="kd_guru" class="form-control" required>
                    <?php
                    // Menampilkan pilihan guru pengajar yang aktif
                    $guruQuery = "SELECT kd_guru, nama FROM guru WHERE status='Aktif' ORDER BY nama";
                    $guruResult = mysqli_query($connect, $guruQuery);
                    while ($guru = mysqli_fetch_assoc($guruResult)) {
                      $selected = (in_array($guru['kd_guru'], explode(",", $pengajaranData['kd_guru']))) ? 'selected' : '';
                      echo "<option value='{$guru['kd_guru']}' $selected>{$guru['nama']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <!-- Input field untuk update kd_pengajaran -->
                <input type="hidden" name="kd_pengajaran" value="<?= $pengajaranData['kd_pengajaran'] ?>">
                <!-- Tombol untuk membatalkan update -->
                <a href="media.php?module=pengajaran" class="btn btn-danger">Batal</a>
                <!-- Tombol untuk melakukan update -->
                <input type="submit" name="submit" value="Update" class="btn btn-primary">
              </form>

            <?php } else { ?>
              <!-- Form untuk menambah pengajaran baru -->
              <form action="modul/mod_pengajaran/aksi.php?act=add" method="POST" role="form">
                <!-- Input field untuk kd_mapel -->
                <div class="form-group mb-3">
                  <label>Mata Pelajaran</label>
                  <select class="form-control" name="kd_mapel" id="cbbmapelajar">
                    <option selected hidden>Pilih Matapelajaran</option>
                    <?php if ($query = $connect->query("SELECT * FROM mapel ORDER BY nama_mapel")): ?>
                      <?php while ($row = $query->fetch_assoc()): ?>
                        <option value="<?php echo $row['kd_mapel']; ?>">
                          <?php echo $row['nama_mapel']; ?>
                        </option>
                      <?php endwhile ?>
                    <?php endif ?>
                  </select>
                </div>
                <!-- Input field untuk kd_jurusan -->
                <div class="form-group mb-3">
                  <label>Jurusan</label>
                  <select class="form-control" name="kd_jurusan" id="cbbjurusan" data-mapel="">
                    <option selected hidden>Pilih Jurusan</option>
                    <?php if ($query = $connect->query("SELECT * FROM jurusan ORDER BY nama_jurusan")): ?>
                      <?php while ($row = $query->fetch_assoc()): ?>
                        <option value="<?php echo $row['kd_jurusan']; ?>">
                          <?php echo $row['nama_jurusan']; ?>
                        </option>
                      <?php endwhile ?>
                    <?php endif ?>
                  </select>
                </div>
                <!-- Input field untuk kd_kelas -->
                <div class="form-group mb-3">
                  <label>Kelas</label>
                  <select class="form-control" name="kd_kls[]" id="cbbkelas" data-kelas="">
                    <option selected hidden>Pilih Kelas</option>
                    <?php if ($query = $connect->query("SELECT * FROM kelas ORDER BY kd_kelas")): ?>
                      <?php while ($row = $query->fetch_assoc()): ?>
                        <option value="<?php echo $row['kd_kelas']; ?>">
                          <?= $row['nama_kelas'] ?>
                        </option>
                      <?php endwhile ?>
                    <?php endif ?>
                  </select>
                </div>
                <!-- Input field untuk kd_guru -->
                <div class="form-group mb-3">
                  <label>Guru</label>
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
                <!-- Tombol untuk menambah pengajaran baru -->
                <input type="submit" name="submit" value="Tambah" class="btn btn-info">
              </form>
            <?php } ?>
          </div>
        </div>
      </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              TABEL PENGAJAR
            </div>
            <div class="card-body text-secondary">
              <form action="" method="get" class="mb-3">
                <div class="form-group col-sm-4 col-md-2 col-xs-12">
                  <label>Filter</label>
                  <input type="hidden" name="module" value="pengajaran">
                </div>
                <div class="row">
                  <div class="form-group col-sm-6 col-md-8 col-xs-12">
                    <select name='fkelas' class="form-control">
                      <option value="all">Semua</option>
                      <?php
                      $query = mysqli_query($connect, "SELECT kd_kelas,nama_kelas FROM kelas ORDER BY tingkat");

                      while ($result = mysqli_fetch_array($query)) {
                        echo "<option value='$result[kd_kelas]'>$result[nama_kelas]</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-sm-2 col-md-4 col-xs-12 ms-auto">
                    <input type="submit" class="btn btn-info btn-sm col-12" value="Saring">
                  </div>
                </div>
              </form>
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
                  if ($query = $connect->query("SELECT * FROM pengajaran,mapel,kelas where pengajaran.kd_mapel=mapel.kd_mapel AND pengajaran.kd_kelas=kelas.kd_kelas " . $fkelas . " ORDER BY pengajaran.kd_kelas")): ?>
                    <?php while ($row = $query->fetch_assoc()): ?>
                      <tr>
                        <td>
                          <?= $no; ?>
                        </td>
                        <td>
                          <?= $row['nama_mapel'] ?>
                        </td>
                        <td>
                          <?= $row['nama_kelas'] ?>
                        </td>
                        <td>
                          <?php
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
                          <a href="?module=pengajaran&eid=<?php echo $row['kd_pengajaran'] ?>"
                            class="btn btn-warning btn-xs">Edit</a>
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