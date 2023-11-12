<?php
// Memeriksa apakah data rombel kosong
if ($rombel == "NULL") {
  ?>
  <!-- Menampilkan pesan untuk pengguna yang belum diinputkan ke dalam kelas -->
  <div class="row">
    <div class="col-12">
      <div class="alert alert-info">
        <h4>selamat datang di dashboard administrator</h4>
        <p>Sayang sekali, data kamu belum diinputkan ke dalam kelas pada tahun ajaran ini. Silahkan meminta admin untuk
          memasukkan.</p>
      </div>
    </div>
  </div>
  <?php
} else {
  ?>
  <!-- Menampilkan dashboard jika data rombel tidak kosong -->
  <div class="container mt-5">
    <div class="row pad-botm">
      <div class="col-md-12">
        <h4 class="header-line">SELAMAT DATANG DI DASHBOARD ADMINISTRATOR</h4>
      </div>
    </div>
    <div class="row">
      <!-- Menampilkan informasi data rombel -->
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="card border-secondary mb-3">
          <div class="card-header text-bg-secondary">
            DATA ROMBEL
          </div>
          <div class="card-body">
            <div class="text-start">
              <h6>
                Nama :
                <?php echo $nama_siswa; ?>
              </h6>
              <h6>Kelas :
                <?= $nama_kelas; ?>
              </h6>
            </div>
            <!-- Daftar Mapel -->
            <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
              <?php
              // Menampilkan daftar mapel yang diajar di rombel
              $qmp = "SELECT mapel.kd_mapel, mapel.nama_mapel 
                      FROM pengajaran as p, mapel, kelas 
                      WHERE p.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=p.kd_kelas AND p.kd_kelas='$kode_kelas'";
              $mp = mysqli_query($connect, $qmp);
              // Inisialisasi variabel $o dengan nilai 1
              $o = 1;
              while ($rmp = mysqli_fetch_array($mp)) {
                ?>
                <!-- Menampilkan informasi mapel -->
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#flush-collapse<?= $o ?>" aria-expanded="false"
                      aria-controls="flush-collapse<?= $o ?>">
                      <?= $rmp['nama_mapel'] ?>
                    </button>
                  </h2>
                  <div id="flush-collapse<?= $o ?>" class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                      <!-- Menampilkan tombol akses ke modul Materi, Tugas, dan Nilai -->
                      <a href='?module=materi&mp=<?= $rmp['kd_mapel'] ?>' class='btn btn-primary btn-sm'>Materi</a>
                      <a href='?module=tugas&mp=<?= $rmp['kd_mapel'] ?>' class='btn btn-primary btn-sm'>Tugas</a>
                      <a href='?module=nilai&mp=<?= $rmp['kd_mapel'] ?>' class='btn btn-primary btn-sm'>Nilai</a>
                      <?php
                      // Mengecek apakah sudah dilakukan absensi hari ini
                      date_default_timezone_set("Asia/Bangkok");
                      $tglnow = date("Y-m-d");
                      $cekabsensi = mysqli_query($connect, "SELECT kd_absensi FROM absensi WHERE nis='$nis' AND kd_kelas='$kode_kelas' AND kd_mapel='$rmp[kd_mapel]' AND tgl_absensi LIKE '$tglnow%'");
                      $sudahabsen = mysqli_num_rows($cekabsensi);

                      if ($sudahabsen > 0) {
                        echo "<h6 class='text-success'>Sudah Absen</h6>";
                      } else {
                        echo "<a href='modul/home_siswa/aksi.php?act=absen&mp=$rmp[kd_mapel]&nis=$nis&kls=$kode_kelas' class='btn btn-primary btn-sm'>Absensi</a>";
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <?php
                // Increment nilai variabel $o setelah tombol accordion
                $o++;
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Menampilkan daftar materi, tugas, dan informasi penting di kelas -->
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="card border-secondary mb-3">
          <div class="card-header text-bg-secondary">
            Daftar materi dan tugas kelas
            <?= $nama_kelas; ?>
          </div>
          <div class="row row-cols-1 row-cols-md-2 g-4 m-1 mb-4">
            <?php
            // Fungsi untuk mendapatkan timeline dari database
            function getTL($j, $kd, $conn)
            {
              $query = "SELECT $j.*, guru.nama, mapel.nama_mapel  
                        FROM $j , guru, mapel 
                        WHERE $j.kd_guru=guru.kd_guru AND $j.kd_mapel=mapel.kd_mapel AND kd_$j='$kd'";
              $q = mysqli_query($conn, $query);
              while ($r = mysqli_fetch_array($q)) {
                $j = strtoupper($j);
                $class = 'text-bg-info'; // Kelas default
          
                // Mengecek status kerja tugas
                if ($j == 'TUGAS') {
                  $kd_tugas = $r['kd_tugas'];
                  $nis = $_SESSION['kode'];
                  $queryCheckCompletion = "SELECT status_kerja FROM kerja_tugas WHERE kd_tugas='$kd_tugas' AND nis='$nis'";
                  $resultCompletion = mysqli_query($conn, $queryCheckCompletion);
                  $rowCompletion = mysqli_fetch_assoc($resultCompletion);

                  if ($rowCompletion['status_kerja'] == 'N') {
                    $class = 'text-bg-success'; // Mengganti kelas menjadi success jika sudah dikerjakan
                  }
                }

                // Menampilkan informasi sesuai dengan jenis timeline
                echo "<div class='col'>
                        <div class='card $class'>
                          <div class='card-body'>";
                switch ($j) {
                  case 'TUGAS':
                    echo "Guru $r[nama] telah menambahkan TUGAS $r[nama_mapel] pada $r[tgl_up].     
                          </div>
                          <div class='card-footer text-end'>
                            <a href='?module=detailtugas&kd=$r[kd_tugas]' class='alert-link'>Buka Tugas ⮕</a>
                          </div>";
                    break;
                  case 'MATERI':
                    echo "Guru $r[nama] telah menambahkan MATERI $r[nama_mapel] pada $r[tgl_up]. <a href='?module=materi&mp=$r[kd_mapel]' class='alert-link'>Buka materi</a>";
                    break;

                  case 'UJIAN':
                    echo "Guru $r[nama] telah menambahkan UJIAN $r[nama_mapel]. <a href='?module=ujian&mp=$r[kd_mapel]' class='alert-link'>Buka Ujian</a>";
                    break;

                  default:
                    # code...
                    break;
                }
                echo "</div>
                      </div>";
              }
            }

            // Mendapatkan jenis timeline dari database tabel timeline
            $qt = "SELECT timeline.jenis, timeline.id_jenis 
                  FROM timeline, pengajaran as p, guru, mapel, kelas 
                  WHERE p.kd_guru=guru.kd_guru AND 
                  p.kd_mapel=timeline.kd_mapel AND p.kd_kelas=kelas.kd_kelas AND p.kd_kelas=timeline.kd_kelas AND p.kd_mapel=mapel.kd_mapel AND timeline.kd_kelas='$kode_kelas' ORDER BY timeline.waktu DESC";
            $tlguru = mysqli_query($connect, $qt);
            while ($rTL = mysqli_fetch_array($tlguru)) {
              getTL($rTL['jenis'], $rTL['id_jenis'], $connect);
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>