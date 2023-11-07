<?php
include "../../../koneksi/koneksi.php";

$kd = $_GET['id'];
$qh = "SELECT materi, ForL FROM materi WHERE kd_materi='$kd'";
$qfile = mysqli_query($connect, $qh);
$rfile = mysqli_fetch_array($qfile);

// Periksa tipe materi (file/link) sebelum menghapus
if ($rfile['ForL'] === 'file') {
    $file = "../../files/materi/" . $rfile['materi'];

    // Unlink (delete) the file from the server
    if (file_exists($file)) {
        if (unlink($file)) {
            // File successfully deleted, now delete the database entry
            $q = "DELETE FROM materi WHERE kd_materi='$kd'";
            if (mysqli_query($connect, $q)) {
                $delt = "DELETE FROM timeline WHERE timeline.jenis='materi' AND timeline.id_jenis='$kd'";
                mysqli_query($connect, $delt);
                echo "<script>alert('File dan data Materi berhasil dihapus'); window.location = '../../media.php?module=materi'</script>";
            } else {
                echo "<script>alert('Gagal menghapus data Materi'); window.location = '../../media.php?module=materi'</script>";
            }
        } else {
            // echo "<script>alert('Gagal menghapus file Materi'); window.location = '../../media.php?module=materi'</script>";
        }
    } else {
        echo "<script>alert('File Materi tidak ditemukan'); window.location = '../../media.php?module=materi'</script>";
    }
} elseif ($rfile['ForL'] === 'link') {
    // Jika materi adalah tautan/link, cukup hapus entri database
    $q = "DELETE FROM materi WHERE kd_materi='$kd'";
    if (mysqli_query($connect, $q)) {
        $delt = "DELETE FROM timeline WHERE timeline.jenis='materi' AND timeline.id_jenis='$kd'";
        mysqli_query($connect, $delt);
        echo "<script>alert('Data Materi berhasil dihapus'); window.location = '../../media.php?module=materi'</script>";
    } else {
        echo "<script>alert('Gagal menghapus data Materi'); window.location = '../../media.php?module=materi'</script>";
    }
}
?>
