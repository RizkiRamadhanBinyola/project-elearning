<?php
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = '../../index.php';</script>";
}
    else{

?>



<div class="container mt-5">
    <h4>selamat datang di dashboard administrator</h4>
    <img src="assets/img/smktpg2.jpeg" class="img-fluid mx-auto d-block" alt="...">
</div>
       


<?php } ?>