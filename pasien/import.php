<?php
require_once '../auth/cek.php';
require_once 'cekpasien.php';
include_once "../dashboard/header.php"; ?>

<div class="box">
	<h1>Data Pasien</h1>
	<h4>
		<small>Import Data Pasien</small>
		<div class="pull-right">
			<a href="../file/sample/AppRumah.xlsx" class="btn btn-default"><i class="glyphicon glyphicon-download-alt"></i> Download Format Excel</a>
			<a href="data.php" class="btn btn-success"><i class="glyphicon glyphicon-chevron-left"></i> Kembali</a>
		</div>
	</h4>
</div>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<form action="proses.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="file">File Excel</label>
				<input type="file" name="file" id="file" class="form-control" required>
			</div>
			<div class="form-group pull-right">
				<button type="submit" name="import" class="btn btn-primary">Import</button>
			</div>
		</form>
	</div>
</div>

<?php include_once "../dashboard/footer.php"; ?>