<?php
if (empty($_SESSION['username']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
}
?>
<!-- Navbar -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand mx-5" href="#">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/31/Logo-smkterataiputihglobal.png" alt="Logo"
            width="30" height="24" class="d-inline-block align-text-top">
        Dashboard
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>

</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <?php
                    switch ($_SESSION['level']) {
                        case 'admin':
                            ?>
                            <!-- ========================= NAVBAR ADMIN START =========================== -->
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?php if ($_GET['module'] == 'homeadm') {
                                echo "open";
                            } ?>" href="media.php?module=homeadm">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                Home
                            </a>
                            <a class="nav-link <?php if ($_GET['module'] == 'regadmin') {
                                echo "open";
                            } ?>" href="media.php?module=regadmin">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                                RegAdmin
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                                aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                                Guru
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php if ($_GET['module'] == 'guru') {
                                        echo "open";
                                    } ?>" href="media.php?module=guru">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/guru.png" alt="Guru" width="20"
                                                height="20"></div>
                                        Guru
                                    </a>
                                    <a class="nav-link <?php if ($_GET['module'] == 'pengajaran') {
                                        echo "open";
                                    } ?>" href="media.php?module=pengajaran">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/guru-mapel.png" alt="Guru Mapel"
                                                width="20" height="20"></div>
                                        Guru Mapel
                                    </a>
                                </nav>
                            </div>
                            <!-- Dropdown 2 -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                                aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Siswa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link <?php if ($_GET['module'] == 'siswa') {
                                        echo "open";
                                    } ?>" href="media.php?module=siswa">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/siswa.png" alt="Siswa"
                                                width="20" height="20"></div>
                                        Siswa
                                    </a>
                                    <a class="nav-link <?php if ($_GET['module'] == 'kelas') {
                                        echo "open";
                                    } ?>" href="media.php?module=kelas">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/kelas.png" alt="Kelas"
                                                width="20" height="20"></div>
                                        Kelas
                                    </a>
                                    <a class="nav-link <?php if ($_GET['module'] == 'jurusan') {
                                        echo "open";
                                    } ?>" href="media.php?module=jurusan">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/jurusan.png" alt="Jurusan"
                                                width="20" height="20"></div>
                                        Jurusan
                                    </a>
                                    <a class="nav-link <?php if ($_GET['module'] == 'rombel') {
                                        echo "open";
                                    } ?>" href="media.php?module=rombel">
                                        <div class="sb-nav-link-icon"><img src="assets/img/icon/jurusan.png" alt="Jurusan"
                                                width="20" height="20"></div>
                                        Rombel
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link <?php if ($_GET['module'] == 'tahun') {
                                echo "open";
                            } ?>" href="media.php?module=tahun">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                                Tahun pelajaran
                            </a>

                            <a class="nav-link <?php if ($_GET['module'] == 'mapel') {
                                echo "open";
                            } ?>" href="media.php?module=mapel">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                Mapel
                            </a>

                            <!-- ======================== NAVBAR ADMIN END =====================================-->

                            <!-- ========================= NAVBAR GURU START ======================== NAVBAR GURU START ========================== -->
                            <?php
                                            break;
                                        case 'guru':
                                        ?>
                                            <!-- Start Admin Sidebar Navigasi -->
                                            <div class="sb-sidenav-menu-heading">Core</div>
                                            <a class="nav-link <?php if ($_GET['module'] == 'home') {
                                                                    echo "open";
                                                                } ?>" href="media.php?module=home">
                                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                                Home
                                            </a>
                                            <a class="nav-link <?php if ($_GET['module'] == 'materi') {
                                                                    echo "open";
                                                                } ?>" href="media.php?module=materi">
                                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                                                Materi
                                            </a>
                                            <a class="nav-link <?php if ($_GET['module'] == 'tugas') {
                                                                    echo "open";
                                                                } ?>" href="media.php?module=tugas">
                                                <div class="sb-nav-link-icon"><i class="fa-regular fa-rectangle-list"></i></div>
                                                Tugas
                                            </a>
                            <!-- ========================= NAVBAR GURU END ======================== NAVBAR GURU END ========================== -->

                            <!-- ========================= NAVBAR SISWA START ======================== NAVBAR SISWA START ========================== -->
                            <?php
                            break;
                        case 'siswa':
                            ?>

                            <a class="nav-link <?php if ($_GET['module'] == 'home') {
                                echo "open";
                            } ?>" href="media.php?module=home">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                Home
                            </a>

                            <a class="nav-link <?php if ($_GET['module'] == 'materi') {
                                echo "open";
                            } ?>" href="media.php?module=materi&mp=all">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                Materi
                            </a>

                            <a class="nav-link <?php if ($_GET['module'] == 'tugas') {
                                echo "open";
                            } ?>" href="media.php?module=tugas&mpl=all">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-pencil"></i></div>
                                Tugas
                            </a>

                            <!-- ========================= NAVBAR SISWA END ======================== NAVBAR SISWA END ========================== -->

                            <?php
                            break;
                        default:
                            echo "Anda belum login";
                            break;
                    }
                    if ($_SESSION['level'] == 'guru') {
                        ?>
                        <a class="nav-link" href="../logout.php"
                            onclick="return confirm('Pastikan Anda Sudah Mengisi Jurnal Harian!! ');">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="nav-link" href="../logout.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">
                    <?= $_SESSION['username']; ?> Sebagai
                    <?= $_SESSION['level'] ?>
                </div>
            </div>
        </nav>
    </div>