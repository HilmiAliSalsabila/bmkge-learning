<?php


session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}

require_once "../config.php";


if (isset($_POST['simpan'])) {
    $matkul = htmlspecialchars($_POST['matkul']);
    $jurusan = $_POST['jurusan'];
    $dosen = $_POST['dosen'];

    $cekMatkul = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE matkul = '$matkul' ");
    if (mysqli_num_rows($cekMatkul) > 0) {
        header("location:matakuliah.php?msg=cancel");
        return;
    }


    mysqli_query($koneksi, "INSERT INTO tbl_matakuliah VALUES (null, '$matkul', '$jurusan', '$dosen')");

    header("location:matakuliah.php?msg=added");
    return;
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $matkul = htmlspecialchars($_POST['matkul']);
    $jurusan = $_POST['jurusan'];
    $dosen = $_POST['dosen'];

    $queryMatkul = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE id = $id");
    $data = mysqli_fetch_array($queryMatkul);
    $curMatkul = $data['matkul'];

    $cekMatkul = mysqli_query($koneksi, "SELECT * FROM tbl_matakuliah WHERE matkul = '$matkul'");

    if ($matkul != $curMatkul) {
        if (mysqli_num_rows($cekMatkul) > 0) {
            header("location:matakuliah.php?msg=cancelupdate");
            return;
        }
    }

    mysqli_query($koneksi, "UPDATE tbl_matakuliah SET matkul = '$matkul', jurusan = '$jurusan', dosen = '$dosen' WHERE id = $id");


    header("location:matakuliah.php?msg=updated");
    return;
}
