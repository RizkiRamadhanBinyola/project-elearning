<?php
// Mulai sesi untuk mengakses variabel-variabel sesi
session_start();
// Sertakan file koneksi.php untuk menghubungkan ke database
include "../koneksi/koneksi.php";

// Periksa apakah variabel sesi 'username' dan 'level' tidak kosong
if (empty($_SESSION['username']) || empty($_SESSION['level'])) {
    // Jika kosong, tampilkan pesan kesalahan dan kembalikan ke halaman index.php
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
} else {
    // Jika sesi 'username' dan 'level' tidak kosong, lanjutkan dengan mengeksekusi kode berikutnya

    // Query untuk mendapatkan data tahun ajaran yang aktif
    $qtj = "SELECT * FROM tahun_ajar WHERE aktif='Y'";
    $result = mysqli_query($connect, $qtj);

    if ($result) {
        // Jika query berhasil dieksekusi, ambil data tahun ajaran
        $tj = mysqli_fetch_array($result);
        if ($tj) {
            // Jika data tahun ajaran ditemukan, set variabel berdasarkan data tersebut
            $kd_tajar = $tj['kd_tajar'];
            $namatajar = $tj['tahun_ajar'] . " Semester " . $tj['kd_semester'];
        } else {
            // Jika data tahun ajaran tidak ditemukan, tampilkan pesan kesalahan
            echo "<script>alert('Data tahun ajar tidak ditemukan!.');</script>";
        }
    } else {
        // Jika terjadi kesalahan dalam menjalankan query, tampilkan pesan kesalahan
        echo "Terjadi kesalahan dalam menjalankan query.";
    }

    // Set variabel untuk judul berdasarkan halaman saat ini
    $pageTitle = "Your Default Title"; // Set judul default
    if (isset($_GET['module'])) {
        $pageTitle = ucfirst($_GET['module']); // Set judul berdasarkan parameter module
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title><?php echo $pageTitle; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
            <link href="assets/css/styles.css" rel="stylesheet" />
            <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body class="sb-nav-fixed">

            <!-- Navbar -->
            <?php include 'navbar.php'; ?>
        
                <div id="layoutSidenav_content">
                    <!-- Start Body Content -->
                    <main>
                        <?php
                        include 'content.php';
                        ?>
                    </main>
                    <!-- End Body Content -->
                <?php include 'footer.php'; ?>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="assets/js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="assets/demo/chart-area-demo.js"></script>
            <script src="assets/demo/chart-bar-demo.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="assets/js/datatables-simple-demo.js"></script>
    
    
        </body>
    </html>
<?php } ?>
