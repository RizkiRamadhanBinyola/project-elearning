<div class="container mt-5">
  <div class="row">
    <!-- Bagian untuk filter materi -->
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="card border-secondary mb-3">
        <div class="card-header text-bg-secondary">
          Filter Materi
        </div>

        <div class="card-body">
          <!-- Tombol untuk menampilkan semua materi -->
          <a href="?module=materi&mp=all" class="btn <?php echo $_GET['mp'] == 'all' ? "btn-light" : "btn-primary"; ?> btn-sm form-control mb-1">Semua</a>

          <?php
          // Menyimpan nilai parameter 'mp' dari URL
          if (isset($_GET['mp'])) {
            $mapel = $_GET['mp'];
          } else {
            $mapel = 'all';
          }

          // Menampilkan tombol filter berdasarkan mata pelajaran
          $qmapel = mysqli_query($connect, "SELECT mapel.kd_mapel, mapel.nama_mapel 
            FROM mapel, pengajaran as p
            WHERE p.kd_mapel=mapel.kd_mapel AND p.kd_kelas='$kode_kelas'");
          while ($rmp = mysqli_fetch_array($qmapel)) {
            $mapel == $rmp['kd_mapel'] ? $cbtn = "btn-light" : $cbtn = "btn-primary";
            echo "<a href='?module=materi&mp=$rmp[kd_mapel]' class='btn $cbtn btn-sm form-control mb-1'>$rmp[nama_mapel]</a>  ";
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Daftar Materi -->
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="card border-secondary mb-3">
        <div class="card-header text-bg-secondary">
          Daftar Materi
        </div>
        <div class="card-body">
          <!-- Tabel untuk menampilkan daftar materi -->
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>#</th>
                <th>Materi </th>
                <th>Mata Pelajaran </th>
                <th>Guru Pengampu </th>
                <th>Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              // Query untuk mengambil data materi
              if ($mapel == 'all') {
                $qmat = "SELECT materi.nama_materi, materi.ForL, materi.materi, materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas , guru.nama
                  FROM materi, pengajaran as p, mapel, kelas, guru 
                  WHERE p.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=materi.kd_kelas AND kelas.kd_kelas=p.kd_kelas AND materi.kd_guru=p.kd_guru AND guru.kd_guru=p.kd_guru AND materi.kd_kelas='$kode_kelas'";
                $mat = mysqli_query($connect, $qmat);
                while ($rmat = mysqli_fetch_array($mat)) {
                  // Menampilkan baris tabel
                  echo "<tr class='odd gradeX'>
                    <td>$no</td>
                    <td>$rmat[nama_materi]</td>
                    <td>$rmat[nama_mapel]</td>
                    <td>$rmat[nama]</td>";

                  // Menampilkan tombol "Lihat Materi" sesuai tipe materi (file/link)
                  if ($rmat['ForL'] == 'file') {
                    echo "<td><a href='files/materi/$rmat[materi]' target='_blank' class='btn btn-info btn-xs'>Lihat Materi</a></td>";
                  } else {
                    echo "<td><a href='$rmat[materi]' class='btn btn-primary btn-xs' target='_blank'>Lihat Materi</a></td>";
                  }

                  echo "</tr>";
                  $no++;
                }
              } else {
                $qmat = "SELECT materi.nama_materi, materi.ForL, materi.materi, materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas , guru.nama
                  FROM materi, pengajaran as p, mapel, kelas, guru 
                  WHERE p.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=materi.kd_kelas AND kelas.kd_kelas=p.kd_kelas AND materi.kd_guru=p.kd_guru AND guru.kd_guru=p.kd_guru AND materi.kd_kelas='$kode_kelas' AND materi.kd_mapel='$mapel'";
                $mat = mysqli_query($connect, $qmat);
                while ($rmat = mysqli_fetch_array($mat)) {
                  // Menampilkan baris tabel
                  echo "<tr class='odd gradeX'>
                    <td>$no</td>
                    <td>$rmat[nama_materi]</td>
                    <td>$rmat[nama_mapel]</td>
                    <td>$rmat[nama]</td>";

                  // Menampilkan tombol "Lihat Materi" sesuai tipe materi (file/link)
                  if ($rmat['ForL'] == 'file') {
                    echo "<td><a href='files/materi/$rmat[materi]' target='_blank' class='btn btn-info btn-xs'>Lihat Materi</a></td>";
                  } else {
                    echo "<td><a href='$rmat[materi]' class='btn btn-primary btn-xs' target='_blank'>Lihat Materi</a></td>";
                  }

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
