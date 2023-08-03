<?php

require_once '../auth/cek.php';
include_once('header.php');
?>

<div class="row">
	<div class="col-lg-12">
		<h1>Dashboard</h1>
		<p>Selamat Datang <code><?= $_SESSION['namauser'] ?></code> di website Rumah Sakit
		</p>
	</div>
</div>


<?php include_once('footer.php'); ?>