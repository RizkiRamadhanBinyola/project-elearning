<?php
session_start();
//error_reporting(1);
include "../koneksi/koneksi.php";

if (empty($_SESSION['username']) || empty($_SESSION['level'])) {
    echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
} else {
    $qtj = "SELECT * FROM tahun_ajar WHERE aktif='Y'";
    $result = mysqli_query($connect, $qtj);

    if ($result) {
        $tj = mysqli_fetch_array($result);
        if ($tj) {
            $kd_tajar = $tj['kd_tajar'];
            $namatajar = $tj['tahun_ajar'] . " Semester " . $tj['kd_semester'];
        } else {
            // Handle jika tidak ada baris yang cocok dengan query
            echo "<script>alert('Data tahun ajar tidak ditemukan!.');</script>";
        }
    } else {
        // Handle jika query tidak berhasil
        echo "Terjadi kesalahan dalam menjalankan query.";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>Dashboard - Webkolah</title>
            <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
            <link href="assets/css/styles.css" rel="stylesheet" />
            <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body class="sb-nav-fixed">

            <!-- Navbar -->
            <?php include 'navbar.php'; ?>
        
                <div id="layoutSidenav_content">
                    <!-- Start Body Content -->
                    <main>
                        <?php
                        include 'content.php';
                        ?>
                    </main>
                    <!-- End Body Content -->
                <?php include 'footer.php'; ?>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="assets/js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="assets/demo/chart-area-demo.js"></script>
            <script src="assets/demo/chart-bar-demo.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="assets/js/datatables-simple-demo.js"></script>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/jquery-1.9.1.js"></script>
    <script src="assets/js/bootstrap-3.3.5.js"></script>
    <script type="text/javascript" src="assets/js/malsup-media.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.pmateri', function (e) {
                e.preventDefault();
                $("#previewmateri").modal('show');
                $(".modal-title").html($(this).attr('data-judul'));
                $.post('modul/mod_materi_siswa/dokumen.php',
                    {id: $(this).attr('data-id')},
                    function (html) {
                        $(".modal-body").html(html);
                    }
                    );
            });

            $(document).on('change', '#cbbketergantungan', function(){
                var pil = $(this).val();
                var kd_soal = $(this).attr('data-soal');
                var kd_det_soal = $(this).attr('data-detail');
                if (pil=="Child"){
                    $.ajax({
                        url: 'modul/mod_banksoal/getchild.php',
                        type: 'post',
                        data: {
                            kds : kd_soal,
                            kdd : kd_det_soal
                        },
                        success: function (data){
                            $('#child').html(data);
                        }
                    });
                } else {
                    $('#child').html("");
                }

            });
            $(document).on('change', '#jfile', function(){
                var jfile = $(this).val();
                var i;
                var inputfile = "";
                for (i=1;i<=jfile;i++){
                    inputfile = inputfile + "<input class='form-control' type='FILE' name='ftugas"+i+"'  required='required'><br>";
                }
                $('#hjfile').val(jfile);
                $('#Uploadj').html(inputfile);
            
            });
            $(document).on('change', '#cbbmapel', function(){
                var mapel = $(this).val();
                var kd_guru = $(this).attr('data-guru');
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'kelasmapel',
                        mp: mapel,
                        kdg: kd_guru
                    },
                    success: function (data){
                        $('#infokls').html(data);
                    }
                });

            });

            $(document).on('change', '#cbbmapelajar', function(){
                var mapel = $(this).val();
                $('#cbbjurusan').attr('data-mapel',mapel)
            });

            $(document).on('change', '#cbbkls', function(){
                var kd_kelas = $(this).val();
                var lokasi = "?module=rombel&kls="+kd_kelas;

                $(location).attr('href', lokasi);
            });

            $(document).on('change', '#cbbmapelsil', function(){
                var mapel = $(this).val();
                var kd_guru = $(this).attr('data-guru');
            
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'tingkatjurusan',
                        mp: mapel,
                        gru: kd_guru
                    },
                    success: function (data){
                        $('#tingkatjurusan').html(data);
                    }
                });
            });

            $(document).on('change', '#cbbjurusan', function(){
                var jurusan = $(this).val();
                var kd_mapel = $(this).attr('data-mapel');
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'kelasajar',
                        mp: kd_mapel,
                        jrs: jurusan
                    },
                    success: function (data){
                        $('#kelasajar').html(data);
                    }
                });

            });
        
            $(document).on('change', '#cbmapel', function(){
                var mapel = $(this).val();
                var kd_guru = $(this).attr('data-guru');
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'kelasmapel',
                        mp: mapel,
                        kdg: kd_guru
                    },
                    success: function (data){
                        $('#infokls').html(data);
                    }
                });
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'soalmapel',
                        mp: mapel,
                        kdg: kd_guru
                    },
                    success: function (data){
                        $('#daftsoal').html(data);
                    }
                });

            });

            $(document).on('change', '#cbbForL', function(){
                var pil = $(this).val();
                $output="";
                if (pil=='file') {
                    $output = "<label>Upload File Materi</label><input class='form-control' type='file' name='filemateri' id='fileupload' />";
                } else if (pil=='link') {
                    $output = "<label>Upload Link Materi</label><input class='form-control' type='text' name='linkmateri' id='fileupload' />";
                }
                $("#ForL").html($output);
            });

            $("#fileupload").change(function () {
                var fileExtension = ['pdf','jpeg', 'jpg', 'png', 'ppt', 'docx', 'xlsx' ,'pptx', 'mp4', 'rar'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $(this).val('');
                    $(".warningnya").html("Ekstensi file harus: "+fileExtension.join(', '));
                } else {
                    $(".warningnya").html("");
                }
            });

            $("#filemateri").change(function () {
                var fileExtension = ['pdf','jpeg', 'jpg', 'png', 'ppt', 'docx', 'xlsx' ,'pptx', 'mp4', 'rar'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $(this).val('');
                    $(".warningnya").html("Ekstensi file harus: "+fileExtension.join(', '));
                } else {
                    if ( this.files[0].size/1024/1024 > 50 ){
                        $(this).val('');
                        $(".warningnya").html("Ukuran maksimum hanya 30MB");
                    } else {
                        $(".warningnya").html("");
                    }
                
                }
            });

            $(document).on('click','#openmodal',function(){
                var id = $(this).attr('data-kds');
                $.ajax({
                    url: 'function.php',
                    type: 'post',
                    data: {
                        act: 'mdlslb',
                        kd: id
                    },
                    success: function (data){
                        $('#modalsilabus').html(data);
                    }
                });
                $('#modalupdsilabus').modal({show:true});
            });
        
        });
    </script>

    <script type="text/javascript">
    //    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }
        if(!hasExtension('filesoal', ['.xls'])){
            alert("Hanya file XLS yang diijinkan.");
            return false;
        }
    }
    function validatetugas()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }
        if(!hasExtension('filesoal', ['.xls'])){
            alert("Hanya file XLS yang diijinkan.");
            return false;
        }
    }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
    /** Membuat Waktu Mulai Hitung Mundur Dengan 
    * var detik = 0,
    * var menit = 1,
    * var jam = 1
    */
    var detik = document.getElementById("detik").value;
    var menit = document.getElementById("menit").value;
    var jam   = document.getElementById("jam").value;

    /**
    * Membuat function hitung() sebagai Penghitungan Waktu
    */
    function hitung() {
    /** setTimout(hitung, 1000) digunakan untuk 
    * mengulang atau merefresh halaman selama 1000 (1 detik) 
    */
    setTimeout(hitung,1000);

    /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
    if(menit < 10 && jam == 0){
        var peringatan = 'style="color:red"';
    };

    /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
    $('#timer').html(
        '<h3 align="center"'+peringatan+'>' + jam + ' jam : ' + menit + ' menit : ' + detik + ' detik</h3>'
        );

    /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
    detik --;

    /** Jika var detik < 0
    * var detik akan dikembalikan ke 59
    * Menit akan Berkurang 1
    */
    if(detik < 0) {
        detik = 59;
        menit --;

    /** Jika menit < 0
    * Maka menit akan dikembali ke 59
    * Jam akan Berkurang 1
    */
    if(menit < 0) {
        menit = 59;
        jam --;

    /** Jika var jam < 0
    * clearInterval() Memberhentikan Interval dan submit secara otomatis
    */
    if(jam < 0) {                                                                 
        clearInterval(); 
        var frmSoal = document.getElementById("flembarujian");
        frmSoal.submit();                           
    } 
    } 
    } 
    }           
    /** Menjalankan Function Hitung Waktu Mundur */
    hitung();
    }); 
    // ]]>
    </script>
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
        
            <script>
                function prosesLogin() {
                    let timerInterval
                    Swal.fire({
                        title: 'Auto close alert!',
                        html: 'I will close in <b></b> milliseconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
                }    
            </script>
    
        </body>
    </html>
<?php } ?>
