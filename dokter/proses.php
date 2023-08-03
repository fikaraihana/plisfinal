<?php
require_once('../auth/cek.php');
require_once "../config/koneksi.php";
require_once 'cekdokter.php';
require_once "../assets/libs/vendor/autoload.php";


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Rfc4122\FieldsInterface;

$uuid = Uuid::uuid4()->toString(); // Mengubah UUID menjadi string

if (isset($_POST['add'])) {
    $uuidObject = Uuid::fromString($uuid);
    $uuidFields = $uuidObject->getFields();
    $uuidVersion = $uuidFields instanceof FieldsInterface ? $uuidFields->getVersion() : null;

    try {
        $stmt = $conn->prepare("INSERT INTO tb_dokter (id_dokter, nama_dokter, spesialis, alamat, no_telp) VALUES (:id_dokter, :nama_dokter, :spesialis, :alamat, :no_telp)");
        $stmt->bindParam(':id_dokter', $uuid);
        $stmt->bindParam(':nama_dokter', htmlspecialchars($_POST['nama']));
        $stmt->bindParam(':spesialis', htmlspecialchars($_POST['spesialis']));
        $stmt->bindParam(':alamat', htmlspecialchars($_POST['alamat']));
        $stmt->bindParam(':no_telp', htmlspecialchars($_POST['no_telp']));
        $stmt->execute();

        echo "<script>alert('Data Berhasil Ditambahkan!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['edit'])) {
    $id = htmlspecialchars($_POST['id']);
    $nama = trim(htmlspecialchars($_POST['nama']));
    $spesialis = trim(htmlspecialchars($_POST['spesialis']));
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $no_telp = trim(htmlspecialchars($_POST['no_telp']));

    try {
        $stmt = $conn->prepare("UPDATE tb_dokter SET nama_dokter = :nama_dokter, spesialis = :spesialis, alamat = :alamat, no_telp = :no_telp WHERE id_dokter = :id_dokter");
        $stmt->bindParam(':nama_dokter', $nama);
        $stmt->bindParam(':spesialis', $spesialis);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':no_telp', $no_telp);
        $stmt->bindParam(':id_dokter', $id);
        $stmt->execute();

        echo "<script>alert('Data Berhasil Diubah!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
