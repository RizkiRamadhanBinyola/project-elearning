<div class="container mt-5">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<form onSubmit="return validateForm()" enctype="multipart/form-data" method="POST" action="modul/mod_siswa/aksi.php">

				<div class="form-group text-left">
					<h3>IMPORT SISWA</h3>

					<input class="form-control" type="file" name="filesoal" id="filesoal">

				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" name="import" value="IMPORT">
				</div>
			</form>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="alert alert-info">
				<h4>Import file excel</h4>
				<p>Hanya file excel dengan extensi .xls yang dapat digunakan. Format excel dapat didownload <b><a href="files/format_soal/format_siswa.xls">disini</a></b>.</p>

			</div>
		</div>
	</div>
</div>