<?php
// Include file koneksi.php untuk menghubungkan ke database
include_once "koneksi/koneksi.php";

// Fungsi anti_injection untuk mengamankan input dari injeksi SQL
function anti_injection($connect, $data) {
    $filter = mysqli_real_escape_string($connect, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter;
}

// Mengamankan input username dan password menggunakan fungsi anti_injection
$username = anti_injection($connect, $_POST['username']);
$pass = md5($_POST['password']); // Menggunakan MD5 untuk mengenkripsi password

// Memastikan username dan password hanya berisi huruf atau angka
if (!ctype_alnum($username) || !ctype_alnum($pass)) {
    // Jika tidak sesuai, tampilkan pesan kesalahan dan kembalikan ke halaman index.php
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
} else {
    // Jika sesuai, lakukan query untuk mencocokkan username dan password pada tabel login
    $login_adm = mysqli_query($connect, "SELECT * FROM login WHERE username='$username' AND password='$pass' AND status='Aktif'");
    $ketemu = mysqli_num_rows($login_adm);
    $r = mysqli_fetch_array($login_adm);

    // Jika ditemukan, set session sesuai dengan level user dan arahkan ke halaman yang sesuai
    if ($ketemu > 0) {
        session_start();
        $_SESSION['username'] = $r['username'];
        $_SESSION['level'] = $r['level'];

        if ($r['level'] == 'guru') {
            // Jika level user adalah 'guru'
            // Query untuk mendapatkan kode guru berdasarkan username
            $qkd = "SELECT kd_guru FROM guru WHERE username='$r[username]'";
            $kd = mysqli_query($connect, $qkd);
            $kode = mysqli_fetch_array($kd);
        
            // Set session 'kode' dengan nilai kode guru
            $_SESSION['kode'] = $kode['kd_guru'];
        
            // Mendapatkan tanggal sekarang dan waktu sekarang
            $qk = date('Y-m-d');
            $q = date('Y-m-d H:i:s');
        
            // Mengarahkan ke halaman home untuk guru
            header('location:admin/media.php?module=home');
        } else if ($r['level'] == 'siswa') {
            // Jika level user adalah 'siswa'
            // Query untuk mendapatkan NIS siswa berdasarkan username
            $qkd = "SELECT nis FROM siswa WHERE nis='$r[username]'";
            $kd = mysqli_query($connect, $qkd);
            $kode = mysqli_fetch_array($kd);
        
            // Set session 'kode' dengan nilai NIS siswa
            $_SESSION['kode'] = $kode['nis'];
        
            // Mengarahkan ke halaman home untuk siswa
            header('location:admin/media.php?module=home');
        } else if ($r['level'] == 'admin') {
            // Jika level user adalah 'admin'
            // Mengarahkan ke halaman homeadm untuk admin
            header('location:admin/media.php?module=homeadm');
        }
    } else {
        // Jika tidak ditemukan, tampilkan pesan kesalahan dan kembalikan ke halaman index.php
        echo "<script>alert('Maaf! Username atau Password anda salah, mohon diulangi kembali'); window.location = 'index.php';</script>";
    }
}
?>
