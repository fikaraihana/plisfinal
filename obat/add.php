<?php
require_once '../auth/cek.php';
require_once 'cekobat.php';
include_once "../dashboard/header.php"; ?>

<div class="box">
	<h1>Data Obat</h1>
	<h4>
		<small>Data Obat</small>
		<div class="pull-right">
			<a href="data.php" class="btn btn-success"><i class="glyphicon glyphicon-chevron-left"></i>Kembali</a>
		</div>
	</h4>
</div>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<form action="proses.php" method="post">
			<div class="form-group">
				<label for="nama">Nama Obat</label>
				<input type="text" name="nama" class="form-control" required autofocus="on" id="nama">
			</div>
			<div class="form-group">
				<label for="ket">Keterangan</label><br>
				<textarea name="ket" id="ket" cols="86" rows="5"></textarea>
			</div>
			<div class="form-group pull-right">
				<button type="submit" name="add" class="btn btn-primary">Tambah Obat</button>
			</div>
		</form>
	</div>
</div>

<?php include_once "../dashboard/footer.php"; ?>