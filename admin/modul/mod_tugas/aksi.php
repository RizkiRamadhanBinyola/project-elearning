<?php
include "../../../koneksi/koneksi.php";
date_default_timezone_set("Asia/Bangkok");

// Mengecek apakah terdapat parameter GET dengan nama 'act'. Jika ada, maka proses pada blok tersebut akan dijalankan.
if (isset($_GET['act'])) {

	$s = "scs";
	// Menggunakan struktur switch-case untuk menentukan aksi (act) yang harus diambil berdasarkan nilai parameter GET 'act'.
	switch ($_GET['act']) {
		// menangani penambahan tugas dengan mengelola file, menyimpan informasi tugas, membuat kode kerja tugas, dan mencatat ke timeline
		case 'add':
			// Mengambil data dari formulir POST dan FILES.
			$judul = $_POST['judul_tugas'];
			$tglup = date('Y-m-d H:i:s');
			$awal = $_POST['awaltgl'] . " " . $_POST['awaljam'] . ":00";
			$ahir = $_POST['ahirtgl'] . " " . $_POST['ahirjam'] . ":00";
			$kelas = isset($_POST['kd_kls']) ? $_POST['kd_kls'] : '';

			$mapel = $_POST['mapel'];
			$kd_guru = $_POST['kd_guru'];

			$temp = "../../files/tugas/";
			if (!file_exists($temp)) {
				mkdir($temp);
			}
			$fileupload = $_FILES['fuptugas']['tmp_name'];
			$filename = $_FILES['fuptugas']['name'];
			$filetype = $_FILES['fuptugas']['type'];

			// Membuat direktori jika belum ada.
			if (!empty($fileupload)) {
				// Menghasilkan nama file baru dengan nomor acak.
				$acak = rand(00000000, 99999999);

				// Iterasi untuk setiap kelas yang dipilih.
				$filext = substr($filename, strrpos($filename, '.'));
				$filext = str_replace('.', '', $filext);
				$filename = preg_replace("/\.[^.\s]{3,4}$/", "", $filename);
				$newfilename = $judul . '_' . $acak . '.' . $filext;

				if (is_array($kelas)) {
					foreach ($kelas as $kd) {
						// Membuat kode tugas baru dan menyimpannya di database.
						$thn = date("Y");
						$k = "02" . $thn . $kd_guru;
						$qcek = "SELECT MAX(kd_tugas) AS kode FROM tugas WHERE kd_tugas LIKE '$k%'";
						$max = mysqli_fetch_array(mysqli_query($connect, $qcek));
						$kodeurut = (int) substr($max['kode'], strlen($k), 3) + 1;
						if ($kodeurut < 10) {
							$kodeurut = "00" . $kodeurut;
						} else if ($kodeurut < 100) {
							$kodeurut = "0" . $kodeurut;
						}
						$kd_tugas = $k . $kodeurut;

						$q = "INSERT INTO tugas (kd_tugas,nama_tugas,batas_awal,batas_ahir,file,tgl_up,kd_kelas,kd_mapel,kd_guru)
                        VALUES ('$kd_tugas','$judul','$awal','$ahir','$newfilename','$tglup','$kd','$mapel','$kd_guru')";
						$instugas = mysqli_query($connect, $q);
						if ($instugas) {
							$t = "SELECT siswa.nis FROM siswa, tahun_ajar, rombel WHERE rombel.nis=siswa.nis AND rombel.kd_tajar=tahun_ajar.kd_tajar AND tahun_ajar.aktif='Y' AND rombel.kd_kelas='$kd'";
							$tj = mysqli_query($connect, $t);
							$jnis = mysqli_num_rows($tj);
							if ($jnis > 0) {
								while ($jt = mysqli_fetch_array($tj)) {
									// Membuat kode kerja tugas untuk setiap siswa yang terkait dengan kelas.
									$thn = date("Y");
									$ks = "12" . $thn . $jt['nis'];
									$qscek = "SELECT MAX(kd_kerja) AS kode FROM kerja_tugas WHERE kd_kerja LIKE '$ks%'";
									$maxs = mysqli_fetch_array(mysqli_query($connect, $qscek));
									$kodeuruts = (int) substr($maxs['kode'], strlen($ks), 3) + 1;
									if ($kodeuruts < 10) {
										$kodeuruts = "00" . $kodeuruts;
									} else if ($kodeuruts < 100) {
										$kodeuruts = "0" . $kodeuruts;
									}
									$kd_kerja = $ks . $kodeuruts;

									mysqli_query($connect, "INSERT INTO kerja_tugas (kd_kerja,kd_tugas,nis,file_kerja,nilai,status_kerja) VALUES ('$kd_kerja','$kd_tugas','$jt[nis]','T','0','T')");
								}
							}
							// Menyimpan informasi ke timeline.
							$qt = "INSERT INTO timeline (jenis,id_jenis,waktu,kd_kelas,kd_mapel,kd_guru) 
                            VALUES ('tugas','$kd_tugas','$tglup','$kd','$mapel','$kd_guru')";
							mysqli_query($connect, $qt);
						}
					}
				}
				// Kondisi ini digunakan untuk memeriksa apakah nilai dari variabel $s adalah 'scs'. Jika kondisi ini benar (true), maka blok kode di dalamnya akan dijalankan. Ini dapat memiliki berbagai makna tergantung pada konteks penggunaan variabel tersebut dalam aplikasi.
				if ($s == 'scs') {
					// Memindahkan file upload ke direktori yang telah dibuat.
					move_uploaded_file($_FILES["fuptugas"]["tmp_name"], $temp . $newfilename);
					// Menampilkan pesan berhasil atau kesalahan.
					echo "<script>alert('Berhasil membuat tugas'); location='../../media.php?module=tugas'</script>";
				} else {
					echo "Terjadi Kesalahan!";
				}
			}
			break;


		// Untuk menangani penghapusan tugas, mengelola file, dan memberikan pesan.
		case 'del':
			// Mengambil ID tugas dari parameter GET dengan nama 'id'.
			$kd = $_GET['id'];

			// Mengambil nama file dan path dari tugas yang akan dihapus dari tabel 'tugas' di database.
			$qh = "SELECT file FROM tugas WHERE kd_tugas='$kd'";
			$qfile = mysqli_query($connect, $qh);
			$rfile = mysqli_fetch_array($qfile);
			$file = "../../files/tugas/" . $rfile['file'];

			// Menghapus tugas dari tabel 'tugas' berdasarkan ID tugas. Jika penghapusan berhasil, maka akan melanjutkan ke langkah berikutnya.
			$q = "DELETE FROM tugas WHERE kd_tugas='$kd'";

			if (mysqli_query($connect, $q)) {
				// Menghapus data kerja tugas yang terkait dengan tugas yang dihapus.
				$delts = "DELETE FROM kerja_tugas WHERE kd_tugas='$kd'";
				mysqli_query($connect, $delts);
				// Menghapus entri pada timeline yang terkait dengan tugas yang dihapus.
				$delt = "DELETE FROM timeline WHERE timeline.jenis='tugas' AND timeline.id_jenis='$kd'";
				mysqli_query($connect, $delt);
				// Mengecek apakah tidak ada tugas lagi yang menggunakan file yang dihapus. Jika tidak ada, maka file dihapus dari direktori.
				$qc = "SELECT * FROM tugas WHERE file='$rfile[file]'";
				if (mysqli_num_rows(mysqli_query($connect, $qc)) < 1) {
					unlink($file);
				}
				echo "<script>alert('Berhasil menghapus tugas'); location='../../media.php?module=tugas'</script>";
			}
			break;

		case 'edit':
			// Mengambil data dari formulir POST dan FILES.
			$kd_tugas = $_POST['kd_tugas'];
			$judul = $_POST['judul_tugas'];
			$tglup = date('Y-m-d H:i:s');
			$awal = $_POST['awaltgl'] . " " . $_POST['awaljam'] . ":00";
			$ahir = $_POST['ahirtgl'] . " " . $_POST['ahirjam'] . ":00";
			$kelas = $_POST['kd_kls'];
			$mapel = $_POST['mapel'];
			$kd_guru = $_POST['kd_guru'];

			$temp = "../../files/tugas/";
			// Membuat direktori jika belum ada.
			if (!file_exists($temp)) {
				mkdir($temp);
			}
			$fileupload = $_FILES['fuptugas']['tmp_name'];
			$filename = $_FILES['fuptugas']['name'];
			$filetype = $_FILES['fuptugas']['type'];

			$sql = $connect->query("SELECT * FROM tugas WHERE kd_tugas='$kd_tugas'");
			$row = $sql->fetch_assoc();

			// Memeriksa apakah ada file upload.
			// Jika ada file upload, file lama dihapus dan file baru diunggah.
			if (!empty($fileupload)) {
				$existingFile = $temp . $row['file'];
				if (file_exists($existingFile)) {
					unlink($existingFile);
				}

				$filext = substr($filename, strrpos($filename, '.'));
				$filext = str_replace('.', '', $filext);
				$filename = preg_replace("/\.[^.\s]{3,4}$/", "", $filename);
				$newfilename = $kd_tugas . '_' . uniqid() . '.' . $filext;

				// Mengupdate informasi tugas di database.
				$q = "UPDATE tugas SET nama_tugas='$judul',batas_awal='$awal',batas_ahir='$ahir',file='$newfilename',tgl_up='$tglup',kd_kelas='$kelas',kd_mapel='$mapel',kd_guru='$kd_guru'
    WHERE kd_tugas='$kd_tugas'";
				$updtugas = mysqli_query($connect, $q);
				if ($updtugas) {
					// Juga mengupdate waktu pada timeline.
					$qt = "UPDATE timeline SET waktu='$tglup' 
        WHERE jenis='tugas' AND id_jenis='$kd_tugas'";
					mysqli_query($connect, $qt);
					move_uploaded_file($_FILES["fuptugas"]["tmp_name"], $temp . $newfilename);
					echo "<script>alert('Berhasil mengedit tugas'); location='../../media.php?module=tugas'</script>";
				} else {
					echo "<script>alert('Terjadi Kesalahan!'); location='../../media.php?module=tugas'</script>";
				}
			} else {
				// Bagian lain dari kode untuk penanganan pengeditan tanpa mengunggah file.
			}


			break;

		case 'berinilai':
			// Memeriksa apakah nilai diberikan melalui formulir draf atau simpan.
			if (isset($_POST['draf'])) {
				$nil = $_POST['nilai'];
				$kd = $_POST['kd'];
				$kdt = $_POST['kdt'];

				// Mengupdate nilai kerja tugas untuk tugas yang sedang dikerjakan (status 'T').
				$qn = "UPDATE kerja_tugas SET nilai='$nil' WHERE kd_kerja='$kd'";
				$ex = mysqli_query($connect, $qn);

				// Menangani hasil dari query update nilai.
				if ($ex) {
					// Menampilkan pesan berhasil dan mengarahkan ke halaman detail tugas.
					echo "<script>alert('Berhasil menambah nilai Sementara'); location='../../media.php?module=detailtugas&kd=$kdt&st=T&eid=$kd'</script>";
				} else {
					// Menampilkan pesan gagal dan mengarahkan kembali ke halaman tugas.
					echo "<script>alert('gagal'); location='../../media.php?module=tugas'</script>";
				}
			} else if (isset($_POST['simpan'])) {
				$nil = $_POST['nilai'];
				$kd = $_POST['kd'];
				$kdt = $_POST['kdt'];

				// Mengupdate nilai kerja tugas dan mengubah status kerja menjadi 'N'.
				$qn = "UPDATE kerja_tugas SET nilai='$nil',status_kerja='N' WHERE kd_kerja='$kd'";
				$ex = mysqli_query($connect, $qn);

				// Menangani hasil dari query update nilai.
				if ($ex) {
					// Menampilkan pesan berhasil dan mengarahkan ke halaman detail tugas.
					echo "<script>alert('Berhasil menambah nilai'); location='../../media.php?module=detailtugas&kd=$kdt&st=T&eid=$kd'</script>";
				} else {
					// Menampilkan pesan gagal dan mengarahkan kembali ke halaman tugas.
					echo "<script>alert('Gagal'); location='../../media.php?module=tugas'</script>";
				}
			}

			break;

		// Jika 'act' tidak cocok dengan kasus yang ada, maka akan mencetak pesan bahwa aksi tidak ditemukan.
		default:
			echo "Aksi tidak ditemukan!";
			break;
	}
}
?>