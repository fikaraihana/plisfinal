<?php
$allowed_user_levels = array('1', '2', '3');
if (in_array($_SESSION['user_level'], $allowed_user_levels)) {
	// Tindakan jika user_level adalah 1, 2, atau 3
} else {
	echo "<script>alert('Anda tidak diizinkan mengakses halaman ini!');window.location='" . base_url() . "';</script>";
}
