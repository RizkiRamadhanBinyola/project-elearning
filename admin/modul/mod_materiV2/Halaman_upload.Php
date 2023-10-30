<?php
include "../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $namaFile = $_FILES['berkas']['name'];
    $x = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($x));
    $ukuranFile = $_FILES['berkas']['size'];
    $file_tmp = $_FILES['berkas']['tmp_name'];

    // Lokasi Penempatan file
    $dirUpload = "E:/xampp/htdocs/project-elearning/admin/modul/mod_materiV2/file/";
    $linkBerkas = $dirUpload . $namaFile;
    

    // Menyimpan file
    $terupload = move_uploaded_file($file_tmp, $linkBerkas);

    if ($terupload) {
        $query = "INSERT INTO tb_buku (kode_buku, nama_buku, title, size, ekstensi, berkas) VALUES ('$kode', '$nama', '$namaFile', '$ukuranFile', '$ekstensiFile', '$linkBerkas')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "Upload berhasil!";
            header("Location: media.php?module=tesmateri", true, 301);
            exit();
        } else {
            echo "Gagal menyimpan data ke database!";
        }
    } else {
        echo "Upload Gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload dan Download File PDF Dengan PHP Dan MySQL</title>
</head>
<body style="width: 800px; margin: auto; padding: 10px;">
    <h2 style="text-align: center;">Form Upload File (PDF)</h2>
    <hr>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
        <b>Kode Buku :</b>
        <input type="text" name="kode" value="" placeholder=""><br /><br />
        <b>Nama Buku:</b>
        <input type="text" name="nama" value="" placeholder=""><br /><br />
        <b>Upload File :</b>
        <input type="file" name="berkas" accept="application/pdf">
        <button type="submit">Upload File</button>
    </form>
    <hr>
</body>
</html>
