<?php

session_start();


if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit;
}


require_once "../config.php";



if (isset($_POST['simpan'])) {
    $noUjian = htmlspecialchars($_POST['noUjian']);
    $tgl = htmlspecialchars($_POST['tgl']);
    $nim = htmlspecialchars($_POST['nim']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $sum = htmlspecialchars($_POST['sum']);
    $min = htmlspecialchars($_POST['min']);
    $max = htmlspecialchars($_POST['max']);
    $avg = htmlspecialchars($_POST['avg']);




    if ($min < 50 or $avg < 60) {
        $hasilUjian = "GAGAL";
    } else {
        $hasilUjian = "LULUS";
    }

    $maktul = $_POST['matkul'];
    $jurus = $_POST['jurus'];
    $nilai = $_POST['nilai'];


    mysqli_query($koneksi, "INSERT INTO tbl_ujian VALUES('$noUjian', '$tgl', '$nim', '$jurusan', $sum, $min, $max, $avg, '$hasilUjian') ");
    if (mysqli_errno($koneksi)) {
        die("Error: " . mysqli_error($koneksi));
    }


    foreach ($maktul as $key => $mkl) {
        mysqli_query($koneksi, "INSERT INTO tbl_nilai_ujian VALUES(null, '$noUjian', '$mkl', '$jurus[$key]', $nilai[$key])");
    }

    header("location:nilai-ujian.php?msg=$hasilUjian&nim=$nim");

    exit;
}
