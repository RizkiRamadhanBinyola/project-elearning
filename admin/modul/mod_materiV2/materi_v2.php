<?php
include "../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $namaFile = $_FILES['berkas']['name'];
    $x = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($x));
    $ukuranFile = $_FILES['berkas']['size'];
    $file_tmp = $_FILES['berkas']['tmp_name'];

    // Lokasi Penempatan file
    $dirUpload = "files/materi/";
    $linkBerkas = $dirUpload . $namaFile;
    

    // Menyimpan file
    $terupload = move_uploaded_file($file_tmp, $linkBerkas);

    if ($terupload) {
        $query = "INSERT INTO tb_buku (kode_buku, nama_buku, title, size, ekstensi, berkas) VALUES ('$kode', '$nama', '$namaFile', '$ukuranFile', '$ekstensiFile', '$linkBerkas')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>alert('Berhasil!'); window.location = 'media.php?module=tesmateri'</script>";
            exit();
        } else {
            echo "Gagal menyimpan data ke database!";
        }
    } else {
        echo "Upload Gagal!";
    }
}
?>
<h2 style="text-align: center;">Tabel Upload/Download File (PDF)</h2>
<button onclick="document.location='halaman_upload.php'">Tambah Data</button>
<br /><br />

<div class="container mt-5">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="card border-secondary mb-3">
                    <div class="card-body text-secondary">
                        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
                            <b>Kode Buku :</b>
                            <input type="text" name="kode" value="" placeholder=""><br /><br />
                            <b>Nama Buku:</b>
                            <input type="text" name="nama" value="" placeholder=""><br /><br />
                            <b>Upload File :</b>
                            <input type="file" name="berkas" accept="application/pdf">
                            <button type="submit">Upload File</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sn-8 col-xs-12">
                <div class="card border-secondary mb-3">
                    <div class="card-body text-secondary">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th style="width: 30px">No</th>
                                    <th style="width: 100px">Kode</th>
                                    <th>Nama</th>
                                    <th style="width: 100px">Type</th>
                                    <th style="width: 100px">Ukuran</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php
                                include "../koneksi/koneksi.php";
                                $nomor_urut = 0;
                                $query = "SELECT * FROM tb_buku";
                                $result = mysqli_query($connect, $query);
                                $countData = mysqli_num_rows($result);
                        
                                if ($countData < 1) {
                                ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; font-weight: bold; font-size: 12px; padding: 5px; color: red">TIDAK ADA DATA</td>
                                    </tr>
                        
                                    <?php
                                } else {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $nomor_urut = $nomor_urut + 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $nomor_urut; ?></td>
                                            <td><?php echo $row['kode_buku']; ?></td>
                                            <td><?php echo $row['nama_buku']; ?></td>
                                            <td><?php echo strtoupper($row['ekstensi']) ?></td>
                                            <td><?php echo number_format($row['size'] / (1024 * 1024), 2) ?>MB</td>
                                            <td><a href="DownloadFile.php?url=<?php echo $row['berkas']; ?>">Download</a></td>
                                        </tr>
                                <?php
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
</div>
