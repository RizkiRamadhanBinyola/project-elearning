<?php
// Menggunakan file koneksi.php untuk terhubung ke database
include "../../../koneksi/koneksi.php";

// Menetapkan zona waktu default
date_default_timezone_set("Asia/Bangkok");

// Memeriksa apakah variabel 'act' telah diatur dalam parameter URL ($_GET)
if (isset($_GET['act'])) {
    // Memulai switch berdasarkan nilai 'act'
    switch ($_GET['act']) {
        // case 'tbjawab': Menangani pengunggahan jawaban tugas
        case 'tbjawab':
            // Mendapatkan nilai kd_kerja dan kd_tugas dari data yang dikirim melalui metode POST
            $kd = isset($_POST['kd_kerja']) ? $_POST['kd_kerja'] : '';
            $kdt = isset($_POST['kd_tugas']) ? $_POST['kd_tugas'] : '';
            
            // Menentukan direktori tempat menyimpan file jawaban tugas
            $temp = "../../files/kerja_tugas/";

            // Membuat direktori jika tidak ada
            if (!file_exists($temp)) {
                mkdir($temp);
            }

            // Mendefinisikan array untuk menyimpan nama file
            $namafile = [];

            // Iterasi melalui file yang diunggah
            foreach ($_FILES as $file) {
                $fileupload = $file['tmp_name'];
                $filename = $file['name'];

                // Memeriksa apakah file tidak kosong
                if (!empty($fileupload)) {
                    $filext = pathinfo($filename, PATHINFO_EXTENSION);
                    $newfilename = $kd . '_' . uniqid() . '.' . $filext; // Menggunakan uniqid untuk memastikan nama file unik
                    $namafile[] = $newfilename;
                    move_uploaded_file($fileupload, $temp . $newfilename);
                }
            }

            // Menggabungkan nama file menjadi string terpisah koma
            $newfilename = implode(",", $namafile);

            // Memperbarui tabel kerja_tugas dengan nama file yang diunggah dan status_kerja menjadi 'K' (dalam proses koreksi)
            $qup = "UPDATE kerja_tugas SET file_kerja='$newfilename', status_kerja='K' WHERE kd_kerja='$kd'";

            // Mengeksekusi query dan menangani hasilnya
            if (mysqli_query($connect, $qup)) {
                // Menampilkan pesan sukses dan mengarahkan ke halaman detail tugas
                echo "<script>alert('Berhasil mengunggah jawaban tugas'); location='../../media.php?module=detailtugas&kd=$kdt'</script>";
            } else {
                // Menampilkan pesan kesalahan dan mengarahkan kembali ke halaman detail tugas
                echo "<script>alert('Terjadi Kesalahan'); location='location:../../media.php?module=detailtugas&kd=$kdt';</script>";
            }
            break;

        // case default: Menangani situasi di mana nilai 'act' tidak sesuai dengan yang diharapkan
        default:
            echo "error";
            break;
    }
}
?>
