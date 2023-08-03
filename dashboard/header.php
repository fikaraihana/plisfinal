<?php
require_once "../config/koneksi.php";
require_once "../assets/libs/vendor/autoload.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="img-src http://localhost/rekammedis/dashboard/; child-src 'none';">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>App | Rumah Sakit</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/libs/DataTables/datatables.min.css" rel="stylesheet">

    <script src="<?= base_url(); ?>assets/libs/vendor/ckeditor/ckeditor/ckeditor.js"></script>

    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css"> -->
    <style>
        body {
            background-color: #eee;
        }
    </style>


</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="">
                        <span class="text-primary"><b>Sistem Rekam Medis</b></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('dashboard') ?>"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a>
                </li>
                <?php if ($_SESSION['user_level'] == 1) : ?>
                    <li>
                        <a href="<?= base_url('pasien/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Pasien</a>
                    </li>
                    <li>
                        <a href="<?= base_url('dokter/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Dokter</a>
                    </li>
                    <li>
                        <a href="<?= base_url('obat/data.php') ?>"><i class="glyphicon glyphicon-tags"></i> Data Obat</a>
                    </li>
                    <li>
                        <a href="<?= base_url('poliklinik/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Poliklinik</a>
                    </li>
                    <li>
                        <a href="<?= base_url('rekam_medis/data.php') ?>"><i class="glyphicon glyphicon-user"></i> Rekam Medis</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_level'] == 2) : ?>
                    <li>
                        <a href="<?= base_url('obat/data.php') ?>"><i class="glyphicon glyphicon-tags"></i> Data Obat</a>
                    </li>
                    <li>
                        <a href="<?= base_url('rekam_medis/data.php') ?>"><i class="glyphicon glyphicon-user"></i> Rekam Medis</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_level'] == 3) : ?>
                    <li>
                        <a href="<?= base_url('obat/data.php') ?>"><i class="glyphicon glyphicon-tags"></i> Data Obat</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_level'] == 4) : ?>
                    <li>
                        <a href="<?= base_url('pasien/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Pasien</a>
                    </li>
                    <li>
                        <a href="<?= base_url('dokter/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Dokter</a>
                    </li>
                    <li>
                        <a href="<?= base_url('poliklinik/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Poliklinik</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user_level'] == 5) : ?>
                    <li>
                        <a href="<?= base_url('pasien/data.php'); ?>"><i class="glyphicon glyphicon-user"></i> Data Pasien</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?= base_url('auth/logout.php') ?>"><i class="glyphicon glyphicon-log-in"></i> <span class="text-danger">Logout</span></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">