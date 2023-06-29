<?php


session_start();


if (!isset($_SESSION["ssLogin"])) {
    header("Location: ../auth/login.php");
    exit;
}


require_once "../config.php";
$title = "Update Mahasiswa - BMKG E-Learning";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

$nim = trim($_GET['nim']);


$mahasiswa = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'");
$data = mysqli_fetch_array($mahasiswa);


?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Mahasiswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item "><a href="mahasiswa.php">Mahasiswa</a></li>
                <li class="breadcrumb-item active">Update Mahasiswa</li>
            </ol>
            <form action="proses-mahasiswa.php" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Update Mahasiswa</span>
                        <button type="submit" name="update" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-3 row">
                                    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                    <label for="nim" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px ;">
                                        <input type="text" name="nim" readonly class="form-control-plaintext border-bottom ps-2" id="nim" value="<?= $nim ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <label for="nim" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px ;">
                                        <input type="text" name="nama" required class="form-control border-0 border-bottom ps-2" id="nama" value="<?= $data['nama'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                    <label for="nim" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px ;">
                                        <select name="kelas" id="kelas" class="form-select border-0 border-bottom" required>
                                            <?php
                                            $kelas = ["A", "B", "C"];
                                            foreach ($kelas as $kls) {
                                                if ($data['kelas'] == $kls) { ?>
                                                    <option value="<?= $kls; ?>" selected><?= $kls; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $kls; ?>"><?= $kls ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                                    <label for="nim" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px ;">
                                        <select name="jurusan" id="jurusan" class="form-select border-0 border-bottom" required>
                                            <?php
                                            $jurusan = ["Meteorologi", "Klimotologi", "Geofisika"];
                                            foreach ($jurusan as $jrs) {
                                                if ($data['jurusan'] == $jrs) {   ?>
                                                    <option value="<?= $jrs ?>" selected><?= $jrs ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $jrs ?>"><?= $jrs ?></option>
                                            <?php    }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <label for="nim" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px ;">
                                        <textarea name="alamat" id="alamat" cols="30" rows="3" placeholder="alamat mahasiswa" class="form-control" required><?= $data['alamat'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center px-5 ">
                                <input type="hidden" name="fotoLama" value="<?= $data['foto'] ?>">
                                <img src="../asset/image/<?= $data['foto'] ?>" alt="" class="mb-3 rounded-circle " width="40%">
                                <input type="file" name="image" class="form-control form-control-sm">
                                <small class="text-secondary">Pilih foto PNG, JPG atau JPRG dengan ukuran maksimal 1 MB</small>
                                <div><small class="text-secondary">width = height </small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php


    require_once "../template/footer.php";

    ?>