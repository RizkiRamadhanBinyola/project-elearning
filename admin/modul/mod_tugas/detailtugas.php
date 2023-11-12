<?php
// Memeriksa apakah sesi pengguna valid.
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    // Jika tidak valid, tampilkan pesan dan arahkan ke halaman login.
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
    // Jika sesi pengguna valid, tampilkan halaman daftar tugas.
    ?>
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian Daftar Tugas -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!-- Card untuk Daftar Tugas -->
                <div class="card border-secondary mb-3">
                    <div class="card-header text-bg-secondary">
                        DAFTAR TUGAS | <a href="modul/mod_tugas/proses_tugas.php?kd=<?= $_GET['kd']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-arrow-down"></i></a>
                    </div>
                    <div class="card-body">
                        <!-- Tabel Daftar Tugas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIS</th>
                                        <th>NAMA</th>
                                        <th>Nilai</th>
                                        <th>Mengumpulkan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Memeriksa apakah parameter kd (kd_tugas) terdefinisi.
                                    if (isset($_GET['kd'])) {
                                        // Jika ya, ambil data siswa yang mengumpulkan tugas.
                                        $kd_tugas = $_GET['kd'];
                                        $qs = "SELECT * FROM kerja_tugas,siswa WHERE kerja_tugas.nis=siswa.nis AND kerja_tugas.kd_tugas='$kd_tugas' ORDER BY kerja_tugas.status_kerja";
                                        $query = mysqli_query($connect, $qs);
                                        $num = mysqli_num_rows($query);
                                        $n = 1;
                                        if ($num > 0) {
                                            while ($rkerja = mysqli_fetch_array($query)) {
                                                // Menentukan status pengumpulan tugas dan tindakan yang sesuai.
                                                if ($rkerja['status_kerja'] == 'T') {
                                                    $st = 'Belum';
                                                    $cek = "-";
                                                } else if ($rkerja['status_kerja'] == 'K') {
                                                    $st = 'Sudah';
                                                    $cek = "<a class='btn btn-warning btn-xs' href='?module=detailtugas&kd=$kd_tugas&eid=$rkerja[kd_kerja]'>Cek</a>";
                                                } else if ($rkerja['status_kerja'] == 'N') {
                                                    $st = 'Dinilai';
                                                    $cek = "<a class='btn btn-success btn-xs' href='?module=detailtugas&kd=$kd_tugas&eid=$rkerja[kd_kerja]'>Cek</a>";
                                                }
                                                // Menampilkan baris data siswa.
                                                echo "<tr>";
                                                echo "<td>$n</td>
                                                        <td>$rkerja[nis]</td>
                                                        <td>$rkerja[nama]</td>
                                                        <td>$rkerja[nilai]</td>
                                                        <td>$st</td>
                                                        <td>$cek</td>";
                                                echo "</tr>";
                                                $n++;
                                            }
                                        } else {
                                            // Menampilkan pesan jika belum ada data siswa yang mengumpulkan tugas.
                                            echo "<tr><td colspan='5'>Belum ada data</td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer Card Daftar Tugas -->
                    <div class="card-footer">
                        <?php
                        // Mengambil nama tugas berdasarkan kd_tugas.
                        $qt = mysqli_query($connect, "SELECT nama_tugas FROM tugas WHERE kd_tugas='$_GET[kd]'");
                        $dtgs = mysqli_fetch_array($qt);
                        ?>
                        <h6>
                            Nama Tugas :
                            <?php echo strtoupper($dtgs['nama_tugas']) ?>
                        </h6>
                    </div>
                </div>
            </div>
            <!-- Bagian Detail Tugas -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!-- Card untuk Detail Tugas -->
                <div class="card border-secondary mb-3">
                    <div class="card-header text-bg-secondary">
                        Detail
                    </div>
                    <div class="card-body">
                        <?php
                        // Memeriksa apakah parameter eid (kd_kerja) terdefinisi.
                        if (isset($_GET['eid'])) {
                            // Jika ya, ambil data detail kerja tugas untuk ditampilkan.
                            $qdt = mysqli_query($connect, "SELECT * FROM kerja_tugas WHERE kd_kerja='$_GET[eid]'");
                            $dt = mysqli_fetch_array($qdt);
                            ?>
                            <!-- Menampilkan Gambar yang Diunggah oleh Siswa -->
                            <div class="row">
                                <?php
                                // Memeriksa apakah siswa sudah mengumpulkan tugas.
                                if ($dt['file_kerja'] == 'T') {
                                    echo "<p class='alert'>Siswa belum mengumpulkan tugas</p>";
                                } else {
                                    // Jika sudah, tampilkan gambar yang diunggah oleh siswa.
                                    $gbr = explode(",", $dt['file_kerja']);
                                    foreach ($gbr as $img) {
                                        echo "<a href='files/kerja_tugas/$img' target='_blank'><img src='files/kerja_tugas/$img' class='col-md-12 col-sm-12 col-xs-12'></a><br>";
                                    }
                                    ?>
                                    <!-- Form untuk Memberikan Nilai -->
                                    <form method="POST" action="modul/mod_tugas/aksi.php?act=berinilai">
                                        <div class="form-goup">
                                            <label class="col-md-2 col-sm-2 col-xm-6">Nilai</label>
                                            <input type="hidden" name="kd" value="<?php echo $dt['kd_kerja']; ?>">
                                            <input type="hidden" name="kdt" value="<?php echo $_GET['kd']; ?>">
                                            <!-- Input untuk Memasukkan Nilai -->
                                            <input type="number" min="0" max="100" name="nilai" class="col-md-3 col-sm-3 col-xm-6" value="<?php echo $dt['nilai']; ?>" <?php echo $dt['status_kerja'] == 'N' ? "disabled='disabled'" : ""; ?>>
                                            <span class="col-md-1 col-sm-1 col-xm-6"></span>
                                            <!-- Tombol Untuk Menyimpan Sebagai Draf atau Simpan Nilai -->
                                            <input type="submit" name="draf" class="col-md-3 col-sm-3 col-xm-6" value="Draf" <?php echo $dt['status_kerja'] == 'N' ? "disabled='disabled'" : ""; ?>>
                                            <input type="submit" name="simpan" class="col-md-3 col-sm-3 col-xm-6" value="Simpan" <?php echo $dt['status_kerja'] == 'N' ? "disabled='disabled'" : ""; ?>>
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        } else {
                            ?>
                            <!-- Menampilkan Pesan Jika Belum Memilih Siswa -->
                            <div class="alert alert-primary">
                                Silahkan pilih data siswa di samping untuk melihat jawaban masing-masing dan mengkoreksinya kemudian menilainya.
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php } ?>
