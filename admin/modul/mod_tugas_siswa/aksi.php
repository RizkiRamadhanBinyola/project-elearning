<?php 
include "../../../koneksi/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

if (isset($_GET['act'])){
	switch ($_GET['act']) {
		case 'tbjawab':
			$kd = $_POST['kd_kerja'];
			$kdt = $_POST['kd_tugas'];
			$temp = "../../files/kerja_tugas/";
			
			if (!file_exists($temp)) {
				mkdir($temp);
			}
			
			$namafile = array();
			
			// Cek jumlah file yang diunggah
			$jfile = count($_FILES);
			
			for ($i = 1; $i <= $jfile; $i++) {
				$fileupload = $_FILES['ftugas' . $i]['tmp_name'];
				$filename = $_FILES['ftugas' . $i]['name'];
				$filetype = $_FILES['ftugas' . $i]['type'];
		
				if (!empty($fileupload)) {
					$filext = pathinfo($filename, PATHINFO_EXTENSION);
					$newfilename = $kd . '_' . $i . '.' . $filext;
					$namafile[] = $newfilename;
					move_uploaded_file($fileupload, $temp . $newfilename);
				}
			}
			
			$newfilename = implode(",", $namafile);
		
			// Update tabel kerja_tugas dengan nama file yang diunggah dan status_kerja menjadi 'K' (dalam proses koreksi)
			$qup = "UPDATE kerja_tugas SET file_kerja='$newfilename', status_kerja='K' WHERE kd_kerja='$kd'";
		
			if (mysqli_query($connect, $qup)) {
				// echo "<script>alert('Berhasil mengunggah jawaban tugas'); location='../../media.php?module=detailtugas&kd=$kd'</script>";
			} else {
				echo "<script>alert('Terjadi Kesalahan'); location='location:../../media.php?module=detailtugas&kd=$kd';</script>";
			}
			break;
		

		default:
		echo "error";
		break;
	}
}
?>