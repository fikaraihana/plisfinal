<?php
require_once '../auth/cek.php';
require_once "../config/koneksi.php";
require_once "../assets/libs/vendor/autoload.php";
require_once 'cekrekam.php';

use Ramsey\Uuid\Uuid;

if (isset($_POST['add'])) {
    $uuid = htmlspecialchars(Uuid::uuid4()->toString());
    $pasien = trim(htmlspecialchars($_POST['pasien']));
    $keluhan = trim(htmlspecialchars($_POST['keluhan']));
    $dokter = trim(htmlspecialchars($_POST['dokter']));
    $diagnosa = trim(htmlspecialchars($_POST['diagnosa']));
    $poli = trim(htmlspecialchars($_POST['poli']));
    $tgl = trim(htmlspecialchars($_POST['tgl']));

    try {
        $stmt = $conn->prepare("INSERT INTO tb_rekammedis (id_rm, id_pasien, keluhan, id_dokter, diagnosa, id_poli, tgl_periksa) VALUES (:id_rm, :id_pasien, :keluhan, :id_dokter, :diagnosa, :id_poli, :tgl_periksa)");
        $stmt->bindParam(':id_rm', $uuid);
        $stmt->bindParam(':id_pasien', $pasien);
        $stmt->bindParam(':keluhan', $keluhan);
        $stmt->bindParam(':id_dokter', $dokter);
        $stmt->bindParam(':diagnosa', $diagnosa);
        $stmt->bindParam(':id_poli', $poli);
        $stmt->bindParam(':tgl_periksa', $tgl);

        $stmt->execute();

        $obat = $_POST['obat'];
        foreach ($obat as $ob) {
            $stmt_obat = $conn->prepare("INSERT INTO tb_rm_obat (id_rm, id_obat) VALUES (:id_rm, :id_obat)");
            $stmt_obat->bindParam(':id_rm', $uuid);
            $stmt_obat->bindParam(':id_obat', $ob);
            $stmt_obat->execute();
        }

        echo "<script>alert('Data Berhasil Ditambahkan.');window.location='data.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
