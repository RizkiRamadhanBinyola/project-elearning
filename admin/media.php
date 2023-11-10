<?php
session_start();
//error_reporting(1);
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) || empty($_SESSION['level'])) {
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
} else {
    $qtj = "SELECT * FROM tahun_ajar WHERE aktif='Y'";
    $result = mysqli_query($connect, $qtj);

    if ($result) {
        $tj = mysqli_fetch_array($result);
        if ($tj) {
            $kd_tajar = $tj['kd_tajar'];
            $namatajar = $tj['tahun_ajar'] . " Semester " . $tj['kd_semester'];
        } else {
            // Handle jika tidak ada baris yang cocok dengan query
            echo "<script>alert('Data tahun ajar tidak ditemukan!.');</script>";
        }
    } else {
        // Handle jika query tidak berhasil
        echo "Terjadi kesalahan dalam menjalankan query.";
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
            <title>Dashboard - Webkolah</title>
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
    
        
            <script>
                function prosesLogin() {
                    let timerInterval
                    Swal.fire({
                        title: 'Auto close alert!',
                        html: 'I will close in <b></b> milliseconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
                }    
            </script>
    
        </body>
    </html>
<?php } ?>
