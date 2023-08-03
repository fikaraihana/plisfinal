<?php
require_once('../auth/cek.php');
require_once 'cekdokter.php';
include_once "../dashboard/header.php";

$id = @$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tb_dokter WHERE id_dokter = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="box">
	<h1>Data Dokter</h1>
	<h4>
		<small>Edit Data Dokter</small>
		<div class="pull-right">
			<a href="data.php" class="btn btn-success"><i class="glyphicon glyphicon-chevron-left"></i>Kembali</a>
		</div>
	</h4>
</div>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<form action="proses.php" method="post">
			<div class="form-group">
				<label for="nama">Nama Dokter</label>
				<input type="hidden" name="id" value="<?= $data['id_dokter']; ?>">
				<input type="text" name="nama" class="form-control" required id="nama" value="<?= $data['nama_dokter']; ?>">
			</div>
			<div class="form-group">
				<label for="spesialis">Spesialis</label>
				<input type="text" name="spesialis" class="form-control" required id="spesialis" value="<?= $data['spesialis']; ?>">
			</div>
			<div class="form-group">
				<label for="alamat">Alamat</label><br>
				<textarea name="alamat" id="alamat" cols="86" rows="5"><?= $data['alamat']; ?></textarea>
			</div>
			<div class="form-group">
				<label for="no_telp">No.Telepon</label>
				<input type="number" name="no_telp" class="form-control" required id="no_telp" value="<?= $data['no_telp']; ?>">
			</div>
			<div class="form-group pull-right">
				<button type="submit" name="edit" class="btn btn-primary">Edit Dokter</button>
			</div>
		</form>
	</div>
</div>

<?php include_once "../dashboard/footer.php"; ?>