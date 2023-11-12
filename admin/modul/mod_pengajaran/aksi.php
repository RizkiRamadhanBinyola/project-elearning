<?php
include "../../../koneksi/koneksi.php";

if (isset($_GET['act'])) {
	switch ($_GET['act']) {
		case 'add':
			if (!isset($_POST['kd_kls']) or empty($_POST['kd_kls'])) {
				echo "<script>alert('Gagal karena Tidak memilih kelas '); location='../../media.php?module=pengajaran'</script>";
			}
			$kd_mapel = $_POST['kd_mapel'];
			$kd_kelas = $_POST['kd_kls'];
			$kd_guru = $_POST['kd_guru'];

			function cek_pengajar($con, $mp, $kls)
			{
				$query = mysqli_query($con, "SELECT kd_guru FROM pengajaran WHERE kd_mapel='$mp' AND kd_kelas='$kls'");
				return mysqli_num_rows($query) > 0;
			}

			if (is_array($kd_kelas)) {
				foreach ($kd_kelas as $kd) {
					//cek kd_guru
					if (cek_pengajar($connect, $kd_mapel, $kd)) {
						echo "<script>alert('GAGAL karena sudah ada pengajar untuk matapelajaran dan kelas tersebut'); location='../../media.php?module=pengajaran'</script>";
						exit; // exit the script to prevent further execution
					}

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
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Extract the updated data from the form
				$kd_pengajaran = $_POST['kd_pengajaran'];
				$kd_mapel = $_POST['kd_mapel'];
				$kd_kelas = $_POST['kd_kelas'];
				$kd_guru = $_POST['kd_guru'];
				// Define the cek_pengajar function
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

				// Check if the teacher is already assigned to teach the subject in the selected class
				if (cek_pengajar($connect, $kd_mapel, $kd_kelas, $kd_guru)) {
					echo "<script>alert('GAGAL karena sudah ada pengajar untuk matapelajaran dan kelas tersebut'); location='../../media.php?module=pengajaran'</script>";
					exit; // exit the script to prevent further execution
				}

				// Perform the update query
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
			$kd = $_GET['kd'];
			$kdg = $_GET['kdg'];

			$query = mysqli_query($connect, "SELECT kd_guru FROM pengajaran WHERE kd_pengajaran='$kd'");
			$jum = mysqli_num_rows($query);
			$pengajar = mysqli_fetch_array($query);
			if ($jum > 0) {
				$cekjumpengajar = explode(",", $pengajar['kd_guru']);
				$jpengajar = count($cekjumpengajar);
				if ($jpengajar == 2) {
					if (($key = array_search($kdg, $cekjumpengajar)) !== false) {
						unset($cekjumpengajar[$key]);
						$newkdgp = implode(",", $cekjumpengajar);
					}
					$qup = "UPDATE pengajaran SET kd_guru='$newkdgp' WHERE kd_pengajaran='$kd'";
					$updt = mysqli_query($connect, $qup);
					if ($updt) {
						echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=pengajaran'</script>";
					} else {
						echo "<script>alert('GAGAL'); location='../../media.php?module=pengajaran'</script>";
					}
				} else {
					$qdel = "DELETE FROM pengajaran WHERE kd_pengajaran='$kd'";
					$del = mysqli_query($connect, $qdel);
					if ($del) {
						echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=pengajaran'</script>";
					} else {
						echo "<script>alert('GAGAL'); location='../../media.php?module=pengajaran'</script>";
					}
				}
			} else {
				echo "<script>alert('GAGAL data tidak ditemukan'); location='../../media.php?module=pengajaran'</script>";
			}
			break;

		default:
			# code...
			break;
	}
} else {

}
