<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once 'cekobat.php';
require_once "../assets/libs/vendor/autoload.php";

use Ramsey\Uuid\Uuid;

if (isset($_POST['add'])) {
    $uuid = htmlspecialchars(Uuid::uuid4()->toString());
    $nama = trim(htmlspecialchars($_POST['nama']));
    $ket = trim(htmlspecialchars($_POST['ket']));

    try {
        $stmt = $conn->prepare("INSERT INTO tb_obat (id_obat, nama_obat, ket_obat) VALUES (:id_obat, :nama_obat, :ket_obat)");
        $stmt->bindParam(':id_obat', $uuid);
        $stmt->bindParam(':nama_obat', $nama);
        $stmt->bindParam(':ket_obat', $ket);
        $stmt->execute();

        echo "<script>alert('Data Berhasil Ditambahkan!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['edit'])) {
    $id = htmlspecialchars($_POST['id']);
    $nama = trim(htmlspecialchars($_POST['nama']));
    $ket = trim(htmlspecialchars($_POST['ket']));

    try {
        $stmt = $conn->prepare("UPDATE tb_obat SET nama_obat = :nama_obat, ket_obat = :ket_obat WHERE id_obat = :id_obat");
        $stmt->bindParam(':nama_obat', $nama);
        $stmt->bindParam(':ket_obat', $ket);
        $stmt->bindParam(':id_obat', $id);
        $stmt->execute();

        echo "<script>alert('Data Berhasil Diubah!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
