<?php


session_start();


if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit();
}


require_once "../config.php";
$title = "Mata Kuliah - BMKG E-learning";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";


$id = $_GET['id'];

$queryMatkul = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE id = $id");
$data = mysqli_fetch_array($queryMatkul);

?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Mata Kuliah</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="matakuliah.php">Back</a></li>
            </ol>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-pen"></i>Edit Matkul
                        </div>
                        <div class="card-body">
                            <form action="proses-matakuliah.php" method="POST">
                                <input type="number" name="id" value="<?= $data['id'] ?>" hidden>
                                <div class="mb-3">
                                    <label for="matkul" class="form-label ps-1">Matkul</label>
                                    <input type="text" class="form-control" id="matkul" name="matkul" placeholder="nama matkul" value="<?= $data['matkul'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label ps-1">Jurusan</label>
                                    <select name="jurusan" id="jurusan" class="form-select" required>
                                        <?php
                                        $jurusan = ["Umum", "Meteorologi", "Klimatologi", "Geofisika"];
                                        foreach ($jurusan as $jrs) {
                                            if ($data['jurusan'] == $jrs) { ?>
                                                <option value="<?= $jrs ?>" selected><?= $jrs ?></option>
                                            <?php  } else {   ?>
                                                <option value="<?= $jrs ?>"><?= $jrs ?></option>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dosen" class="form-label ps-1">Dosen</label>
                                    <select name="dosen" id="dosen" class="form-select" required>
                                        <?php
                                        $queryDosen = mysqli_query($koneksi, "SELECT * FROM tbl_dosen");
                                        while ($dataDosen = mysqli_fetch_array($queryDosen)) {
                                            if ($data['dosen'] == $dataDosen['nama']) { ?>
                                                <option value="<?= $dataDosen['nama'] ?>" selected><?= $dataDosen['nama'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $dataDosen['nama'] ?>"><?= $dataDosen['nama'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update"><i class="fa-solid fa-pen"></i> Update</button>
                                <a href="matakuliah.php" class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-list"></i> Data Matkul
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">
                                            <center>Mata Kuliah</center>
                                        </th>
                                        <th scope="col">
                                            <center>Jurusan</center>
                                        </th>
                                        <th scope="col">
                                            <center>Dosen</center>
                                        </th>
                                        <th scope="col">
                                            <center>Operasi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $no ?></th>
                                        <td><?= $data['matkul'] ?></td>
                                        <td><?= $data['jurusan'] ?></td>
                                        <td><?= $data['dosen'] ?></td>
                                        <td align="center">
                                            <button type="button" class="btn btn-sm btn-warning rounded-0 col-10">Updating..</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <?php

    require_once "../template/footer.php";

    ?>