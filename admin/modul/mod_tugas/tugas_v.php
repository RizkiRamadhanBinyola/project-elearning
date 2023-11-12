<?php
// Memeriksa apakah sesi pengguna telah login. Jika tidak, akan diredirect ke halaman login.
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
    ?>
    <!-- Jika sesi pengguna telah login, tampilkan halaman berikut -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 col-sm-12">

                <?php
                // Jika parameter 'eid' (edit id) ada dalam URL, tampilkan form untuk mengedit tugas.
                if (isset($_GET['eid'])) {
                    $id = $_GET['eid'];
                    $qw = "SELECT tugas.*, mapel.nama_mapel, kelas.nama_kelas, mapel.kd_mapel 
                FROM tugas, pengajaran as p, mapel, kelas 
                WHERE p.kd_mapel=tugas.kd_mapel AND tugas.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=tugas.kd_kelas AND p.kd_kelas=kelas.kd_kelas AND tugas.kd_guru=p.kd_guru AND tugas.kd_tugas='$id'";
                    $tugas = mysqli_query($connect, $qw);
                    $etugas = mysqli_fetch_array($tugas);
                    ?>
                    <div class="card border-warning mb-3">
                        <div class="card-header text-bg-warning">
                            UBAH TUGAS
                        </div>
                        <div class="card-body">
                            <!-- Form untuk mengedit tugas -->
                            <form role="form" name="fupmateri" method="POST" action="modul/mod_tugas/aksi.php?act=edit"
                                enctype="multipart/form-data">
                                <!-- Input untuk menampilkan nama mata pelajaran dan menyimpan kd_mapel -->
                                <div class="form-group mb-3">
                                    <input class="form-control" type="txt" name="mpl"
                                        value="<?php echo $etugas['nama_mapel'] ?>" disabled="disabled">
                                    <input type="hidden" name="mapel" value="<?php echo $etugas['kd_mapel'] ?>">
                                    <input type="hidden" name="kd_tugas" value="<?php echo $id ?>">
                                </div>
                                <!-- Input untuk menampilkan nama kelas dan menyimpan kd_kelas -->
                                <div class="form-group mb-3">
                                    <div id="infokls">
                                        <input class="form-control" type="txt" name="kls"
                                            value="<?php echo $etugas['nama_kelas'] ?>" disabled="disabled">
                                        <input type="hidden" name="kd_kls" value="<?php echo $etugas['kd_kelas'] ?>">
                                    </div>
                                </div>
                                <!-- Input untuk mengedit judul tugas -->
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" name="judul_tugas"
                                        value="<?php echo $etugas['nama_tugas'] ?>" />
                                </div>
                                <!-- Input untuk mengedit waktu awal pengerjaan -->
                                <div class="form-group mb-3">
                                    <label>Awal Pengerjaan</label>
                                    <input class="form-control" type="date" name="awaltgl"
                                        value="<?php echo substr($etugas['batas_awal'], 0, 10) ?>" />
                                    <input class="form-control m-1" type="time" name="awaljam"
                                        value="<?php echo substr($etugas['batas_awal'], 11, 5) ?>" />
                                </div>
                                <!-- Input untuk mengedit waktu batas akhir pengerjaan -->
                                <div class="form-group mb-3">
                                    <label>Batas Akhir Pengerjaan</label>
                                    <input class="form-control" type="date" name="ahirtgl"
                                        value="<?php echo substr($etugas['batas_ahir'], 0, 10) ?>" />
                                    <input class="form-control" type="time" name="ahirjam"
                                        value="<?php echo substr($etugas['batas_ahir'], 11, 5) ?>" />
                                </div>
                                <!-- Input untuk mengganti file tugas -->
                                <div class="form-group mb-3">
                                    <label>Ubah File Tugas</label>
                                    <input class="form-control" type="file" name="fuptugas" id="fileupload" />
                                    <p class="warningnya text-danger text-left">Kosongkan jika tidak mengubah file</p>
                                </div>

                                <!-- Input untuk menyimpan kd_guru -->
                                <div class="form-group mb-3">
                                    <input type="hidden" name="kd_guru" value="<?php echo $_SESSION['kode'] ?>">
                                </div>
                                <!-- Tombol untuk membatalkan dan menyimpan perubahan -->
                                <a href="?module=tugas&mp=<?= $etugas['kd_mapel'] ?>&kls=<?= $etugas['kd_kelas'] ?>"
                                    class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-success">Update </button>
                            </form>
                        </div>
                    </div>

                    <?php
                } else { ?>
                    <!-- Jika parameter 'eid' tidak ada, tampilkan form untuk membuat tugas baru -->
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-secondary">
                            BUAT TUGAS
                        </div>
                        <div class="card-body">
                            <!-- Form untuk membuat tugas baru -->
                            <form role="form" name="fupmateri" method="POST" action="modul/mod_tugas/aksi.php?act=add"
                                enctype="multipart/form-data">
                                <!-- Dropdown untuk memilih mata pelajaran -->
                                <div class="form-group mb-3">
                                    <select name="mapel" class="form-control" id="cbbmapel"
                                        data-guru="<?php echo $_SESSION['kode'] ?>">
                                        <option selected="selected">Pilih Mata Pelajaran</option>
                                        <?php
                                        // Query untuk mendapatkan daftar mata pelajaran yang diajar oleh guru
                                        $qmapel = "SELECT m.nama_mapel, m.kd_mapel FROM pengajaran as p, mapel as m WHERE m.kd_mapel=p.kd_mapel AND p.kd_guru='$_SESSION[kode]' GROUP BY p.kd_mapel";
                                        $datamapel = mysqli_query($connect, $qmapel);
                                        while ($mapel = mysqli_fetch_array($datamapel)) {
                                            echo "<option value='$mapel[kd_mapel]'>$mapel[nama_mapel]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- Dropdown untuk memilih kelas -->
                                <div class="form-group mb-3">
                                    <select name="kd_kls[]" class="form-control">
                                        <option selected="selected">Pilih Kelas</option>
                                        <?php
                                        // Query untuk mendapatkan daftar kelas
                                        $qkelas = "SELECT kd_kelas, nama_kelas FROM kelas";
                                        $datakelas = mysqli_query($connect, $qkelas);
                                        while ($kelas = mysqli_fetch_array($datakelas)) {
                                            echo "<option value='$kelas[kd_kelas]'>$kelas[nama_kelas]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- Input untuk mengisi judul tugas -->
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" name="judul_tugas" placeholder="Judul Tugas" />
                                </div>
                                <!-- Input untuk memilih waktu awal pengerjaan -->
                                <div class="form-group mb-3">
                                    <label>Awal Pengerjaan</label>
                                    <input class="form-control" type="date" name="awaltgl" />
                                    <input class="form-control" type="time" name="awaljam" />
                                </div>
                                <!-- Input untuk memilih waktu batas akhir pengerjaan -->
                                <div class="form-group mb-3">
                                    <label>Batas Akhir Pengerjaan</label>
                                    <input class="form-control" type="date" name="ahirtgl" />
                                    <input class="form-control" type="time" name="ahirjam" />
                                </div>
                                <!-- Input untuk mengupload file tugas -->
                                <div class="form-group mb-3">
                                    <input class="form-control" type="file" name="fuptugas" id="fileupload" />
                                    <p class="warningnya text-danger text-left"></p>
                                </div>

                                <!-- Input untuk menyimpan kd_guru -->
                                <div class="form-group mb-3">
                                    <input type="hidden" name="kd_guru" value="<?php echo $_SESSION['kode'] ?>">
                                </div>
                                <!-- Tombol untuk membatalkan dan menyimpan tugas baru -->
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <?php
                }
                ?>

            </div>
            <div class="col-md-8 col-sm-12">
                <div class="card border-secondary mb-3">
                    <!-- Bagian Header Card -->
                    <div class="card-header text-bg-secondary">
                        DATA TUGAS
                    </div>
                    <!-- Bagian Body Card -->
                    <div class="card-body">
                        <!-- Tabel untuk Menampilkan Data Tugas -->
                        <table id="datatablesSimple">
                            <!-- Bagian Header Tabel -->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Tugas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Belum</th>
                                    <th>Dikoreksi</th>
                                    <th>Dinilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <!-- Bagian Body Tabel -->
                            <tbody>
                                <!-- Memulai PHP untuk Memproses Data Tugas -->
                                <?php
                                // Fungsi untuk menghitung jumlah siswa berdasarkan status kerja tugas
                                function jmlSiswa($kd, $cn, $sts)
                                {
                                    $a = "SELECT nis FROM kerja_tugas WHERE kd_tugas='$kd' AND status_kerja='$sts'";
                                    $j = mysqli_num_rows(mysqli_query($cn, $a));
                                    return $j;
                                }

                                // Query untuk mengambil data tugas
                                $q = "SELECT tugas.nama_tugas, tugas.file, tugas.batas_ahir, tugas.tgl_up, mapel.nama_mapel, tugas.kd_tugas, kelas.nama_kelas 
                        FROM tugas, pengajaran as p, mapel, kelas 
                        WHERE p.kd_mapel=tugas.kd_mapel AND tugas.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=tugas.kd_kelas AND p.kd_kelas=kelas.kd_kelas AND p.kd_guru LIKE '%$_SESSION[kode]%'";

                                // Penyesuaian query berdasarkan parameter mp (mata pelajaran) dan kls (kelas)
                                if (isset($_GET['mp']) and isset($_GET['kls'])) {
                                    $q .= " AND tugas.kd_mapel='$_GET[mp]' AND tugas.kd_kelas='$_GET[kls]'";
                                }

                                // Eksekusi query dan penanganan hasilnya
                                $tugas = mysqli_query($connect, $q);
                                if (mysqli_num_rows($tugas) > 0) {
                                    $n = 1;
                                    while ($rtugas = mysqli_fetch_array($tugas)) {
                                        // Menampilkan baris data tugas ke dalam tabel
                                        echo "<tr>
                                <td>$n</td>
                                <td>$rtugas[nama_tugas]</td>
                                <td>$rtugas[nama_mapel]</td>
                                <td>$rtugas[nama_kelas]</td>";

                                        // Menghitung jumlah siswa untuk setiap status kerja tugas
                                        $jb = jmlSiswa($rtugas['kd_tugas'], $connect, 'T');
                                        $jk = jmlSiswa($rtugas['kd_tugas'], $connect, 'K');
                                        $jn = jmlSiswa($rtugas['kd_tugas'], $connect, 'N');

                                        // Menampilkan jumlah siswa pada kolom Belum, Dikoreksi, dan Dinilai
                                        echo "<td>$jb </td>";
                                        echo "<td>$jk </td>";
                                        echo "<td>$jn </td>
                                <td>
                                    <!-- Tombol Aksi (Hapus, Edit, Detail) -->
                                    <a href='modul/mod_tugas/aksi.php?act=del&id=$rtugas[kd_tugas]' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></a>
                                    <a href='?module=tugas&eid=$rtugas[kd_tugas]' class='btn btn-warning btn-sm mt-1'><i class='fa-solid fa-pen-to-square'></i></a>  
                                    <a href='?module=detailtugas&kd=$rtugas[kd_tugas]' class='btn btn-info btn-sm mt-1'><i class='fa-solid fa-marker'></i></a>
                                </td>
                            </tr>";
                                        ?>
                                        <!-- Menginkrementasi variabel n -->
                                        <?php
                                        $n++;
                                    }
                                } else {
                                    // Menampilkan pesan jika belum ada tugas diupload
                                    echo "<tr><td colspan='8'>Belum ada Tugas diupload</td></tr>";
                                }
                                ?>
                                <!-- Menutup PHP setelah selesai memproses data -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php } ?>