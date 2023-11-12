<!-- CSS -->
<style type="text/css">
    /* Style untuk efek bayangan saat mouse hover pada elemen dengan class "well" */
    .well:hover {
        box-shadow: 0px 2px 10px rgb(190, 190, 190) !important;
    }

    /* Style untuk warna teks pada elemen <a> */
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

?>

    <?php
    // Pengecekan apakah sedang dalam proses update data
    $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
    if ($update) {
        // Jika dalam proses update, ambil data dari database berdasarkan kunci (key)
        $sql = $connect->query("SELECT * FROM jurusan WHERE kd_jurusan='$_GET[key]'");
        $row = $sql->fetch_assoc();
    }

    // Pengecekan apakah form telah disubmit (metode POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil data dari form
        $kd = mysqli_real_escape_string($connect, $_POST['kd']);
        $nama = htmlspecialchars($_POST['nama']);

        // Membuat query SQL sesuai kondisi (update atau insert)
        if ($update) {
            $sql = "UPDATE jurusan SET nama_jurusan='$nama', kd_jurusan='$kd' WHERE kd_jurusan='$_GET[key]'";
        } else {
            $sql = "INSERT INTO jurusan VALUES ('$kd', '$nama')";
        }

        // Menjalankan query dan mengecek keberhasilannya
        if ($connect->query($sql)) {
            echo "<script>alert('Berhasil'); window.location = 'media.php?module=jurusan'</script>";
        } else {
            echo "<script>alert('Gagal'); window.location = 'media.php?module=jurusan'</script>";
        }
    }

    // Pengecekan apakah terdapat parameter action=delete pada URL
    if (isset($_GET['action']) and $_GET['action'] == 'delete') {
        // Menghapus data dari database berdasarkan kunci (key)
        $connect->query("DELETE FROM jurusan WHERE kd_jurusan='$_GET[key]'");
        echo "<script>alert('Berhasil'); window.location = 'media.php?module=jurusan'</script>";
    }
    ?>

    <!-- HTML untuk form tambah atau edit jurusan -->
    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="row">
                <!-- Kolom untuk form -->
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
                            <?= ($update) ? "EDIT" : "TAMBAH" ?> Jurusan
                        </div>
                        <div class="card-body text-secondary">
                            <!-- Form untuk input data jurusan -->
                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" role="form">
                                <div class="form-group mb-3">
                                    <label>Kode </label>
                                    <!-- Input untuk kode jurusan dengan nilai default jika dalam proses update -->
                                    <input class="form-control" placeholder="Masukkan Kode Jurusan" name="kd" type="text" <?= (!$update) ?: 'value="' . $row["kd_jurusan"] . '"' ?> />
                                </div>
                                <div class="form-group mb-3">
                                    <label>Jurusan </label>
                                    <!-- Input untuk nama jurusan dengan nilai default jika dalam proses update -->
                                    <input class="form-control" placeholder="Masukkan Jurusan" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama_jurusan"] . '"' ?> />
                                </div>

                                <!-- Tombol submit dan tombol batal (hanya muncul saat proses update) -->
                                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                                <?php if ($update) : ?>
                                    <a href="?module=jurusan" class="btn btn-info btn-block">Batal</a>
                                <?php endif; ?>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Kolom untuk menampilkan tabel jurusan -->
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-secondary">
                            TABEL MATA PELAJARAN
                        </div>
                        <div class="card-body text-secondary">
                            <!-- Tabel untuk menampilkan data jurusan -->
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Jurusan</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($query = $connect->query("SELECT * FROM jurusan")) : ?>
                                        <?php while ($row = $query->fetch_assoc()) : ?>
                                            <tr>
                                                <!-- Menampilkan data dalam tabel -->
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['kd_jurusan'] ?></td>
                                                <td><?= $row['nama_jurusan'] ?></td>
                                                <!-- Tombol untuk edit dan hapus data -->
                                                <td class="hidden-print">
                                                    <div class="btn-group">
                                                        <a href="?module=jurusan&action=update&key=<?= $row['kd_jurusan'] ?>" class="btn btn-warning btn-xs">Edit</a>
                                                        <a href="?module=jurusan&action=delete&key=<?= $row['kd_jurusan'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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
