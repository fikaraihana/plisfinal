<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekpoli.php';
include_once "../dashboard/header.php";

?>

<div class="box">
	<h1>Data Poliklinik</h1>
	<h4>
		<div class="pull-right">
			<a href="" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i></a>
			<a href="generate.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>Tambah Poli</a>
		</div>
	</h4>
	<form action="" method="post" name="proses">
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Poli</th>
						<th>Gedung</th>
						<th>
							<center>
								<input type="checkbox" id="select_all" value="">
							</center>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$sql_poli = "SELECT * FROM tb_poliklinik ORDER BY nama_poli DESC";
					try {
						$stmt = $conn->prepare($sql_poli);
						$stmt->execute();
						if ($stmt->rowCount() > 0) {
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					?>
								<tr>
									<td><?= $no++; ?></td>
									<td><?= $data['nama_poli']; ?></td>
									<td><?= $data['gedung']; ?></td>
									<td align="center">
										<input type="checkbox" name="checked[]" class="check" value="<?= $data['id_poli']; ?>">
									</td>
								</tr>
					<?php
							}
						} else {
							echo "<tr><td colspan=\"4\" align=\"center\">Data tidak ditemukan.</td></tr>";
						}
					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage();
					}
					?>
				</tbody>
			</table>
		</div>
	</form>
	<div class="box pull-right">
		<button class="btn btn-warning" onclick="edit()"><i class="glyphicon glyphicon-edit"></i> Edit</button>
		<button class="btn btn-danger" onclick="hapus()"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
	</div>
</div>
<script src="<?= base_url(); ?>assets/js/jquery.js"></script>
<script>
	$(document).ready(function() {
		// menyeleksi semua checkbox
		$('#select_all').click(function() {
			if (this.checked) {
				$('.check').each(function() {
					this.checked = true;
				});
			} else {
				$('.check').each(function() {
					this.checked = false;
				});
			}
		});

		// menyeleksi salah satu, jika semua di ceklis otomatis akan terpilih select all
		$('.check').click(function() {
			if ($('.check:checked').length == $('.check').length) {
				$('#select_all').prop('checked', true);
			} else {
				$('#select_all').prop('checked', false);
			}
		});

	});

	function edit() {
		document.proses.action = 'edit.php';
		document.proses.submit();
	}

	function hapus() {
		const conf = confirm('Yakin ?');
		if (conf) {
			document.proses.action = 'del.php';
			document.proses.submit();
		}
	}
</script>

<?php include_once "../dashboard/footer.php"; ?>