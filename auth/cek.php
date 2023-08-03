<?php
session_set_cookie_params(0);
require_once '../config/koneksi.php';

// Cek apakah session 'user' telah terdaftar atau belum
if (!isset($_SESSION['user'])) {
    // Jika session 'user' tidak terdaftar, maka redirect ke halaman login atau tindakan lain yang sesuai
    echo "<script>window.location='" . base_url('auth/login.php') . "';</script>"; // Ganti 'login.php' dengan halaman login Anda
    exit();
}

// Cek apakah waktu session telah kadaluwarsa
$session_expiration = 600; // Durasi session dalam detik (di sini, 1800 detik = 30 menit)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expiration)) {
    // Jika waktu session telah kadaluwarsa, maka hentikan session dan redirect ke halaman login atau tindakan lain yang sesuai
    session_unset();
    session_destroy();
    echo "<script>window.location='" . base_url('auth/login.php') . "';</script>"; // Ganti 'login.php' dengan halaman login Anda
    exit();
}

// Perbarui waktu aktivitas terakhir session
$_SESSION['last_activity'] = time();
