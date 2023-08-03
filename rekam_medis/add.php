<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekrekam.php';
include_once "../dashboard/header.php";


use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$pasien = $_POST['pasien'];
	$keluhan = htmlspecialchars($_POST['keluhan']);
	$dokter = $_POST['dokter'];
	$diagnosa = $_POST['diagnosa'];
	$poli = $_POST['poli'];
	$tgl = $_POST['tgl'];

	try {
		$stmt = $conn->prepare("INSERT INTO tb_rekammedis (id_rm, id_pasien, keluhan, id_dokter, diagnosa, id_poli, tgl_periksa) VALUES (:id_rm, :id_pasien, :keluhan, :id_dokter, :diagnosa, :id_poli, :tgl_periksa)");
		$uuid = Uuid::uuid4()->toString();
		$stmt->bindParam(':id_rm', $uuid);
		$stmt->bindParam(':id_pasien', $pasien);
		$stmt->bindParam(':keluhan', $keluhan);
		$stmt->bindParam(':id_dokter', $dokter);
		$stmt->bindParam(':diagnosa', $diagnosa);
		$stmt->bindParam(':id_poli', $poli);
		$stmt->bindParam(':tgl_periksa', $tgl);

		if ($stmt->execute()) {
			$obat = $_POST['obat'];
			foreach ($obat as $ob) {
				$stmt_obat = $conn->prepare("INSERT INTO tb_rm_obat (id_rm, id_obat) VALUES (:id_rm, :id_obat)");
				$stmt_obat->bindParam(':id_rm', $uuid);
				$stmt_obat->bindParam(':id_obat', $ob);
				$stmt_obat->execute();
			}

			echo "<script>alert('Data Berhasil Ditambahkan.');window.location='data.php';</script>";
		} else {
			echo "<script>alert('Gagal menambahkan data.');</script>";
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}
?>

<div class="box">
	<h1>Data Rekam Medis</h1>
	<h4>
		<small>Data Rekam Medis</small>
		<div class="pull-right">
			<a href="data.php" class="btn btn-success"><i class="glyphicon glyphicon-chevron-left"></i>Kembali</a>
		</div>
	</h4>
</div>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<form action="add.php" method="post">
			<div class="form-group">
				<label for="pasien">Pasien</label>
				<select name="pasien" id="pasien" class="form-control" required>
					<option value="">-- Pilih --</option>
					<?php
					$stmt_pasien = $conn->prepare("SELECT * FROM tb_pasien");
					$stmt_pasien->execute();
					$result_pasien = $stmt_pasien->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result_pasien as $data_pasien) {
						echo '<option value="' . $data_pasien['id_pasien'] . '">' . $data_pasien['nama_pasien'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="keluhan">Keluhan</label><br>
				<textarea name="keluhan" id="keluhan" cols="86" rows="5" required></textarea>
			</div>
			<div class="form-group">
				<label for="dokter">Dokter</label>
				<select name="dokter" id="dokter" class="form-control" required>
					<option value="">-- Pilih --</option>
					<?php
					$stmt_dokter = $conn->prepare("SELECT * FROM tb_dokter");
					$stmt_dokter->execute();
					$result_dokter = $stmt_dokter->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result_dokter as $data_dokter) {
						echo '<option value="' . $data_dokter['id_dokter'] . '">' . $data_dokter['nama_dokter'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="diagnosa">Diagnosa</label><br>
				<textarea name="diagnosa" id="diagnosa" cols="86" rows="5" required></textarea>
			</div>
			<div class="form-group">
				<label for="poli">Poliklinik</label>
				<select name="poli" id="poli" class="form-control" required>
					<option value="">-- Pilih --</option>
					<?php
					$stmt_poli = $conn->prepare("SELECT * FROM tb_poliklinik ORDER BY nama_poli DESC");
					$stmt_poli->execute();
					$result_poli = $stmt_poli->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result_poli as $data_poli) {
						echo '<option value="' . $data_poli['id_poli'] . '">' . $data_poli['nama_poli'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="obat">Obat</label>
				<select multiple size="6" name="obat[]" id="obat" class="form-control" required>
					<?php
					$stmt_obat = $conn->prepare("SELECT * FROM tb_obat");
					$stmt_obat->execute();
					$result_obat = $stmt_obat->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result_obat as $data_obat) {
						echo '<option value="' . $data_obat['id_obat'] . '">' . $data_obat['nama_obat'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="tgl">Tanggal Periksa</label>
				<input type="date" name="tgl" id="tgl" class="form-control" required value="<?= date('Y-m-d'); ?>">
			</div>
			<div class="form-group pull-right">
				<button type="submit" name="add" class="btn btn-primary">Tambah Rekam Medis</button>
				<button type="reset" name="reset" class="btn btn-secondary">Reset</button>
			</div>
		</form>
	</div>
</div>

<?php include_once "../dashboard/footer.php"; ?>