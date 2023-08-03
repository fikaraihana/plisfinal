<?php
require_once('../auth/cek.php');
require_once 'cekdokter.php';
require_once "../config/koneksi.php";

$chk = @$_POST['checked'];
if (!isset($chk)) {
	echo "<script>alert('Pastikan anda sudah seleksi data.');window.location='data.php';</script>";
	exit;
} else {
	$totalDeleted = 0;

	try {
		$conn->beginTransaction();
		$stmt = $conn->prepare("DELETE FROM tb_dokter WHERE id_dokter = ?");
		foreach ($chk as $id) {
			$stmt->execute([$id]);
			$totalDeleted++;
		}
		$conn->commit();

		echo "<script>alert('" . $totalDeleted . " Data berhasil dihapus.');window.location='data.php';</script>";
	} catch (PDOException $e) {
		$conn->rollBack();
		echo "<script>alert('Data gagal dihapus.');window.location='data.php';</script>";
	}
}
