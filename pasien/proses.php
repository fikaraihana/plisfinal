<?php
require_once '../auth/cek.php';
require_once 'cekpasien.php';
include_once('../dashboard/header.php');
require_once '../assets/libs/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

$uuid = Uuid::uuid4();

if (isset($_POST['add'])) {
    $uuidString = htmlspecialchars($uuid->toString());
    $indentitas = trim(htmlspecialchars($_POST['indentitas']));
    $nama = trim(htmlspecialchars($_POST['nama']));
    $jk = trim(htmlspecialchars($_POST['jk']));
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $no_telp = trim(htmlspecialchars($_POST['no_telp']));
    $sql_cek_indentitas = "SELECT * FROM tb_pasien WHERE nomor_indentitas = :nomor_indentitas";
    try {
        $stmt = $conn->prepare($sql_cek_indentitas);
        $stmt->bindParam(':nomor_indentitas', $indentitas);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Nomor indentitas sudah diinput.');window.location='add.php';</script>";
        } else {
            $sql_insert = "INSERT INTO tb_pasien (id_pasien, nomor_indentitas, nama_pasien, jenis_kelamin, alamat, no_telp) VALUES (:id_pasien, :nomor_indentitas, :nama_pasien, :jenis_kelamin, :alamat, :no_telp)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindParam(':id_pasien', $uuidString);
            $stmt->bindParam(':nomor_indentitas', $indentitas);
            $stmt->bindParam(':nama_pasien', $nama);
            $stmt->bindParam(':jenis_kelamin', $jk);
            $stmt->bindParam(':alamat', $alamat);
            $stmt->bindParam(':no_telp', $no_telp);
            $stmt->execute();
            echo "<script>alert('Data Berhasil Ditambahkan!');window.location='data.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['edit'])) {
    $id = htmlspecialchars($_POST['id']);
    $indentitas = trim(htmlspecialchars($_POST['indentitas']));
    $nama = trim(htmlspecialchars($_POST['nama']));
    $jk = trim(htmlspecialchars($_POST['jk']));
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $no_telp = trim(htmlspecialchars($_POST['no_telp']));
    $sql_cek_indentitas = "SELECT * FROM tb_pasien WHERE nomor_indentitas = :nomor_indentitas AND id_pasien != :id_pasien";
    try {
        $stmt = $conn->prepare($sql_cek_indentitas);
        $stmt->bindParam(':nomor_indentitas', $indentitas);
        $stmt->bindParam(':id_pasien', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Nomor indentitas sudah diinput.');window.location='edit.php?id=$id';</script>";
        } else {
            $sql_update = "UPDATE tb_pasien SET nomor_indentitas = :nomor_indentitas, nama_pasien = :nama_pasien, jenis_kelamin = :jenis_kelamin, alamat = :alamat, no_telp = :no_telp WHERE id_pasien = :id_pasien";
            $stmt = $conn->prepare($sql_update);
            $stmt->bindParam(':nomor_indentitas', $indentitas);
            $stmt->bindParam(':nama_pasien', $nama);
            $stmt->bindParam(':jenis_kelamin', $jk);
            $stmt->bindParam(':alamat', $alamat);
            $stmt->bindParam(':no_telp', $no_telp);
            $stmt->bindParam(':id_pasien', $id);
            $stmt->execute();
            echo "<script>alert('Data Berhasil Ditambahkan!');window.location='data.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_POST['import'])) {
    $file = $_FILES['file']['name'];

    $ekstensi = explode(".", $file);
    $file_name = "file-" . round(microtime(true)) . "." . end($ekstensi);
    $sumber = $_FILES['file']['tmp_name'];
    $target_dir = "../file/";
    $target_file = $target_dir . $file_name;
    move_uploaded_file($sumber, $target_file);

    // Menggunakan IOFactory dari namespace PhpOffice\PhpSpreadsheet
    $obj = PHPExcel_IOFactory::load($target_file);
    $all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

    $sql = "INSERT INTO tb_pasien (id_pasien, nomor_indentitas, nama_pasien, jenis_kelamin, alamat, no_telp) VALUES";
    for ($i = 3; $i <= count($all_data); $i++) {
        $uuid = htmlspecialchars(Uuid::uuid4()->toString());
        $no_id = htmlspecialchars($all_data[$i]['A']);
        $nama = htmlspecialchars($all_data[$i]['B']);
        $jk = htmlspecialchars($all_data[$i]['C']);
        $alamat = htmlspecialchars($all_data[$i]['D']);
        $telp = htmlspecialchars($all_data[$i]['E']);

        $sql .= "(:id_pasien, :nomor_indentitas, :nama_pasien, :jenis_kelamin, :alamat, :no_telp),";
    }
    $sql = substr($sql, 0, -1);
    try {
        $stmt = $conn->prepare($sql);
        for ($i = 3; $i <= count($all_data); $i++) {
            $uuid = Uuid::uuid4()->toString();
            $no_id = $all_data[$i]['A'];
            $nama = $all_data[$i]['B'];
            $jk = $all_data[$i]['C'];
            $alamat = $all_data[$i]['D'];
            $telp = $all_data[$i]['E'];

            $stmt->bindParam(':id_pasien', $uuid);
            $stmt->bindParam(':nomor_indentitas', $no_id);
            $stmt->bindParam(':nama_pasien', $nama);
            $stmt->bindParam(':jenis_kelamin', $jk);
            $stmt->bindParam(':alamat', $alamat);
            $stmt->bindParam(':no_telp', $telp);
            $stmt->execute();
        }
        unlink($target_file);
        echo "<script>alert('Data Berhasil Ditambahkan!');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
