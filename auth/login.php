<?php
require_once "../config/koneksi.php";

function filter_input_data($data)
{
	return htmlspecialchars(trim($data));
}

function validate_input($user, $pass)
{
	$errors = array();

	if (empty($user)) {
		$errors[] = "Username tidak boleh kosong.";
	}

	if (empty($pass)) {
		$errors[] = "Password tidak boleh kosong.";
	}

	return $errors;
}

if (isset($_SESSION['user'])) {
	echo "<script>window.location='" . base_url() . "';</script>";
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = filter_input_data($_POST['user']);
	$pass = filter_input_data($_POST['pass']);

	// Validasi input
	$errors = validate_input($user, $pass);

	if (count($errors) === 0) {
		try {
			// Prepared statement
			$query = "SELECT * FROM tb_user WHERE username = :username AND password = :password";
			$stmt = $conn->prepare($query);
			$stmt->bindValue(':username', $user, PDO::PARAM_STR);
			$stmt->bindValue(':password', sha1($pass), PDO::PARAM_STR);
			$stmt->execute();
			$userData = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($stmt->rowCount() > 0) {
				$_SESSION['user'] = $user;
				$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['last_activity'] = time();
				$_SESSION['user_level'] = $userData['level'];
				$_SESSION['namauser'] = $userData['nama_user'];
				echo "<script>window.location='" . base_url() . "';</script>";
				exit();
			} else {
				echo "<div class='row'>
                    <div class='col-lg-6-offset-3'>
                        <div class='alert alert-danger alert-dismissable' role='alert'>
                            <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                            <strong>Login Gagal!</strong> Username / Password Salah!
                        </div>
                    </div>
                </div>";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	} else {
		echo "<div class='row'>
            <div class='col-lg-6-offset-3'>
                <div class='alert alert-danger alert-dismissable' role='alert'>
                    <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <strong>Login Gagal!</strong> Harap perbaiki kesalahan berikut:<br>";
		foreach ($errors as $error) {
			echo "- $error<br>";
		}
		echo "</div>
            </div>
        </div>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Login Page | Rumah Sakit</title>
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<!-- <div class="tittle">
					<h1>Sistem Rekam Medis</h1>
				</div> -->
				<div class="tittle">
					<h1 class="tittle-text">Sistem Rekam Medis</h1>
				</div>
				<div class="login">
					<form action="" method="post" class="navbar-form">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="user" class="form-control" required="" placeholder="Masukkan username" autofocus="on">
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="pass" class="form-control" required="" placeholder="Masukkan password">
						</div>
						<div class="input-group">
							<button type="submit" name="login" class="btn btn-primary">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="<?= base_url(); ?>assets/js/jquery.js"></script>
	<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
</body>

</html>