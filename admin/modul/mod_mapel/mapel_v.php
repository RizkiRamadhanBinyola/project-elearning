<?php
include "../koneksi/koneksi.php";
//  Memeriksa apakah sesi pengguna tidak terisi (empty) atau tidak dalam status login ($_SESSION['login'] == 0). Jika kondisi tidak terpenuhi, pengguna akan diarahkan kembali ke halaman index.php dengan pesan peringatan.
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
} else {
    ?>
    <?php
    // Mengecek apakah terdapat parameter 'action' pada URL dan nilainya adalah 'update'. Jika ya, variabel $update akan diatur menjadi true, dan sebaliknya.
    $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
    // Jika dalam mode update ($update bernilai true), maka kode ini akan mengambil data dari database untuk mata pelajaran yang akan diupdate dan menyimpannya dalam array $row.
    if ($update) {
        $sql = $connect->query("SELECT * FROM mapel WHERE kd_mapel='$_GET[key]'");
        $row = $sql->fetch_assoc();
    }
    // Memeriksa apakah formulir telah dikirim (metode POST). Jika ya, maka data formulir akan diproses.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $submitted_kd_mapel = $_POST["kd_mapel"];
        $original_kd_mapel = isset($_POST["original_kd_mapel"]) ? $_POST["original_kd_mapel"] : null;

        if (!$update) {
            // Insert new data
            $sql = "INSERT INTO mapel (kd_mapel, nama_mapel) VALUES ('$submitted_kd_mapel', '$_POST[nama_mapel]')";
        } else {
            if ($submitted_kd_mapel != $original_kd_mapel) {
                // Check if kd_mapel is different, update accordingly
                $sql = "UPDATE mapel SET kd_mapel='$submitted_kd_mapel', nama_mapel='$_POST[nama_mapel]' WHERE kd_mapel='$original_kd_mapel'";
            } else {
                $sql = "UPDATE mapel SET nama_mapel='$_POST[nama_mapel]' WHERE kd_mapel='$submitted_kd_mapel'";
            }
        }

        if ($connect->query($sql)) {
            echo "<script>alert('Berhasil'); window.location = 'media.php?module=mapel'</script>";
        } else {
            echo "<script>alert('Gagal'); window.location = 'media.php?module=mapel'</script>";
        }
    }
    // Jika parameter 'action' pada URL adalah 'delete', maka akan menghapus data mata pelajaran dari database dan mengarahkan pengguna kembali ke halaman media.php?module=mapel dengan pesan sukses.
    if (isset($_GET['action']) and $_GET['action'] == 'delete') {
        $connect->query("DELETE FROM mapel WHERE kd_mapel='$_GET[key]'");
        echo "<script>alert('Berhasil'); window.location = 'media.php?module=mapel'</script>";
    }
    ?>

    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card border-secondary mb-3">
                            <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
                                <?= ($update) ? "EDIT" : "TAMBAH" ?> MATA PELAJARAN
                            </div>
                            <div class="card-body text-secondary">
                                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" role="form">
                                    <input type="hidden" name="kd_mapel" value="<?= (!$update) ?: $row["kd_mapel"] ?>">

                                    <div class="form-group mb-3">
                                        <label>Kode Mata Pelajaran</label>
                                        <input class="form-control" placeholder="Masukkan Kode Mata Pelajaran"
                                            name="kd_mapel" type="text" <?= (!$update) ?: 'value="' . $row["kd_mapel"] . '"' ?> />
                                        <?php if ($update): ?>
                                            <input type="hidden" name="original_kd_mapel" value="<?= $row["kd_mapel"] ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Mata Pelajaran </label>
                                        <input class="form-control" placeholder="Masukkan Nama Mata Pelajaran"
                                            name="nama_mapel" type="text" <?= (!$update) ?: 'value="' . $row["nama_mapel"] . '"' ?> />
                                    </div>

                                    <button type="submit"
                                        class="btn btn-<?= ($update) ? "success" : "info" ?> btn-block w-100 mb-2">Simpan</button>
                                    <?php if ($update): ?>
                                        <a href="?module=mapel" class="btn btn-danger btn-block w-100">Batal</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="card border-secondary mb-3">
                            <div class="card-header text-bg-secondary">
                                TABEL MATA PELAJARAN
                            </div>
                            <div class="card-body text-secondary">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Nama Mata Pelajaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $no = 1; ?>
                                            <?php if ($query = $connect->query("SELECT * FROM mapel")): ?>
                                                <?php while ($row = $query->fetch_assoc()): ?>
                                                    <td>
                                                        <?php echo $no++; ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['kd_mapel'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['nama_mapel'] ?>
                                                    </td>
                                                    <td class="hidden-print">
                                                        <div class="btn-group">
                                                            <a href="?module=mapel&action=update&key=<?= $row['kd_mapel'] ?>"
                                                                class="btn btn-warning btn-xs">Edit</a>
                                                            <a href="?module=mapel&action=delete&key=<?= $row['kd_mapel'] ?>"
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
