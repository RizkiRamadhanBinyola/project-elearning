<?php
include "../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari form
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = 'admin';
    $last = date('Y-m-d H:i:s');
    $status = $_POST['status'];

    // Set a variable for the title based on the current page
    $pageTitle = "Register Admin";

    $sql = "INSERT INTO login (username, password, level, last, status) VALUES ('$username', '$password', '$level', '$last', '$status')";

    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan'); window.location = 'media.php?module=regadmin'</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
}
?>
<div class="container mt-5">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-secondary">
                            Tambah admin
                        </div>
                        <div class="card-body">
                            <form name="regadmin" role="form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" name="username" required=""
                                        placeholder="Username" />
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" name="password" required=""
                                        placeholder="Password" />
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status </label>
                                    <select class="form-control" name="status">
                                        <option selected hidden disabled>--Pilih Status--</option>
                                        <option value="Aktif">--Aktif--</option>
                                        <option value="NonAktif">--Non Aktif--</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header text-bg-secondary">
                            Tabel admin
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php
                                    // SQL untuk mengambil data admin dari tabel login
                                    $sql = "SELECT * FROM login WHERE level = 'admin'";
                                    $result = $connect->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["username"] . "</td>";
                                            echo "<td>" . $row["level"] . "</td>";
                                            echo "<td>" . $row["status"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>Tidak ada data admin.</td></tr>";
                                    }
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