<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekobat.php';
include_once "../dashboard/header.php";

?>

<div class="row">
	<div class="col-lg-12">
		<h1>Data Obat</h1>
		<h4>
			<div class="pull-right">
				<a href="" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i></a>
				<a href="add.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>Tambah Obat</a>
			</div>
		</h4>
		<div style="margin-bottom: 20px;">
			<form action="" class="form-inline" method="post">
				<div class="form-group">
					<input type="text" name="pencarian" class="form-control" placeholder="Cari data obat...">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				</div>
			</form>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Obat</th>
						<th>Keterangan</th>
						<th><i class="glyphicon glyphicon-cog"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$batas = 7;
					$hal = @$_GET['hal'];
					if (empty($hal)) {
						$posisi = 0;
						$hal = 1;
					} else {
						$posisi = ($hal - 1) * $batas;
					}

					$no = 1;

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$pencarian = trim(htmlspecialchars($_POST['pencarian']));
						if ($pencarian != '') {
							$stmt = $conn->prepare("SELECT * FROM tb_obat WHERE nama_obat LIKE :pencarian  LIMIT :posisi, :batas");
							$stmt->bindValue(':pencarian', "%$pencarian%", PDO::PARAM_STR);
							$stmt->bindValue(':posisi', $posisi, PDO::PARAM_INT);
							$stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
						} else {
							$stmt = $conn->prepare("SELECT * FROM tb_obat LIMIT :posisi, :batas");
							$stmt->bindValue(':posisi', $posisi, PDO::PARAM_INT);
							$stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
							$no = $posisi + 1;
						}
					} else {
						$stmt = $conn->prepare("SELECT * FROM tb_obat LIMIT :posisi, :batas");
						$stmt->bindValue(':posisi', $posisi, PDO::PARAM_INT);
						$stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
						$no = $posisi + 1;
					}

					$stmt->execute();
					if ($stmt->rowCount() > 0) {
						while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $data['nama_obat']; ?></td>
								<td><?= $data['ket_obat']; ?></td>
								<td class="text-center">
									<form action="edit.php" method="post" style="display: inline;">
										<input type="hidden" name="id" value="<?= $data['id_obat']; ?>">
										<button type="submit" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Edit</button>
									</form>
									<form action="del.php" method="post" style="display: inline;">
										<input type="hidden" name="id" value="<?= $data['id_obat']; ?>">
										<button type="submit" class="btn btn-danger" onclick="return confirm('Yakin?')"><i class="glyphicon glyphicon-trash"></i> Del</button>
									</form>
								</td>
							</tr>
					<?php
						}
					} else {
						echo "<tr><td colspan=\"4\" align=\"center\">Data tidak ditemukan</td></tr>";
					}


					?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
	if (@$_POST['pencarian'] == '') { ?>
		<div style="float: left;">
			<?php
			$stmt = $conn->prepare("SELECT COUNT(*) as jml FROM tb_obat");
			$stmt->execute();
			$jml = $stmt->fetch(PDO::FETCH_ASSOC)['jml'];
			echo "Jumlah Data : <b>$jml</b>";
			?>
		</div>
		<div style="float: right;">
			<ul class="pagination pagination-sm" style="margin:0">
				<?php
				$jml_hal = ceil($jml / $batas);
				for ($i = 1; $i <= $jml_hal; $i++) {
					if ($i != $hal) {
						echo "<li><a href=\"?hal=$i\">$i</a></li>";
					} else {
						echo "<li class=\"active\"><a>$i</a></li>";
					}
				}
				?>
			</ul>
		</div>
	<?php

	} else {
		echo "<div style=\"float:left;\">";
		$stmt = $conn->prepare("SELECT COUNT(*) as jml FROM tb_obat WHERE nama_obat LIKE :pencarian");
		$stmt->bindValue(':pencarian', "%$pencarian%", PDO::PARAM_STR);
		$stmt->execute();
		$jml = $stmt->fetch(PDO::FETCH_ASSOC)['jml'];
		echo "Data Hasil Pencarian : <b>$jml</b>";
		echo "</div>";
	}
	?>

</div>

<?php include_once "../dashboard/footer.php"; ?>