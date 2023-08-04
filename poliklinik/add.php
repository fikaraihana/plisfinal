<?php
require_once '../auth/cek.php';
require_once 'cekpoli.php';
include_once "../dashboard/header.php";
$count_add = filter_var(@$_POST['count_add'], FILTER_VALIDATE_INT);
?>

<div class="box">
	<h1>Data Poliklinik</h1>
	<h4>
		<small>Tambah Data Poliklinik</small>
		<div class="pull-right">
			<a href="data.php" class="btn btn-info">Data</a>
			<a href="generate.php" class="btn btn-primary">Tambah Data Lagi</a>
		</div>
	</h4>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<form action="proses.php" method="post">
				<input type="hidden" name="total" value="<?= htmlspecialchars($count_add) ?>">
				<table class="table">
					<tr>
						<th>#</th>
						<th>Nama Poliklinik</th>
						<th>Gedung</th>
					</tr>
					<?php
					for ($i = 1; $i <= $count_add; $i++) { ?>
						<tr>
							<td><?= $i; ?></td>
							<td>
								<input type="text" name="nama-<?= $i ?>" class="form-control" required>
							</td>
							<td>
								<input type="text" name="gedung-<?= $i ?>" class="form-control" required>
							</td>
						</tr>
					<?php
					}

					?>
				</table>
				<div class="form-group pull-right">
					<input type="submit" name="add" value="Simpan Semua" class="btn btn-success">
				</div>
			</form>
		</div>
	</div>
</div>

<?php include_once "../dashboard/footer.php";  ?>