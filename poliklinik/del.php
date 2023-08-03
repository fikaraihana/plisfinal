<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekpoli.php';

$chk = @$_POST['checked'];
if (!isset($chk)) {
	echo "<script>alert('Tidak ada data yang dipilih.'); window.location='data.php';</script>";
} else {
	try {
		$conn->beginTransaction();

		foreach ($chk as $id) {
			$sql = "DELETE FROM tb_poliklinik WHERE id_poli = :id_poli";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':id_poli', $id);
			$stmt->execute();
		}

		$conn->commit();
		echo "<script>alert('" . count($chk) . " data berhasil dihapus.');window.location='data.php';</script>";
	} catch (PDOException $e) {
		$conn->rollback();
		echo "<script>alert('" . count($chk) . " Data gagal dihapus.');window.location='data.php';</script>";
	}
}
