<?php
include "../../../koneksi/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'tbjawab':
            // Check if the keys are set in the $_POST array
            $kd = isset($_POST['kd_kerja']) ? $_POST['kd_kerja'] : '';
            $kdt = isset($_POST['kd_tugas']) ? $_POST['kd_tugas'] : '';
            $temp = "../../files/kerja_tugas/";

            if (!file_exists($temp)) {
                mkdir($temp);
            }

            $namafile = [];

            foreach ($_FILES as $file) {
                $fileupload = $file['tmp_name'];
                $filename = $file['name'];

                if (!empty($fileupload)) {
                    $filext = pathinfo($filename, PATHINFO_EXTENSION);
                    $newfilename = $kd . '_' . uniqid() . '.' . $filext; // Use uniqid to ensure unique filenames
                    $namafile[] = $newfilename;
                    move_uploaded_file($fileupload, $temp . $newfilename);
                }
            }

            $newfilename = implode(",", $namafile);

            // Update tabel kerja_tugas dengan nama file yang diunggah dan status_kerja menjadi 'K' (dalam proses koreksi)
            $qup = "UPDATE kerja_tugas SET file_kerja='$newfilename', status_kerja='K' WHERE kd_kerja='$kd'";

            if (mysqli_query($connect, $qup)) {
                // Handle success
                echo "<script>alert('Berhasil mengunggah jawaban tugas'); location='../../media.php?module=detailtugas&kd=$kdt'</script>";
            } else {
                // Handle error
                echo "<script>alert('Terjadi Kesalahan'); location='location:../../media.php?module=detailtugas&kd=$kdt';</script>";
            }
            break;

        default:
            echo "error";
            break;
    }
}
?>
