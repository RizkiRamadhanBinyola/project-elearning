<?php
include "../koneksi/koneksi.php";

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$namaFile = $_FILES['berkas']['name'];
$x = explode('.', $namaFile);
$ekstensiFile = strtolower(end($x));
$ukuranFile = $_FILES['berkas']['size'];
$file_tmp = $_FILES['berkas']['tmp_name'];

// Lokasi Penempatan file
$dirUpload = "file/";
$linkBerkas = $dirUpload . $namaFile;

// Menyimpan file
$terupload = move_uploaded_file($file_tmp, $linkBerkas);

if ($terupload) {
    $query = "INSERT INTO tb_buku (kode_buku, nama_buku, title, size, ekstensi, berkas) VALUES ('$kode', '$nama', '$namaFile', '$ukuranFile', '$ekstensiFile', '$linkBerkas')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "Upload berhasil!";
        header("Location: index.php", true, 301);
        exit();
    } else {
        echo "Gagal menyimpan data ke database!";
        header("Location: halaman_upload.php", true, 301);
        exit();
    }
} else {
    echo "Upload Gagal!";
    header("Location: halaman_upload.php", true, 301);
    exit();
}
?>
