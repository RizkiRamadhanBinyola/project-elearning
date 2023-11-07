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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    
        $existingEntry = $connect->prepare("SELECT * FROM materi WHERE kd_materi = ?");
        $existingEntry->bind_param("s", $kd_materi);
        $existingEntry->execute();
        $result = $existingEntry->get_result();
    
        if ($result->num_rows > 0) {
            echo "<script>alert('Duplikasi entri'); window.location = 'media.php?module=materi'</script>";
            exit; // Exit the script if there's a duplicate entry
        }
    
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

    <div class="content-wrapper">
        <div class "container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">MANAJEMEN MATERI PELAJARAN</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Upload Materi
                        </div>
                        <div class="panel-body text-center recent-users-sec">
                            <form role="form" name="fupmateri" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <select name="kd_mapel" class="form-control" id="cbbmapel" data-guru="<?php echo $_SESSION['kode'] ?>">
                                        <option selected="selected">Pilih Mata Pelajaran</option>
                                        <?php
                                        $qmapel = "SELECT m.nama_mapel,m.kd_mapel 
                        FROM pengajaran as p, mapel as m 
                        WHERE m.kd_mapel=p.kd_mapel AND p.kd_guru LIKE '%$_SESSION[kode]%' 
                        GROUP BY p.kd_mapel";
                                        $datamapel = mysqli_query($connect, $qmapel);
                                        while ($mapel = mysqli_fetch_array($datamapel)) { ?>
                                            <option value="<?= $mapel["kd_mapel"] ?>"><?= $mapel["kd_mapel"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Untuk Kelas</label>
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select name="kd_kelas" class="form-control" id="cbbkelas" data-guru="<?php echo $_SESSION['kode'] ?>">
                                            <option selected="selected">Pilih Kelas</option>
                                            <?php
                                            $qkelas = "SELECT nama_kelas, kd_kelas FROM kelas";
                                            $datakelas = mysqli_query($connect, $qkelas);
                                            while ($kelas = mysqli_fetch_array($datakelas)) {
                                            ?>
                                                <option value="<?php echo $kelas['kd_kelas']; ?>"><?php echo $kelas['nama_kelas']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input class="form-control" type="text" name="nama_materi" required="" />
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="3" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label>File Atau Link</label>
                                    <select name="ForL" class="form-control" id="cbbForL">
                                        <option value="file" selected="selected">FILE</option>
                                        <option value="link">LINK</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div id="ForL">
                                        <label>Upload File Materi</label>
                                        <input class="form-control" type="file" name="filemateri" id="filemateri" />
                                        <label>Atau Masukkan Link Materi</label>
                                        <input class="form-control" type="text" name="linkmateri" id="linkmateri" />
                                    </div>
                                    <p class="warningnya text-danger text-left"></p>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="kd_guru" value="<?php echo $_SESSION['kode'] ?>">
                                    <input type="hidden" name="act" value="tbmateri">
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Hasil Upload Materi
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
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
                                            $q = "SELECT materi.ForL, materi.nama_materi, materi.materi, 
                    materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas 
                    FROM materi, pengajaran as p, mapel, kelas 
                    WHERE p.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel 
                    AND kelas.kd_kelas=materi.kd_kelas AND p.kd_kelas=kelas.kd_kelas 
                    and p.kd_guru like '%$_SESSION[kode]%'
                    ";
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
                                                
                                                if ($rmateri['ForL'] == 'file') {
                                                    echo "<td><a href='files/materi/$rmateri[materi]' target='_blank' class='btn btn-info btn-xs'>Lihat Materi</a></td>";
                                                } else {
                                                    echo "<td><a href='$rmateri[materi]' class='btn btn-primary btn-xs' target='_blank'>Lihat Materi</a></td>";
                                                }

                                                echo "<td>$rmateri[ForL]</td>";
                                                
                                                echo "<td>$rmateri[tgl_up]</td>
                                                    <td> <a href='modul/mod_materi/hapus_materi.php?id=$rmateri[kd_materi]' class='btn btn-warning btn-xs' onclick='return confirm(\"Yakin Hapus?\")'>Hapus</a></td>
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
        </div>
    </div>

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