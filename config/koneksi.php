<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
include_once "conn.php";
// cek koneksi
try {
	$conn = new PDO("mysql:host=" . $con['host'] . ";dbname=" . $con['db'], $con['user'], $con['pass']);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Koneksi database gagal: " . $e->getMessage();
}

// base_url
function base_url($url = null)
{
	$base_url = "http://localhost/rekammedis/";
	if ($url != null) {
		return $base_url . $url;
	} else {
		return $base_url;
	}
}

function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = substr($tgl, 5, 2);
	$tahun = substr($tgl, 0, 4);
	return $tanggal . "/" . $bulan . "/" . $tahun;
}
