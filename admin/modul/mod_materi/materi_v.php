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
// Memasukkan file koneksi.php untuk mengakses database
include "../koneksi/koneksi.php";

// Pengecekan apakah user sudah login atau belum
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    // Jika belum login, maka munculkan pesan dan redirect ke halaman index.php
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
    // Mengambil data dari database untuk mendapatkan kode terbaru
    $query = "SELECT MAX(kd_materi) as max_kd_materi FROM materi";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($result);

    if (empty($data['max_kd_materi'])) {
        // Jika kd_materi kosong, atur kode awal
        $kd_materi = 'KM-001'; // Atur kode awal sesuai dengan kebutuhan Anda
    } else {
        $kodeawal = substr($data['max_kd_materi'], 3) + 1;
        $kd_materi = 'KM-' . sprintf('%03d', $kodeawal);
    }

    // Pengecekan apakah form telah disubmit (metode POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil data dari form
        $nama_materi = isset($_POST['nama_materi']) ? $_POST['nama_materi'] : "";
        $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : "";
        $ForL = isset($_POST['ForL']) ? $_POST['ForL'] : "";
        $tgl_up = date('Y-m-d H:i:s');
        $kd_mapel = isset($_POST['kd_mapel']) ? $_POST['kd_mapel'] : "";
        $kd_kelas = isset($_POST['kd_kelas']) ? $_POST['kd_kelas'] : "";
        $kd_guru = isset($_POST['kd_guru']) ? $_POST['kd_guru'] : "";

        // Check if it's a "link"
        if ($ForL === 'link') {
            $file = $_POST['linkmateri'];
        } else {
            // For "file", get the file name and handle file upload
            $file_info = $_FILES['filemateri'];
            $file = $file_info['name'];

            // Path tempat file akan disimpan
            $target_directory = "files/materi/";
            $target_file = $target_directory . basename($file);

            // Check for file upload success
            if (move_uploaded_file($file_info['tmp_name'], $target_file)) {
                echo "File berhasil diunggah.<br>";
            } else {
                echo "<script>alert('Gagal menyimpan file'); window.location = 'media.php?module=materi'</script>";
                exit; // Exit the script on failure to avoid database insertion
            }
        }

        // Check for duplicate entry
        $existingEntry = $connect->prepare("SELECT * FROM materi WHERE kd_materi = ?");
        $existingEntry->bind_param("s", $kd_materi);
        $existingEntry->execute();
        $result = $existingEntry->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Duplikasi entri'); window.location = 'media.php?module=materi'</script>";
            exit; // Exit the script if there's a duplicate entry
        }

        // Insert data into the database
        $stmt = $connect->prepare("INSERT INTO materi (kd_materi, nama_materi, deskripsi, ForL, materi, tgl_up, kd_mapel, kd_kelas, kd_guru) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $kd_materi, $nama_materi, $deskripsi, $ForL, $file, $tgl_up, $kd_mapel, $kd_kelas, $kd_guru);

        if ($stmt->execute()) {
            echo "<script>alert('Berhasil'); window.location = 'media.php?module=materi'</script>";
        } else {
            echo "<script>alert('Gagal menyimpan ke database: " . $stmt->error . "'); window.location = 'media.php?module=materi'</script>";
        }
        $stmt->close();
    }
    ?>

    <!-- HTML untuk form tambah materi -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card border-secondary mb-3">
                    <div class="card-header text-bg-secondary">
                        Tambah Materi
                    </div>
                    <div class="card-body">
                        <!-- Form untuk input data materi -->
                        <form role="form" name="fupmateri" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>" enctype="multipart/form-data">
                            <!-- Dropdown untuk memilih mata pelajaran -->
                            <div class="form-group mb-3">
                                <select name="kd_mapel" class="form-control" id="cbbmapel" data-guru="<?php echo $_SESSION['kode'] ?>">
                                    <option selected="selected">Pilih Mata Pelajaran</option>
                                    <?php
                                    $qmapel = "SELECT m.nama_mapel,m.kd_mapel 
                        FROM pengajaran as p, mapel as m 
                        WHERE m.kd_mapel=p.kd_mapel AND p.kd_guru LIKE '%$_SESSION[kode]%' 
                        GROUP BY p.kd_mapel";
                                    $datamapel = mysqli_query($connect, $qmapel);
                                    while ($mapel = mysqli_fetch_array($datamapel)) { ?>
                                        <option value="<?= $mapel["kd_mapel"] ?>">
                                            <?= $mapel["kd_mapel"] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Dropdown untuk memilih kelas -->
                            <div class="form-group mb-3">
                                <select name="kd_kelas" class="form-control" id="cbbkelas" data-guru="<?php echo $_SESSION['kode'] ?>">
                                    <option selected="selected">Pilih Kelas</option>
                                    <?php
                                    $qkelas = "SELECT nama_kelas, kd_kelas FROM kelas";
                                    $datakelas = mysqli_query($connect, $qkelas);
                                    while ($kelas = mysqli_fetch_array($datakelas)) { ?>
                                        <option value="<?php echo $kelas['kd_kelas']; ?>">
                                            <?php echo $kelas['nama_kelas']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Input judul materi -->
                            <div class="form-group mb-3">
                                <input class="form-control" type="text" name="nama_materi" required="" placeholder="Judul Materi" />
                            </div>
                            <!-- Input deskripsi materi -->
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="deskripsi" rows="3" required="" placeholder="Deskripsi Materi" ></textarea>
                            </div>
                            <!-- Dropdown untuk memilih bentuk materi (file/link) -->
                            <div class="form-group mb-3">
                                <select name="ForL" class="form-control" id="cbbForL">
                                    <option value="file" selected="selected">FILE</option>
                                    <option value="link">LINK</option>
                                </select>
                            </div>
                            <!-- Input file atau link materi sesuai pilihan di dropdown -->
                            <div class="form-group mb-3">
                                <div id="ForL">
                                    <input class="form-control" type="file" name="filemateri" id="filemateri" />
                                    <input class="form-control" type="text" name="linkmateri" id="linkmateri" placeholder="Link Materi" />
                                </div>
                                <p class="warningnya text-danger text-left"></p>
                            </div>
                            <!-- Input hidden untuk menyimpan kode guru dan aksi yang dilakukan -->
                            <div class="form-group mb-3">
                                <input type="hidden" name="kd_guru" value="<?php echo $_SESSION['kode'] ?>">
                                <input type="hidden" name="act" value="tbmateri">
                            </div>
                            <!-- Tombol untuk submit form -->
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tabel untuk menampilkan data materi -->
            <div class="col-md-8 col-sm-12">
                <div class="card border-secondary mb-3">
                    <div class="card-header text-bg-secondary">
                        Tabel Materi
                    </div>
                    <div class="card-body">
                        <!-- Tabel untuk menampilkan data materi -->
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Kelas</th>
                                    <th>Pelajaran</th>
                                    <th>Materi</th>
                                    <th>Bentuk materi</th>
                                    <th>Tanggal Posting</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="bag-data">
                                    <?php
                                    // Query untuk mengambil data materi dari database
                                    $q = "SELECT materi.ForL, materi.nama_materi, materi.materi, 
                    materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas 
                    FROM materi, pengajaran as p, mapel, kelas 
                    WHERE p.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel 
                    AND kelas.kd_kelas=materi.kd_kelas AND p.kd_kelas=kelas.kd_kelas 
                    and p.kd_guru like '%$_SESSION[kode]%'
                    ";
                                    // Filter data jika parameter mp dan kls ada di URL
                                    if (isset($_GET['mp']) and isset($_GET['kls'])) {
                                        $q .= " AND materi.kd_mapel='$_GET[mp]' AND materi.kd_kelas='$_GET[kls]'";
                                    }
                                    $materi = mysqli_query($connect, $q);
                                    if (mysqli_num_rows($materi) > 0) {
                                        $n = 1;
                                        while ($rmateri = mysqli_fetch_array($materi)) {
                                            echo "<tr>
                                                    <td>$n</td>
                                                    <td>$rmateri[nama_materi]</td>
                                                    <td>$rmateri[nama_kelas]</td>
                                                    <td>$rmateri[nama_mapel]</td>";

                                            // Cek jenis materi, apakah file atau link
                                            if ($rmateri['ForL'] == 'file') {
                                                echo "<td><a href='files/materi/$rmateri[materi]' target='_blank' class='btn btn-info btn-sm'>Lihat Materi</a></td>";
                                            } else {
                                                echo "<td><a href='$rmateri[materi]' class='btn btn-primary btn-sm' target='_blank'>Lihat Materi</a></td>";
                                            }

                                            echo "<td>$rmateri[ForL]</td>";

                                            echo "<td>$rmateri[tgl_up]</td>
                                                    <td> <a href='modul/mod_materi/hapus_materi.php?id=$rmateri[kd_materi]' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin Hapus?\")'><i class='fa-solid fa-trash'></a></td>
                                                </tr>";

                                            $n++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Belum ada materi diupload</td></tr>";
                                    }
                                    ?>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk menangani perubahan tampilan input berdasarkan pilihan dropdown -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil elemen-elemen yang akan diubah tampilannya
            var fileInput = document.getElementById('filemateri');
            var linkInput = document.getElementById('linkmateri');

            // Ambil elemen dropdown (select) yang digunakan untuk memilih 'file' atau 'link'
            var selectInput = document.getElementById('cbbForL');

            // Sembunyikan input link awalnya
            linkInput.style.display = 'none';

            // Tambahkan event listener untuk mengubah tampilan input berdasarkan pilihan dropdown
            selectInput.addEventListener('change', function () {
                if (selectInput.value === 'file') {
                    fileInput.style.display = 'block';
                    linkInput.style.display = 'none';
                } else if (selectInput.value === 'link') {
                    fileInput.style.display = 'none';
                    linkInput.style.display = 'block';
                }
            });
        });
    </script>
<?php } ?>