<!-- CSS -->

<style type="text/css">
  .well:hover {
    box-shadow: 0px 2px 10px rgb(190, 190, 190) !important;
  }
  a {
    color: #666;
  }
</style>

<!-- CSS/ -->

<?php
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
}
else{

  ?>

  <?php
  $update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
  if ($update) {
   $sql = $connect->query("SELECT * FROM tahun_ajar WHERE kd_tajar='$_GET[key]'");
   $row = $sql->fetch_assoc();
 }
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if ($update) {
    $sql = "UPDATE tahun_ajar SET tahun_ajar='$_POST[tahun_ajar]',kd_semester='$_POST[kd_semester]' WHERE kd_tajar='$_GET[key]'";
    if ($connect->query($sql)) {
      echo "<script>alert('Berhasil'); window.location = 'media.php?module=tahun'</script>";
    } else {
      echo "<script>alert('Gagal'); window.location = 'media.php?module=tahun'</script>";
    }
  } else {
   for ($smt=1;$smt<=2;$smt++){
    $hsmt = $smt==1 ? "ganjil" : "genap";
    $kd = $_POST['tahun_ajar']."-".$hsmt;
    $sql = "INSERT INTO tahun_ajar VALUES ('$kd', '$_POST[tahun_ajar]', '$smt', 'N')";
    if ($connect->query($sql)) {
      echo "<script>alert('Berhasil'); window.location = 'media.php?module=tahun'</script>";
    } else {
      echo "<script>alert('Gagal'); window.location = 'media.php?module=tahun'</script>";
    }
  }

}

}
if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $key = substr($_GET['key'], 0, 9);
  $connect->query("DELETE FROM tahun_ajar WHERE tahun_ajar='$key'");
  echo "<script>alert('Berhasil'); window.location = 'media.php?module=tahun'</script>";
}
if (isset($_GET['action']) AND $_GET['action'] == 'aktif') {
  $sql = $connect->query("SELECT kd_tajar FROM tahun_ajar WHERE aktif='Y'");
  $row = $sql->fetch_assoc();
  $tjaktif = $row['kd_tajar'];

  $sql = "UPDATE tahun_ajar SET aktif='N' WHERE kd_tajar='$tjaktif'";

  if ($connect->query($sql)) {
    $connect->query("UPDATE tahun_ajar SET aktif='Y' WHERE kd_tajar='$_GET[key]'");
    echo "<script>alert('Berhasil'); window.location = 'media.php?module=tahun'</script>";
  }
}


if (isset($_GET['action']) AND $_GET['action'] == 'delfile') {
  $kd_tajar=$_GET['key'];
  $list = "";
  $qkelas3 = mysqli_query($connect,"SELECT kd_kelas FROM kelas WHERE tingkat='XII'");
  while ($kelas3 = mysqli_fetch_array($qkelas3)) {
    $qnis = mysqli_query($connect,"SELECT nis FROM rombel WHERE kd_kelas='$kelas3[kd_kelas]' AND kd_tajar='$kd_tajar'");
    while ($nis = mysqli_fetch_array($qnis)) {
      $list = $list.",".$nis['nis'];
    }
  }
  if ($list!=""){
    $list=substr($list, 1);
    $siswa = explode(",", $list);

    $kdkerja = "";
    foreach ($siswa as $swa) {
      $qstatus = mysqli_query($connect,"UPDATE siswa, login 
        SET siswa.status='Alumni', login.status='nonaktif'
        WHERE siswa.username=login.username AND siswa.nis='$swa'");

      if ($qstatus){
        $qkode = mysqli_query($connect,"SELECT kd_kerja FROM kerja_tugas WHERE nis='$swa' AND file_kerja != 'T'");
        while ($kode=mysqli_fetch_array($qkode)){
          $kdkerja = $kdkerja.",".$kode['kd_kerja'];
        }
      }
    }
    $h=0;
    if ($kdkerja!=""){
      $kdkerja = substr($kdkerja, 1);
      $fkerja = explode(",", $kdkerja);
      if (count($fkerja)>0){
        foreach ($fkerja as $kd) {
          $temp = "files/kerja_tugas/";
          $cs=mysqli_query($connect,"SELECT file_kerja FROM kerja_tugas WHERE kd_kerja='$kd'");
          $rcs=mysqli_fetch_array($cs);

          if ($rcs['file_kerja']!='T'){

            $filenya=explode(",", $rcs['file_kerja']);
            foreach ($filenya as $fhps) {
              $lokasifile=$temp.$fhps;
              if (file_exists($lokasifile)){
                unlink($lokasifile);
                $h++;
              }
            }
          }
          $qup=mysqli_query($connect,"UPDATE kerja_tugas SET file_kerja='T' WHERE kd_kerja='$kd'");
          if ($qup) {
            echo "<script>alert('Berhasil menghapus $h file'); window.location = 'media.php?module=tahun'</script>";
          }
        }
      }

    } else {
		echo "<script>alert('Tidak ada file untuk dihapus'); window.location = 'media.php?module=tahun'</script>";
	}
	
  } else {
    echo "<script>alert('Tidak ada file untuk dihapus'); window.location = 'media.php?module=tahun'</script>";
  }

  
}
?>

<div class="container mt-5">
  <div class="accordion" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         <i class="fa-solid fa-table"></i> TABEL TAHUN AJARAN
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <!-- Content -->
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">ID Tahun Ajaran</th>
                  <th scope="col">Tahun Ajaran</th>
                  <th scope="col">Semester</th>
                  <th scope="col">Aktif</th>
                  <th scope="col">Aksi</th>
                  <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
              <?php $no = 1; 
              if ($query = $connect->query("SELECT * FROM tahun_ajar ORDER BY kd_tajar DESC")):
              while($row = $query->fetch_assoc()): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=$row['kd_tajar']?></td>
                <td><?=$row['tahun_ajar']?></td>
                <td><?=$row['kd_semester']?></td>
                <td><?=$row['aktif']?></td>
                <td class="hidden-print">
                  <div class="btn-group">
                    <!-- <a href="?module=tahun&action=update&key=<?=$row['kd_tajar']?>" class="btn btn-warning btn-xs">Edit</a> -->
                    <a href="?module=tahun&action=delete&key=<?=$row['kd_tajar']?>" class="btn btn-danger btn-xs">Hapus</a>
                    <?php 
                    if ($row['aktif']=='Y'){
                      echo "Aktif";

                    } else {
                      echo "<a href=\"?module=tahun&action=aktif&key=$row[kd_tajar]\" class=\"btn btn-success btn-xs\">Set Aktif</a>";
                    }
                    ?>
                  </div>
                </td>
                <td>
                  <?php 
                  if ($row['aktif']=='Y'){
                    echo "-";

                  } else {
                    echo "<a href=\"?module=tahun&action=delfile&key=$row[kd_tajar]\" class=\"btn btn-danger btn-xs\">Hapus File Siswa</a>";
                  }
                  ?>
                </td>
              </tr>
              <?php endwhile ?>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <i class="fa-solid fa-pen-to-square"></i> <?= ($update) ? "EDIT" : "TAMBAH" ?> TAHUN AJARAN
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" role="form">
            <div class="form-group">
              <label>Tahun Ajar </label>
              <select name="tahun_ajar" class="form-control">
                <?php 
                $tahun = date("Y");
                for ($i=-3;$i<=5;$i++){
                  $tahun1 = $tahun+$i;
                  $tahun2 =  $tahun+$i+1;
                  $tahun_ajaran = $tahun1."-".$tahun2;

                  $qcek = mysqli_query($connect,"SELECT kd_tajar FROM tahun_ajar WHERE tahun_ajar='$tahun_ajaran'");
                  $ada = mysqli_num_rows($qcek);
                  if ($ada > 0) {

                  } else {

                    ?>
                    <option value="<?= $tahun_ajaran; ?>"><?= $tahun_ajaran; ?></option>						

                    <?php

                  } 
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block mt-3">Simpan</button>
            <?php if ($update): ?>
              <a href="?module=akun" class="btn btn-info btn-block">Batal</a>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </div>    
</div>

<?php } ?>