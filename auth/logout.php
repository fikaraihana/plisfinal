<?php
require_once "../config/koneksi.php";

// Hapus session 'user'
unset($_SESSION['user']);

// Redirect ke halaman login
echo "<script>window.location='" . base_url('auth/login.php') . "';</script>";
exit();
