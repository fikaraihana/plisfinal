<?php
require_once '../auth/cek.php';
require_once 'cekpasien.php';
include_once('../dashboard/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Data Pasien</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit Data Pasien</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <?php
                    $id = @$_GET['id'];
                    try {
                        $stmt = $conn->prepare("SELECT * FROM tb_pasien WHERE id_pasien = :id_pasien");
                        $stmt->bindParam(':id_pasien', $id);
                        $stmt->execute();
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                    <form action="proses.php" method="post">
                        <div class="form-group">
                            <label for="indentitas">Nomor Identitas</label>
                            <input type="hidden" name="id" value="<?= $data['id_pasien']; ?>">
                            <input type="text" name="indentitas" id="indentitas" class="form-control" required value="<?= $data['nomor_indentitas']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Pasien</label>
                            <input type="text" name="nama" id="nama" class="form-control" required value="<?= $data['nama_pasien']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="jk">Jenis Kelamin</label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="jk" id="jk" value="L" <?= $data['jenis_kelamin'] == "L" ? "checked" : null; ?>> Laki-Laki
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="jk" id="jk" value="P" <?= $data['jenis_kelamin'] == "P" ? "checked" : null; ?>> Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="86" rows="5" required><?= $data['alamat']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No.Telepon</label>
                            <input type="number" name="no_telp" id="no_telp" class="form-control" required value="<?= $data['no_telp']; ?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <?php include_once('../dashboard/footer.php'); ?>