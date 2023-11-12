<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
session_start();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=nilai_tugas.xls");
?>

<h3>LAPORAN NILAI TUGAS </h3>
<?php
// Menggunakan file koneksi.php untuk menghubungkan ke database.
include "../../../koneksi/koneksi.php";

// Mengambil data tugas, mapel, kelas, dan guru berdasarkan kd_tugas.
$qu = $connect->query("SELECT * FROM tugas,mapel,kelas,guru
    WHERE tugas.kd_mapel=mapel.kd_mapel and tugas.kd_kelas=kelas.kd_kelas and tugas.kd_guru=guru.kd_guru and tugas.kd_tugas='$_GET[kd]'"); 
$ro = $qu->fetch_assoc();

// Mengambil data mapel berdasarkan kd_mapel.
$query1 = $connect->query("SELECT * FROM mapel
    WHERE kd_mapel='$ro[kd_mapel]'"); 
$row1 = $query1->fetch_assoc();

// Mengambil data kelas berdasarkan kd_kelas.
$query2 = $connect->query("SELECT * FROM kelas
    WHERE kd_kelas='$ro[kd_kelas]'"); 
$row2 = $query2->fetch_assoc();

// Mengambil data guru berdasarkan username.
$query3 = $connect->query("SELECT * FROM guru
    WHERE username='$_SESSION[username]'"); 
$row3 = $query3->fetch_assoc();
?>

<!-- Tampilan Header Excel -->
<h4 class="text-center">Mata Pelajaran: <?=$row1["nama_mapel"]?> Tugas: <?=$ro["nama_tugas"]?> (<?=$row2["nama_kelas"]?>)<br>Guru Pengampu: <?=$row3["nama"]?><br></h4>
		
<!-- Tabel Data Nilai untuk Excel -->
<table border="1" cellpadding="5">
    <tr>
        <th>NO</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>NILAI</th>
    </tr>
    <?php
    // Query untuk mengambil data nilai tugas siswa berdasarkan kd_tugas.
    $sql = mysqli_query($connect, "SELECT * FROM tugas
        INNER JOIN kerja_tugas ON tugas.kd_tugas = kerja_tugas.kd_tugas
        INNER JOIN siswa ON kerja_tugas.nis = siswa.nis
        WHERE tugas.kd_tugas = '$_GET[kd]'");

    $no=1;// Penomoran tabel, di awal set dengan 1
    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td>".$data['nis']."</td>";
        echo "<td>".$data['nama']."</td>";
        echo "<td>".$data['nilai']."</td>";
        echo "</tr>";
        
        $no++; // Tambah 1 setiap kali looping
    }
    ?>
</table>