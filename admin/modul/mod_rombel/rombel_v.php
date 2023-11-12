<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../koneksi/koneksi.php";

// Cek apakah session username, passuser, dan login sudah di-set
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
  // Jika tidak, redirect ke halaman login
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {

  // Query untuk mendapatkan tahun ajaran aktif
  $qtajar = mysqli_query($connect, "SELECT * FROM tahun_ajar WHERE aktif='Y'");
  $r = mysqli_fetch_assoc($qtajar);
  $thn_ajar = $r['kd_tajar'];
  $tahun = $r['tahun_ajar'];
  $semester = $r['kd_semester'];
?>

  <!-- halaman dashboard -->
  <div class="content-wrapper">
    <div class="container">
      <div class="row pad-botm">
        <div class="col-md-12">
          <h4 class="header-line">SELAMAT DATANG DI DASHBOARD ADMINISTRATOR</h4>
        </div>
      </div>
      <div class="row">
        <!-- Bagian sidebar sebelah kiri -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="card border-secondary mb-3 card-info">
            <div class="card-header text-bg-secondary">
              DATA ROMBEL
            </div>
            <div class="card-body text-center recent-users-sec">
              <form>
                <!-- Form untuk memilih kelas -->
                <div class="form-group mb-3">
                  <label>Kelas</label>
                  <select class="form-control" name="kd_kelas" id="cbbkls">
                    <option selected hidden>--Pilih Kelas--</option>
                    <?php
                    // Query untuk mendapatkan data kelas
                    $query3 = $connect->query("SELECT * FROM kelas ORDER BY tingkat");
                    while ($data3 = $query3->fetch_assoc()) : ?>
                      <option value="<?= $data3["kd_kelas"] ?>"><?= $data3["nama_kelas"] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <!-- Input untuk menampilkan tahun ajaran yang aktif -->
                <div class="form-group mb-3">
                  <label>Tahun Ajaran</label>
                  <input type="text" class="form-control" name="" value="<?= $thn_ajar; ?>" disabled="">
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Bagian konten utama sebelah kanan -->
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="card border-secondary mb-3">
            <div class="card-header text-bg-secondary">
              <?php
              // Menampilkan judul berdasarkan apakah parameter kls di-set
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
                // Menentukan kelas yang dipilih
                $kd_kelas_selected = isset($_GET['kls']) ? $_GET['kls'] : '';

                // Membuat query untuk menampilkan data rombel berdasarkan kelas yang dipilih
                $sql = "
                  SELECT * FROM rombel, kelas, tahun_ajar, siswa 
                  where rombel.kd_kelas=kelas.kd_kelas
                  and siswa.nis=rombel.nis
                  and rombel.kd_tajar=tahun_ajar.kd_tajar AND rombel.kd_tajar='$thn_ajar'
                  " . ($kd_kelas_selected ? "AND rombel.kd_kelas='$kd_kelas_selected'" : '');

                // Menghitung jumlah baris hasil query
                $jum = mysqli_num_rows(mysqli_query($connect, $sql));

                // Menampilkan pesan jika tidak ada data siswa yang ditambahkan ke rombel
                if ($jum == 0 && $kd_kelas_selected) {
                  $tingkat = mysqli_query($connect, "SELECT tingkat FROM kelas WHERE kd_kelas='$kd_kelas_selected'");
                  $dtkt = mysqli_fetch_assoc($tingkat);
                  echo "<hr>";
                }
                ?>
                <!-- Tabel untuk menampilkan data siswa dalam rombel -->
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
                          <!-- Menampilkan data siswa -->
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

  <!-- Script JavaScript untuk meng-handle perubahan pada select box -->
  <script>
    // JavaScript untuk menangani perubahan pada select box
    document.getElementById("cbbkls").addEventListener("change", function() {
      const selectedKelas = this.value;
      if (selectedKelas) {
        // Redirect ke kelas yang dipilih
        window.location.href = `media.php?module=rombel&kls=${selectedKelas}`;
      } else {
        // Redirect ke URL default
        window.location.href = 'rombel';
      }
    });
  </script>

<?php
}
?>
