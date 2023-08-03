<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekrekam.php';

if (isset($_POST['delete'])) {
	$id_rm = $_POST['id'];
	$sql = "DELETE FROM tb_rekammedis WHERE id_rm = :id_rm";
	try {
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id_rm', $id_rm);
		$stmt->execute();
		echo "<script>alert('Data Berhasil Dihapus!');window.location='data.php';</script>";
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
} else {
	echo "<script>alert('Akses tidak valid!');window.location='data.php';</script>";
}
