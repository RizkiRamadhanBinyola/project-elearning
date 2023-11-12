<?php
if (!isset($_GET['kd'])) {
	header("location:?module=tugas&mp=all");
}

$kd = $_GET['kd'];


$qt = "SELECT * 
FROM tugas, kerja_tugas, mapel, guru, kelas
WHERE tugas.kd_tugas=kerja_tugas.kd_tugas AND tugas.kd_mapel=mapel.kd_mapel AND tugas.kd_guru=guru.kd_guru AND tugas.kd_kelas=kelas.kd_kelas AND tugas.kd_kelas='$kode_kelas' AND kerja_tugas.nis='$_SESSION[kode]' AND kerja_tugas.kd_tugas='$kd'";
$qtugas = mysqli_query($connect, $qt);
$rtugas = mysqli_fetch_array($qtugas);

?>
<div class="container mt-5">
	<div class="row">
		<div class="col-md-8">
			<div class="card border-secondary mb-3">
				<div class="card-header text-bg-secondary">
					<?= $rtugas['nama_tugas']; ?>
				</div>
				<div class="card-body">
					<h6>
						<?= "Diberikan oleh : " . $rtugas['nama']; ?>
					</h6>
					<h6>
						<?= "Pada : " . $rtugas['tgl_up']; ?>
					</h6>
					<p>
						<?= $rtugas['deskripsi']; ?>.
					</p>
					<h6>File :
						<?php echo "<a href='files/tugas/$rtugas[file]' target='_blank' class='btn btn-secondary'>Download Tugas</a>"; ?>
					</h6>
					Batas mengumpulkan:
					<?php echo $rtugas['batas_ahir']; ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-secondary mb-3">
				<div class="card-header text-bg-secondary">
					Kumpulkan Tugas
				</div>
				<div class="card-body">
					<form method="POST" action="modul/mod_tugas_siswa/aksi.php?act=tbjawab"
						enctype="multipart/form-data">

						<?php
						if ($rtugas['status_kerja'] == 'T') {
							echo "<div class='alert alert-danger'>Anda Belum Mengumpulkan Tugas</div>";

							// Display the file upload input only when the status is 'T' and the submission deadline has not passed
							date_default_timezone_set('Asia/Jakarta');
							$skr = date("Y-m-d H:i:s");
							if (strtotime($rtugas['batas_awal']) <= strtotime($skr) && strtotime($skr) <= strtotime($rtugas['batas_ahir'])) {
								?>
								<h4>Upload Jawaban:</h4>
								<!-- Inputan form jawaban -->
								<div class="mb-3">
									<input class="form-control" type="file" name="ftugas1" id="ftugas1">
								</div>
								<input type="hidden" name="kd_kerja" value="<?php echo $rtugas['kd_kerja']; ?>">
								<input type="hidden" name="kd_tugas" value="<?php echo $rtugas['kd_tugas']; ?>">
								<?php
								echo "<button type='submit' class='btn btn-primary'>Kirim Jawaban</button>";
							} else if (strtotime($rtugas['batas_awal']) >= strtotime($skr)) {
								echo "<p class='text-info'>Belum bisa mengumpulkan tugas karena belum dimulai. ";
								echo "<br>Tugas dimulai pada $rtugas[batas_awal]</p>";
							} else {
								echo "<b class='text-warning'>Tidak bisa mengumpulkan tugas karena sudah lewat batas </b>";
							}
						} else if ($rtugas['status_kerja'] == 'K') {
							
							echo "
	<div class='alert alert-warning'>Jawaban Anda Sedang Dikoreksi</div>";
							
						} else if ($rtugas['status_kerja'] == 'N') {
							echo "<div class='alert alert-success'>Anda mendapat nilai: $rtugas[nilai]</div>";
						}
						?>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>