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


if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = "";
}

$alert = '';
if ($msg == 'cancel') {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-xmark"></i> Tambah Mata Kuliah Gagal, Mata Kuliah Sudah ada..
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

if ($msg == 'added') {
    $alert = '<div class="alert alert-success alert-dismissible" style="display: none;" id="added" role="alert">
    <i class="fa-solid fa-circle-check"></i> Tambah Mata Kuliah Berhasil ..
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if ($msg == 'deleted') {
    $alert = '<div class="alert alert-success alert-dismissible fade show " role="alert">
    <i class="fa-solid fa-circle-check"></i> Mata Kuliah Berhasil Dihapus..
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if ($msg == 'cancelupdate') {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-xmark"></i> Update Mata Kuliah Gagal, Mata Kuliah Sudah ada..
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible" style="display: none;" role="alert" id="updated">
    <i class="fa-solid fa-circle-check"></i> Mata Kuliah Berhasil diupdate..
  </div>';
}

?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Mata Kuliah</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Mata Kuliah</li>
            </ol>
            <?php
            if ($msg != '') {
                echo $alert;
            }

            ?>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-plus"></i> Tambah Matkul
                        </div>
                        <div class="card-body">
                            <form action="proses-matakuliah.php" method="POST">
                                <div class="mb-3">
                                    <label for="matkul" class="form-label ps-1">Matkul</label>
                                    <input type="text" class="form-control" id="matkul" name="matkul" placeholder="nama matkul" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label ps-1">Jurusan</label>
                                    <select name="jurusan" id="jurusan" class="form-select" required>
                                        <option value="" selected>-- Pilih Jurusan --</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Meteorologi">Meteorologi</option>
                                        <option value="Klimatologi">Klimatologi</option>
                                        <option value="Geofisika">Geofisika</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dosen" class="form-label ps-1">Dosen</label>
                                    <select name="dosen" id="dosen" class="form-select" required>
                                        <option value="" selected>-- Pilih Dosen --</option>
                                        <?php
                                        $queryDosen = mysqli_query($koneksi, "SELECT * FROM tbl_dosen");
                                        while ($dataDosen = mysqli_fetch_array($queryDosen)) { ?>
                                            <option value="<?= $dataDosen['nama'] ?>"><?= $dataDosen['nama'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                                <button type="reset" class="btn btn-danger" name="reset"><i class="fa-solid fa-xmark"></i> Reset</button>
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
                            <div class="d-flex justify-content-between">
                                <form action="" method="GET" class="col-4">
                                    <?php
                                    if (@$_GET['cari']) {
                                        $cari = @$_GET['cari'];
                                    } else {
                                        $cari = '';
                                    }

                                    ?>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Keyword" name="cari" value="<?= $cari ?>">
                                        <button class="btn btn-secondary" type="submit" id="btnCari"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                                <?php
                                $page = 5;
                                if (isset($_GET['hal'])) {
                                    $halaktif = $_GET['hal'];
                                } else {
                                    $halaktif = 1;
                                }

                                if (@$_GET['cari']) {
                                    $keyword = @$_GET['cari'];
                                } else {
                                    $keyword = '';
                                }

                                $start = ($page * $halaktif) - $page;
                                $no = $start + 1;

                                $queryMatkul = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE matkul like '%$keyword%' or jurusan like '%$keyword%' or dosen like '%$keyword%' limit $page offset $start ");


                                $quaryJmlData = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE matkul like '%$keyword%' or jurusan like '%$keyword%' or dosen like '%$keyword%' ");
                                $jmlData = mysqli_num_rows($quaryJmlData);
                                $pages = ceil($jmlData / $page);
                                ?>
                                <div class="col-4 text-end">
                                    <label class="col-8 col-form-label text-end">Jumlah Data : <?= $jmlData ?></label>
                                </div>
                            </div>
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



                                    if (mysqli_num_rows($queryMatkul) > 0) {
                                        while ($data = mysqli_fetch_array($queryMatkul)) { ?>
                                            <tr>
                                                <th scope="row"><?= $no++ ?></th>
                                                <td><?= $data['matkul'] ?></td>
                                                <td><?= $data['jurusan'] ?></td>
                                                <td><?= $data['dosen'] ?></td>
                                                <td align="center">
                                                    <a href="edit-matakuliah.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning" title="Update Matkul"><i class="fa-solid fa-pen"></i></a>
                                                    <button type="button" data-id="<?= $data['id'] ?>" id="btnHapus" class="btn btn-sm btn-danger" title="Hapus Matkul"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="5" align="center">Tidak Ada Data</td>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php if ($halaktif > 1) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?hal= <?= $halaktif - 1 ?>&cari=<?= $keyword ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php }
                                    for ($hal = 1; $hal <= $pages; $hal++) {
                                        if ($hal == $halaktif) { ?>
                                            <li class="page-item active"><a class="page-link" href="?hal= <?= $hal ?>&cari=<?= $keyword ?> "><?= $hal ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item"><a class="page-link" href="?hal= <?= $hal ?>&cari=<?= $keyword ?> "><?= $hal ?></a></li>
                                        <?php }
                                    }

                                    if ($halaktif < $pages) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?hal= <?= $halaktif + 1 ?>&cari=<?= $keyword ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal" id="mdlHapus" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin akan menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="" id="btnMdlHapus" class="btn btn-primary">Ya</a>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $(document).on('click', "#btnHapus", function() {
                $('#mdlHapus').modal('show');
                let id = $(this).data('id');
                $('#btnMdlHapus').attr('href', "hapus-matakuliah.php?id=" + id);
            })

            setTimeout(function() {
                $('#added').fadeIn('slow');
            }, 300)
            setTimeout(function() {
                $('#added').fadeOut('slow');
            }, 3000)

            setTimeout(function() {
                $('#updated').slideDown(700);
            }, 300)
            setTimeout(function() {
                $('#updated').slideUp(700);
            }, 5000)
        })
    </script>

    <?php

    require_once "../template/footer.php";

    ?>