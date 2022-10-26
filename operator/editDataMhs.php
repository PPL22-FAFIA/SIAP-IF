<?php require_once '../bootstrap/header.html';
require_once '../lib/db_login.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
}
$nim = $_GET["nimnip"];
$query = "SELECT * FROM tb_mhs WHERE Nim = '$nim'";
// execute query
$result = $db->query($query)->fetch_object();
// fetch object
?>
<div class="row g-0">
    <div class="col-2">
        <?php require_once '../dashboard/sidebarOp.php' ?>

    </div>
    <div class="col p-4">
        <h1 class="d-flex justify-content-center">Edit Data Mahasiswa</h1>
        <div class="card">
            <form class="card-body">
                <div class="mt-4 row gx-5 d-flex flex-row">
                    <div class="form-group mt-3">
                        <label class="fw-bold">Nama</label>
                        <div class="col">
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?= $result->Nama ?>">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Email</label>
                        <div class="col">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= $result->Email_SSO ?>">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">No Telepon</label>
                        <div class="col">
                            <input type="text" id="noHP" name="noHP" class="form-control" placeholder="No HP" value="<?= $result->No_HP ?>">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Status</label>
                        <select name="status" id="status" class="form-select" aria-label="Default select example">
                            <option <?php if($result->Status == "Aktif") echo "selected"?> value="Aktif">Aktif</option>
                            <option <?php if($result->Status == "Cuti") echo "selected"?> value="Cuti">Cuti</option>
                            <option value="Undur Diri">Undur Diri</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Alamat</label>
                        <div class="col">
                            <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" value="<?= $result->Alamat?>">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Provinsi</label>
                        <div class="col">
                            <select class="form-control" id="provinsi" name="provinsi" onchange="getKabupaten(this.value)">
                                <?php $resultProv = $db->query('SELECT p.Nama_Provinsi, p.Kode_Provinsi FROM tb_mhs m JOIN tb_provinsi p JOIN tb_kabupaten k WHERE k.Kode_Kabupaten = m.Kode_Kabupaten AND k.Kode_Provinsi = p.Kode_Provinsi AND m.Nim = "' . $result->Nim . '"');
                                $provsaatini = $resultProv->fetch_object();
                                ?>
                                <?php
                                $result3 = $db->query('select * from tb_provinsi');

                                while ($prov = $result3->fetch_object()) :
                                ?>
                                    <option value="<?php echo $prov->Kode_Provinsi ?>" <?php if ($prov->Kode_Provinsi == $provsaatini->Kode_Provinsi) echo "selected" ?>><?php echo $prov->Nama_Provinsi ?></option>
                                <?php endwhile ?>
                            </select>
                            <small class="form-text text-danger" id="provinsi_error"></small>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Kabupaten</label>
                        <div class="col">
                            <select class="form-control" id="kabupaten" name="kabupaten">
                                <?php
                                $result4 = $db->query('select * from tb_kabupaten where Kode_Provinsi="' . $provsaatini->Kode_Provinsi . '"');


                                ?>
                                <?php while ($kab = $result4->fetch_object()) : ?>
                                    <option value="<?php echo $kab->Kode_Kabupaten ?>" <?php if ($result->Kode_Kabupaten == $kab->Kode_Kabupaten) echo "selected" ?>><?php echo $kab->Nama_Kabupaten ?></option>
                                <?php
                                endwhile; ?>
                            </select>
                            <small class="form-text text-danger" id="kabupaten_error"></small>
                        </div>
                    </div>
                    <!-- button update data -->
                </div>
                <div class="text-center">
                    <input type="hidden" name="nim" value="<?= $nim?>" id="nim">
                    <button type="button" onclick="editMhsOperator()" class="btn btn-primary fw-bold mt-4">Update</button>
                </div>
                <div id="responseedit">
                </div>

            </form>
        </div>
    </div>
    <script src="../js/ajax.js"></script>
    <?php require_once '../bootstrap/footer.html' ?>