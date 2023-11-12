<!-- Penjelasan kode pada file Nilai_v.php -->

<div class="container mt-5">
	<div class="row">
		<!-- Bagian untuk filter nilai siswa -->
		<div class="col-md-4">
			<div class="card border-secondary mb-3">
				<div class="card-header text-bg-secondary">
					Filter Nilai Siswa
				</div>
				<div class="card-body">
					<?php
					// Mengecek apakah parameter 'mp' sudah diset
					if (isset($_GET['mp'])){
						$mapel=$_GET['mp'];
					} else {
						// Jika tidak, redirect ke semua nilai siswa
						header("location:?module=nilai&mp=all");
						$mapel='all';
					}
					?>
					<!-- Tombol untuk menampilkan semua nilai siswa -->
					<a href="?module=nilai&mp=all" class="btn <?php echo $_GET['mp']=='all' ? "btn-light" : "btn-primary"; ?> btn-sm form-control mb-1">Semua</a>
	
					<?php
					// Menampilkan tombol filter berdasarkan mata pelajaran
					$qmapel=mysqli_query($connect,"SELECT mapel.kd_mapel, mapel.nama_mapel
						FROM mapel, pengajaran as p
						WHERE p.kd_mapel=mapel.kd_mapel AND p.kd_kelas='$kode_kelas'");
					while ($rmp=mysqli_fetch_array($qmapel)){
						$mapel==$rmp['kd_mapel'] ? $cbtn="btn-light" : $cbtn="btn-primary";
						echo "<a href='?module=nilai&mp=$rmp[kd_mapel]' class='btn $cbtn btn-sm form-control mb-1'>$rmp[nama_mapel]</a>  ";
					}
					?>
				</div>
			</div>
		</div>
		<!-- Daftar Nilai Siswa -->
		<div class="col-md-8">
			<div class="card border-secondary">
				<div class="card-header text-bg-secondary">
					Daftar Nilai Siswa
				</div>
				<div class="card-body">
					<!-- Tabel untuk menampilkan daftar nilai siswa -->
					<table id="datatablesSimple">
						<thead>
							<th>#</th>
							<th>Nama</th>
							<th>Jenis</th>
							<th>Nilai</th>
						</thead>
						<tbody>
							<?php 
							if ($mapel=='all'){
								// Menampilkan 'Tugas' data ketika $mapel adalah 'all'
								$query="SELECT 'Tugas' as jenis, kerja_tugas.nis,kerja_tugas.nilai,tugas.nama_tugas as nama_nilai, mapel.nama_mapel 
								FROM kerja_tugas,tugas, mapel 
								WHERE kerja_tugas.kd_tugas=tugas.kd_tugas AND tugas.kd_mapel=mapel.kd_mapel AND kerja_tugas.nis='$_SESSION[kode]'";
								$qnilai=mysqli_query($connect,$query);
								$cj=mysqli_num_rows($qnilai);
								$no=1;
								if ($cj==0) {
									echo "<tr><td colspan='4'>Belum ada data..</td></tr>";
								}
								while ($rsl=mysqli_fetch_array($qnilai)){
									// Menampilkan baris tabel
									echo "<tr>";
									echo "<td>$no</td>
									<td>$rsl[nama_nilai]</td>
									<td>$rsl[jenis]</td>
									<td>$rsl[nilai]</td>";
									echo "</tr>";
									$no++;
								}
							} else {
								// Menampilkan 'Tugas' data ketika $mapel bukan 'all'
								$query="SELECT 'Tugas' as jenis, kerja_tugas.nis,kerja_tugas.nilai,tugas.nama_tugas as nama_nilai 
								FROM kerja_tugas,tugas 
								WHERE kerja_tugas.kd_tugas=tugas.kd_tugas AND kerja_tugas.nis='$_SESSION[kode]' AND tugas.kd_mapel='$mapel'";
								$qnilai=mysqli_query($connect,$query);
								$cj=mysqli_num_rows($qnilai);
								$no=1;
								if ($cj==0) {
									echo "<tr><td colspan='4'>Belum ada data..</td></tr>";
								}
								while ($rsl=mysqli_fetch_array($qnilai)){
									// Menampilkan baris tabel
									echo "<tr>";
									echo "<td>$no</td>
									<td>$rsl[nama_nilai]</td>
									<td>$rsl[jenis]</td>
									<td>$rsl[nilai]</td>";
									echo "</tr>";
									$no++;
								}	
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
