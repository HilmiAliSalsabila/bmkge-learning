<?php


session_start();


if (!isset($_SESSION["ssLogin"])) {
    header("Location:../auth/login.php");
    exit();
}


require_once "../config.php";
$title = "Dosen - BMKG E-learning";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = "";
}

$alert = '';
if ($msg == 'deleted') {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-check"></i> Data Dosen Berhasil di hapus...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-check"></i> Data Dosen Berhasil di update...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

if ($msg == 'cancel') {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-xmark"></i> Data Dosen gagal di update, NIP Sudah ada ...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dosen</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item "><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Dosen</li>
            </ol>
            <?php if ($msg != "") {
                echo $alert;
            }

            ?>
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-list"></i> Data Dosen
                    <a href="<?= $main_url ?>dosen/add-dosen.php " class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i>Tambah Dosen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <center>No</center>
                                </th>
                                <th scope="col">
                                    <center>Foto</center>
                                </th>
                                <th scope="col">
                                    <center>NIP</center>
                                </th>
                                <th scope="col">
                                    <center>Nama</center>
                                </th>
                                <th scope="col">
                                    <center>Telepon</center>
                                </th>
                                <th scope="col">
                                    <center>Agama</center>
                                </th>
                                <th scope="col">
                                    <center>Alamat</center>
                                </th>
                                <th scope="col">
                                    <center>Operasi</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $queryDosen = mysqli_query($koneksi, "SELECT * FROM tbl_dosen");
                            while ($data =  mysqli_fetch_array($queryDosen)) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td align="center"><img src="../asset//image/<?= $data['foto'] ?>" class="rounded-circle" width="60px" alt=""></td>
                                    <td><?= $data['nip'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['telepon'] ?></td>
                                    <td><?= $data['agama'] ?></td>
                                    <td><?= $data['alamat'] ?></td>
                                    <td align="center">
                                        <a href="edit-dosen.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning" title="Update Dosen"><i class="fa-solid fa-pen"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger" id="btnHapus" title="hapus dosen" data-id="<?= $data['id'] ?>" data-foto="<?= $data['foto'] ?> "><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <!-- modal hapus data -->

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
                let idDosen = $(this).data('id');
                let fotoDosen = $(this).data('foto');
                $('#btnMdlHapus').attr("href", "hapus-dosen.php?id=" + idDosen + "&foto=" + fotoDosen);
            });
        })
    </script>

    <?php


    require_once "../template/footer.php";

    ?>