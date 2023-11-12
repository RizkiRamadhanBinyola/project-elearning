<?php
// Memeriksa apakah parameter 'kd' telah diatur dalam URL ($_GET)
if (!isset($_GET['kd'])) {
    // Mengarahkan ke halaman tugas dengan mata pelajaran 'all' jika 'kd' tidak diatur
    header("location:?module=tugas&mp=all");
}

// Mendapatkan nilai 'kd' dari parameter URL
$kd = $_GET['kd'];

// Query untuk mengambil data tugas, kerja_tugas, mapel, guru, dan kelas
$qt = "SELECT * 
FROM tugas, kerja_tugas, mapel, guru, kelas
WHERE tugas.kd_tugas=kerja_tugas.kd_tugas AND tugas.kd_mapel=mapel.kd_mapel AND tugas.kd_guru=guru.kd_guru AND tugas.kd_kelas=kelas.kd_kelas AND tugas.kd_kelas='$kode_kelas' AND kerja_tugas.nis='$_SESSION[kode]' AND kerja_tugas.kd_tugas='$kd'";
$qtugas = mysqli_query($connect, $qt);

// Mengambil hasil query sebagai array
$rtugas = mysqli_fetch_array($qtugas);
?>

<!-- Bagian HTML untuk menampilkan informasi tugas -->
<div class="container mt-5">
    <div class="row">
        <!-- Bagian untuk informasi tugas -->
        <div class="col-md-8">
            <div class="card border-secondary mb-3">
                <!-- Judul tugas sebagai header card -->
                <div class="card-header text-bg-secondary">
                    <?= $rtugas['nama_tugas']; ?>
                </div>
                <div class="card-body">
                    <!-- Informasi tambahan seperti pemberi tugas, tanggal, dan batas waktu pengumpulan -->
                    <h6>
                        <?= "Diberikan oleh : " . $rtugas['nama']; ?>
                    </h6>
                    <h6>
                        <?= "Pada : " . $rtugas['tgl_up']; ?>
                    </h6>
                    <h6>File :
                        <?php echo "<a href='files/tugas/$rtugas[file]' target='_blank' class='btn btn-secondary'>Download Tugas</a>"; ?>
                    </h6>
                    Batas mengumpulkan:
                    <?php echo $rtugas['batas_ahir']; ?>
                </div>
            </div>
        </div>
        <!-- Bagian untuk mengumpulkan tugas -->
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header text-bg-secondary">
                    Kumpulkan Tugas
                </div>
                <div class="card-body">
                    <!-- Form untuk mengunggah jawaban tugas -->
                    <form method="POST" action="modul/mod_tugas_siswa/aksi.php?act=tbjawab" enctype="multipart/form-data">

                        <?php
                        // Memeriksa status kerja tugas dan menampilkan pesan sesuai dengan kondisi
                        if ($rtugas['status_kerja'] == 'T') {
                            echo "<div class='alert alert-danger'>Anda Belum Mengumpulkan Tugas</div>";

                            // Menampilkan input file hanya ketika status 'T' dan waktu pengumpulan belum berakhir
                            date_default_timezone_set('Asia/Jakarta');
                            $skr = date("Y-m-d H:i:s");
                            if (strtotime($rtugas['batas_awal']) <= strtotime($skr) && strtotime($skr) <= strtotime($rtugas['batas_ahir'])) {
                                ?>
                                <h4>Upload Jawaban:</h4>
                                <!-- Inputan untuk unggah jawaban -->
                                <div class="mb-3">
                                    <input class="form-control" type="file" name="ftugas1" id="ftugas1">
                                </div>
                                <input type="hidden" name="kd_kerja" value="<?php echo $rtugas['kd_kerja']; ?>">
                                <input type="hidden" name="kd_tugas" value="<?php echo $rtugas['kd_tugas']; ?>">
                                <?php
                                // Tombol untuk mengirim jawaban
                                echo "<button type='submit' class='btn btn-primary'>Kirim Jawaban</button>";
                            } else if (strtotime($rtugas['batas_awal']) >= strtotime($skr)) {
                                echo "<p class='text-info'>Belum bisa mengumpulkan tugas karena belum dimulai. ";
                                echo "<br>Tugas dimulai pada $rtugas[batas_awal]</p>";
                            } else {
                                echo "<b class='text-warning'>Tidak bisa mengumpulkan tugas karena sudah lewat batas </b>";
                            }
                        } else if ($rtugas['status_kerja'] == 'K') {
                            echo "<div class='alert alert-warning'>Jawaban Anda Sedang Dikoreksi</div>";
                        } else if ($rtugas['status_kerja'] == 'N') {
                            echo "<div class='alert alert-success'>Anda mendapat nilai: $rtugas[nilai]</div>";
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
