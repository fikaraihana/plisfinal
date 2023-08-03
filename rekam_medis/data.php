<?php
require_once '../auth/cek.php';
require_once "../dashboard/header.php";
require_once "../config/koneksi.php";
require_once 'cekrekam.php';
?>

<div class="box">
	<h1>Rekam Medis</h1>
	<h4>
		<div class="pull-right">
			<a href="" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i></a>
			<a href="add.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>Tambah Rekam Medis</a>
		</div>
	</h4>
	<div class="table-responsive" style="margin-top: 70px;">
		<table class="table table-hover table-striped table-bordered" id="rekammedis">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal Periksa</th>
					<th>Nama Pasien</th>
					<th>Keluhan</th>
					<th>Nama Dokter</th>
					<th>Diagnosa</th>
					<th>Poliklinik</th>
					<th>Data Obat</th>
					<th><i class="glyphicon glyphicon-cog"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$query = "SELECT * FROM tb_rekammedis
		INNER JOIN tb_pasien ON tb_rekammedis.id_pasien = tb_pasien.id_pasien
		INNER JOIN tb_dokter ON tb_rekammedis.id_dokter = tb_dokter.id_dokter
		INNER JOIN tb_poliklinik ON tb_rekammedis.id_poli = tb_poliklinik.id_poli
	";

				try {
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($result as $data) {
				?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= tgl_indo($data['tgl_periksa']); ?></td>
							<td><?= $data['nama_pasien']; ?></td>
							<td><?= strip_tags($data['keluhan']); ?></td>
							<td><?= $data['nama_dokter']; ?></td>
							<td><?= $data['diagnosa']; ?></td>
							<td><?= $data['nama_poli']; ?></td>
							<td>
								<?php
								$sql_obat = $conn->prepare("SELECT * FROM tb_rm_obat JOIN tb_obat ON tb_rm_obat.id_obat = tb_obat.id_obat WHERE id_rm = :id_rm");
								$sql_obat->bindParam(':id_rm', $data['id_rm']);
								$sql_obat->execute();
								$data_obat = $sql_obat->fetchAll(PDO::FETCH_ASSOC);

								foreach ($data_obat as $obat) {
									echo $obat['nama_obat'] . "<br>";
								}
								?>
							</td>
							<td>
								<form action="del.php" method="post">
									<input type="hidden" name="id" value="<?= $data['id_rm']; ?>">
									<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Yakin?')">
										<i class="glyphicon glyphicon-trash"></i>
									</button>
								</form>
							</td>
						</tr>
				<?php
					}
				} catch (PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="<?= base_url(); ?>assets/js/jquery.js"></script>
	<script>
		$(document).ready(function() {
			$('#rekammedis').DataTable({
				columnDefs: [{
					"searchable": false,
					"orderable": false,
					"targets": 8
				}],
				"order": [1, "desc"]

			});
		});
	</script>
</div>
<?php include_once "../dashboard/footer.php"; ?>