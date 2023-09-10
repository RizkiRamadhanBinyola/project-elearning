                <!-- Navbar -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                <!-- Navbar Brand-->
                <a class="navbar-brand mx-5" href="#">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/31/Logo-smkterataiputihglobal.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Dashboard
                </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
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
                            <!-- Start Admin Sidebar Navigasi -->
                                <div class="sb-sidenav-menu-heading">Core</div>
                                <a class="nav-link <?php if ($_GET['module'] == 'homeadm') {echo "open";} ?>" href="media.php?module=homeadm">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                    Home
                                </a>
                                <a class="nav-link <?php if ($_GET['module'] == 'mapel') {echo "open";} ?>" href="media.php?module=tahun">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                                    Tahun pelajaran
                                </a>
                                <a class="nav-link <?php if ($_GET['module'] == 'mapel') {echo "open";} ?>" href="media.php?module=mapel">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                    Mapel
                                </a>
                            <!-- End Admin Sidebar Navigasi -->

                            <?php
                                if($_SESSION['level']=='guru'){
                            ?>
                            <a class="nav-link" href="../logout.php"  onclick = "return confirm('Pastikan Anda Sudah Mengisi Jurnal Harian!! ');">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a>
                            <?php
                                } else {
                            ?>
                                <a class="nav-link" href="../logout.php" >
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a>
                            <?php
                                }
                            ?>
                            

                            <?php
                            
                            }
                            
                            ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>