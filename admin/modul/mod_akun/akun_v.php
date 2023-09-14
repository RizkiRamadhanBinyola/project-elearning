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

?>

    <?php
    $update = (isset($_GET['action']) and $_GET['action'] == 'update') ? true : false;
    if ($update) {
        $sql = $connect->query("SELECT * FROM jurusan WHERE kd_jurusan='$_GET[key]'");
        $row = $sql->fetch_assoc();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kd = mysqli_real_escape_string($connect, $_POST['kd']);
        $nama = htmlspecialchars($_POST['nama']);
        if ($update) {
            $sql = "UPDATE jurusan SET nama_jurusan='$nama', kd_jurusan='$kd' WHERE kd_jurusan='$_GET[key]'";
        } else {
            $sql = "INSERT INTO jurusan VALUES ('$kd', '$nama')";
        }
        if ($connect->query($sql)) {
            echo "<script>alert('Berhasil'); window.location = 'media.php?module=akun'</script>";
        } else {
            echo "<script>alert('Gagal'); window.location = 'media.php?module=akun'</script>";
        }
    }
    if (isset($_GET['action']) and $_GET['action'] == 'delete') {
        $connect->query("DELETE FROM jurusan WHERE kd_jurusan='$_GET[key]'");
        echo "<script>alert('Berhasil'); window.location = 'media.php?module=akun'</script>";
    }
    ?>


    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-<?= ($update) ? "success" : "secondary" ?>">
                            <?= ($update) ? "EDIT" : "TAMBAH" ?> Jurusan
                        </div>
                        <div class="card-body text-secondary">
                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" role="form">
                                <div class="form-group mb-3">
                                    <label>Kode </label>
                                    <input class="form-control" placeholder="Masukkan Kode Jurusan" name="kd" type="text" <?= (!$update) ?: 'value="' . $row["kd_jurusan"] . '"' ?> />
                                </div>
                                <div class="form-group mb-3">
                                    <label>Jurusan </label>
                                    <input class="form-control" placeholder="Masukkan Jurusan" name="nama" type="text" <?= (!$update) ?: 'value="' . $row["nama_jurusan"] . '"' ?> />
                                </div>

                                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                                <?php if ($update) : ?>
                                    <a href="?module=akun" class="btn btn-info btn-block">Batal</a>
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
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['kd_jurusan'] ?></td>
                                                <td><?= $row['nama_jurusan'] ?></td>
                                                <td class="hidden-print">
                                                    <div class="btn-group">
                                                        <a href="?module=akun&action=update&key=<?= $row['kd_jurusan'] ?>" class="btn btn-warning btn-xs">Edit</a>
                                                        <a href="?module=akun&action=delete&key=<?= $row['kd_jurusan'] ?>" class="btn btn-danger btn-xs">Hapus</a>
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