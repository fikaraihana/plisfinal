<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekpasien.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM tb_pasien WHERE id_pasien = :id_pasien");
        $stmt->bindParam(':id_pasien', $id);
        $stmt->execute();

        echo "<script>window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
