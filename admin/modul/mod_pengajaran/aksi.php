<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../../koneksi/koneksi.php";

// Cek apakah parameter 'act' telah di-set
if (isset($_GET['act'])) {
    // Switch case untuk memproses berbagai aksi
    switch ($_GET['act']) {
        case 'add':
            // Cek apakah kd_kls tidak di-set atau kosong
            if (!isset($_POST['kd_kls']) or empty($_POST['kd_kls'])) {
                echo "<script>alert('Gagal karena Tidak memilih kelas '); location='../../media.php?module=pengajaran'</script>";
            }

            // Ambil nilai variabel-variabel dari $_POST
            $kd_mapel = $_POST['kd_mapel'];
            $kd_kelas = $_POST['kd_kls'];
            $kd_guru = $_POST['kd_guru'];

            // Fungsi untuk mengecek apakah sudah ada pengajar untuk matapelajaran dan kelas tersebut
            function cek_pengajar($con, $mp, $kls)
            {
                $query = mysqli_query($con, "SELECT kd_guru FROM pengajaran WHERE kd_mapel='$mp' AND kd_kelas='$kls'");
                return mysqli_num_rows($query) > 0;
            }

            // Cek apakah $kd_kelas adalah array
            if (is_array($kd_kelas)) {
                foreach ($kd_kelas as $kd) {
                    // Cek apakah sudah ada pengajar untuk matapelajaran dan kelas tersebut
                    if (cek_pengajar($connect, $kd_mapel, $kd)) {
                        echo "<script>alert('GAGAL karena sudah ada pengajar untuk matapelajaran dan kelas tersebut'); location='../../media.php?module=pengajaran'</script>";
                        exit; // Keluar dari script untuk menghindari eksekusi lebih lanjut
                    }

                    // Cek apakah kd_guru sudah ada
                    $cek = cek_pengajar($connect, $kd_mapel, $kd);
                    switch ($cek) {
                        case '0':
                            $kd_insert = $kd_guru;
                            $qins = mysqli_query($connect, "INSERT INTO pengajaran (kd_mapel, kd_kelas, kd_guru) VALUES ('$kd_mapel', '$kd', '$kd_insert')");
                            if ($qins) {
                                echo "<script>alert('Berhasil menambah pengajar matapelajaran'); location='../../media.php?module=pengajaran'</script>";
                            } else {
                                echo "<script>alert('GAGAL'); location='../../media.php?module=pengajaran'</script>";
                            }
                            break;

                        default:
                            echo "<script>alert('GAGAL karena sudah ada pengajar untuk matapelajaran dan kelas tersebut'); location='../../media.php?module=pengajaran'</script>";
                            break;
                    }
                }
            } else {
                // Handle jika $kd_kelas bukan array
                echo "<script>alert('Gagal karena format kelas tidak valid'); location='../../media.php?module=pengajaran'</script>";
            }
            break;

        case 'update':
            // Cek apakah request method adalah POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Ambil data terbaru dari form
                $kd_pengajaran = $_POST['kd_pengajaran'];
                $kd_mapel = $_POST['kd_mapel'];
                $kd_kelas = $_POST['kd_kelas'];
                $kd_guru = $_POST['kd_guru'];

                // Fungsi untuk mengecek apakah guru sudah diajarkan untuk mata pelajaran dan kelas yang dipilih
                function cek_pengajar($con, $mp, $kls, $guru)
                {
                    $query = mysqli_query($con, "SELECT kd_guru FROM pengajaran WHERE kd_mapel='$mp' AND kd_kelas='$kls'");
                    $result = mysqli_fetch_assoc($query);

                    if ($result) {
                        $existingGurus = explode(",", $result['kd_guru']);
                        return in_array($guru, $existingGurus);
                    }

                    return false;
                }

                // Cek apakah guru sudah diajarkan untuk mata pelajaran dan kelas yang dipilih
                if (cek_pengajar($connect, $kd_mapel, $kd_kelas, $kd_guru)) {
                    echo "<script>alert('GAGAL karena sudah ada pengajar untuk matapelajaran dan kelas tersebut'); location='../../media.php?module=pengajaran'</script>";
                    exit; // Keluar dari script untuk menghindari eksekusi lebih lanjut
                }

                // Lakukan query untuk update data
                $updateQuery = "UPDATE pengajaran SET kd_mapel='$kd_mapel', kd_kelas='$kd_kelas', kd_guru='$kd_guru' WHERE kd_pengajaran='$kd_pengajaran'";
                $updateResult = mysqli_query($connect, $updateQuery);

                if ($updateResult) {
                    echo "<script>alert('Berhasil update data'); location='../../media.php?module=pengajaran'</script>";
                } else {
                    echo "<script>alert('GAGAL update data'); location='../../media.php?module=pengajaran'</script>";
                }
            }
            break;

        case 'del':
            // Ambil nilai parameter 'kd' dan 'kdg'
            $kd = $_GET['kd'];
            $kdg = $_GET['kdg'];

            // Query untuk mengambil kd_guru dari pengajaran dengan kd_pengajaran tertentu
            $query = mysqli_query($connect, "SELECT kd_guru FROM pengajaran WHERE kd_pengajaran='$kd'");
            $jum = mysqli_num_rows($query);
            $pengajar = mysqli_fetch_array($query);

            // Jika jumlah hasil query lebih dari 0
            if ($jum > 0) {
                // Pisahkan kd_guru menjadi array
                $cekjumpengajar = explode(",", $pengajar['kd_guru']);
                $jpengajar = count($cekjumpengajar);

                // Jika jumlah kd_guru adalah 2
                if ($jpengajar == 2) {
                    // Hapus kd_guru yang sesuai dengan nilai 'kdg'
                    if (($key = array_search($kdg, $cekjumpengajar)) !== false) {
                        unset($cekjumpengajar[$key]);
                        $newkdgp = implode(",", $cekjumpengajar);
                    }

                    // Update pengajaran dengan kd_guru yang baru
                    $qup = "UPDATE pengajaran SET kd_guru='$newkdgp' WHERE kd_pengajaran='$kd'";
                    $updt = mysqli_query($connect, $qup);

                    // Tampilkan pesan berhasil atau gagal
                    if ($updt) {
                        echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=pengajaran'</script>";
                    } else {
                        echo "<script>alert('GAGAL'); location='../../media.php?module=pengajaran'</script>";
                    }
                } else {
                    // Jika jumlah kd_guru bukan 2, hapus data pengajaran
                    $qdel = "DELETE FROM pengajaran WHERE kd_pengajaran='$kd'";
                    $del = mysqli_query($connect, $qdel);

                    // Tampilkan pesan berhasil atau gagal
                    if ($del) {
                        echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=pengajaran'</script>";
                    } else {
                        echo "<script>alert('GAGAL'); location='../../media.php?module=pengajaran'</script>";
                    }
                }
            } else {
                // Jika tidak ada data yang ditemukan
                echo "<script>alert('GAGAL data tidak ditemukan'); location='../../media.php?module=pengajaran'</script>";
            }
            break;

        default:
            // Do nothing
            break;
    }
} else {
    // Do nothing
}
