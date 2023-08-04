<?php
$chk = @$_POST['checked'];
if (!isset($chk)) {
	echo "<script>alert('Tidak ada data yang dipilih.'); window.location='data.php';</script>";
} else {
	require_once '../auth/cek.php';
	require_once "../config/koneksi.php";
	require_once 'cekpoli.php';
	include_once "../dashboard/header.php";

?>

	<div class="box">
		<h1>Data Poliklinik</h1>
		<h4>
			<small>Edit Data Poliklinik</small>
			<div class="pull-right">
				<a href="data.php" class="btn btn-warning"><i class="glyphicon glyphicon-chevron-left"></i>Kembali</a>
			</div>
		</h4>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<form action="proses.php" method="post">
					<input type="hidden" name="total" value="<?= htmlspecialchars(@$_POST['count_add']) ?>">
					<table class="table">
						<tr>
							<th>#</th>
							<th>Nama Poliklinik</th>
							<th>Gedung</th>
						</tr>
						<?php
						$no = 1;
						foreach ($chk as $id) {
							$sql_poli = "SELECT * FROM tb_poliklinik WHERE id_poli = :id_poli";
							$stmt = $conn->prepare($sql_poli);
							$stmt->bindParam(':id_poli', $id);
							$stmt->execute();
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						?>
								<tr>
									<td><?= $no++; ?></td>
									<td>
										<input type="hidden" name="id[]" value="<?= $data['id_poli']; ?>">
										<input type="text" name="nama[]" class="form-control" required value="<?= $data['nama_poli'] ?>">
									</td>
									<td>
										<input type="text" name="gedung[]" class="form-control" required value="<?= $data['gedung']; ?>">
									</td>
								</tr>
						<?php
							}
						}
						?>
					</table>
					<div class="form-group pull-right">
						<input type="submit" name="edit" value="Simpan Semua" class="btn btn-success">
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
	include_once "../dashboard/footer.php";
}
?>