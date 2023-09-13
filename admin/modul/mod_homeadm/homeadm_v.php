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


if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
}
    else{

?>



<div class="container mt-5">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body"><img src="assets/img/icon/siswa.png" alt="Siswa" width="24" height="24"> Data Siswa</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="media.php?module=siswa">View Details Siswa</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body"><img src="assets/img/icon/kelas.png" alt="Kelas" width="24" height="24"> Data Kelas</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="media.php?module=kelas">View Details Kelas</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body"><img src="assets/img/icon/jurusan.png" alt="Jurusan" width="24" height="24"> Data Jurusan </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="media.php?module=akun">View Details Jurusan</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body"><img src="assets/img/icon/guru.png" alt="Guru" width="24" height="24"> Data Guru</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="media.php?module=guru">View Details Guru</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
       


<?php } ?>