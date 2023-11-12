<?php
// Include file koneksi.php untuk menghubungkan ke database
include "../../../koneksi/koneksi.php";

// Cek apakah parameter 'act' ada dalam query string
if (isset($_GET['act'])) {
	// Menggunakan switch case untuk mengevaluasi nilai 'act'
	switch ($_GET['act']) {
		// Jika 'act' bernilai 'add'
		case 'add':
			// Cek apakah parameter 'kd_kls' sudah diatur dan tidak kosong
			if (!isset($_POST['kd_kls']) or empty($_POST['kd_kls'])) {
				echo "<script>alert('Gagal karena Tidak memilih kelas '); location='../../media.php?module=home'</script>";
			}

			// Mendapatkan nilai dari beberapa parameter POST
			$kd_mapel = $_POST['kd_mapel'];
			$kd_jrs = $_POST['kd_jurusan'];
			$kd_kelas = $_POST['kd_kls'];
			$kd_guru = $_POST['kd_guru'];

			// Fungsi untuk melakukan pengecekan pengajar
			function cek_pengajar($con, $mp, $kls)
			{
				$query = mysqli_query($con, "SELECT kd_guru FROM pengajaran WHERE kd_mapel='$mp' AND kd_kelas='$kls'");
				if (mysqli_num_rows($query)) {
					$pengajar = mysqli_fetch_array($query);
					$cekjumpengajar = explode(",", $pengajar['kd_guru']);
					$jpengajar = count($cekjumpengajar);
					if ($jpengajar == 1) {
						return 1;
					} else {
						return 2;
					}
				} else {
					return 0;
				}
			}

			// melakukan iterasi untuk setiap nilai dalam array $kd_kelas dan menyimpan nilai saat ini dalam variabel $kd.
			foreach ($kd_kelas as $kd) {
				// Memanggil fungsi cek_pengajar dengan parameter $connect, $kd_mapel, dan $kd. Fungsi ini mengembalikan nilai yang menunjukkan status pengajar untuk mata pelajaran dan kelas tertentu.
				$cek = cek_pengajar($connect, $kd_mapel, $kd);
				// melakukan switch case berdasarkan nilai yang dikembalikan oleh fungsi cek_pengajar.
				switch ($cek) {
					// Jika nilai yang dikembalikan adalah '1', artinya terdapat satu pengajar untuk mata pelajaran dan kelas tersebut.
					case '1':
						// Selanjutnya, kode mengambil data pengajaran dari database menggunakan query SQL dan kemudian menggabungkan kd_guru yang baru dengan yang sudah ada.
						$query = mysqli_query($connect, "SELECT kd_pengajaran,kd_guru FROM pengajaran WHERE kd_mapel='$kd_mapel' AND kd_kelas='$kd'");
						$guru1 = mysqli_fetch_array($query);
						$kd_insert = $guru1['kd_guru'] . ',' . $kd_guru;
						
						// Menggunakan query UPDATE untuk memperbarui data pengajaran dengan kd_guru yang baru.
						$qins = mysqli_query($connect, "UPDATE pengajaran SET kd_guru='$kd_insert' WHERE kd_pengajaran='$guru1[kd_pengajaran]'");
						
						// Jika berhasil, menampilkan pesan sukses menggunakan JavaScript alert dan mengarahkan pengguna ke halaman yang ditentukan. Jika gagal, menampilkan pesan kesalahan.
						if ($qins) {
							echo "<script>alert('Berhasil menambah pengajar matapelajaran'); location='../../media.php?module=home'</script>";
						} else {
							echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
						}
						break;
					// Jika nilai yang dikembalikan adalah '2', artinya pengajar untuk mata pelajaran dan kelas tersebut sudah penuh (maksimal dua guru).
					case '2':
						echo "<script>alert('GAGAL karena sudah penuh'); location='../../media.php?module=home'</script>";
						break;
					case '0':
						$kd_insert = $kd_guru;
						$qins = mysqli_query($connect, "INSERT INTO pengajaran (kd_mapel,kd_kelas,kd_guru) VALUES ('$kd_mapel','$kd','$kd_insert')");
						if ($qins) {
							echo "<script>alert('Berhasil menambah pengajar matapelajaran'); location='../../media.php?module=home'</script>";
						} else {
							echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
						}
						break;
					default:
						echo "<script>alert('GAGAL karena sudah penuh'); location='../../media.php?module=home'</script>";
						break;
				}
			}
			break;

		// Jika 'act' bernilai 'del'
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
						echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=home'</script>";
					} else {
						echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
					}
				} else {
					$qdel = "DELETE FROM pengajaran WHERE kd_pengajaran='$kd'";
					$del = mysqli_query($connect, $qdel);
					if ($del) {
						echo "<script>alert('Berhasil menghapus'); location='../../media.php?module=home'</script>";
					} else {
						echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
					}
				}
			} else {
				echo "<script>alert('GAGAL data tidak ditemukan'); location='../../media.php?module=home'</script>";
			}
			break;

		// Jika 'act' bernilai 'rename'
		case 'rename':
			$kdg = $_POST['kd_guru'];
			$newname = $_POST['nama_baru'];
			$qupd = mysqli_query($connect, "UPDATE guru SET nama='$newname' WHERE kd_guru='$kdg'");
			if ($qupd) {
				echo "<script>alert('Berhasil mengubah nama'); location='../../media.php?module=home'</script>";
			} else {
				echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
			}
			break;

		// Jika 'act' bernilai 'updpass'
		case 'updpass':
			$kdg = $_POST['kd_guru'];
			$username = $_POST['username'];
			$oldpass = md5($_POST['passlama']);
			$newpass1 = md5($_POST['passbaru1']);
			$newpass2 = md5($_POST['passbaru2']);

			$cekpasslama = mysqli_query($connect, "SELECT login.password FROM login,guru WHERE login.username=guru.username AND guru.kd_guru='$kdg' AND login.password='$oldpass'");
			$cek = mysqli_num_rows($cekpasslama);

			if ($cek < 1) {
				echo "<script>alert('GAGAL, password lama salah'); location='../../media.php?module=home'</script>";
			} else {
				if ($newpass1 != $newpass2) {
					echo "<script>alert('GAGAL, Verifikasi password baru tidak cocok'); location='../../media.php?module=home'</script>";
				} else {
					$qupd = mysqli_query($connect, "UPDATE login SET password='$newpass1' WHERE username='$username'");
					if ($qupd) {
						echo "<script>alert('Berhasil mengubah password'); location='../../media.php?module=home'</script>";
					} else {
						echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
					}
				}
			}
			break;

		// Jika 'act' tidak sesuai dengan kasus di atas
		default:
			echo "<script>alert('GAGAL'); location='../../media.php?module=home'</script>";
			break;
	}
}
?>