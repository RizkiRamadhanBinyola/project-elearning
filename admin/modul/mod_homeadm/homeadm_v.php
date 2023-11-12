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
    <h4>Dashboard Admin</h4>
    <img src="assets/img/smktpg2.jpeg" class="img-fluid mx-auto d-block" alt="...">
</div>
       


<?php } ?>