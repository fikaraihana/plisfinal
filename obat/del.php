<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekobat.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM tb_obat WHERE id_obat = :id_obat");
        $stmt->bindParam(':id_obat', $id);
        $stmt->execute();

        echo "<script>alert('Data Berhasil Dihapus!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<script>alert('Akses tidak valid!');window.location='data.php';</script>";
}
