<?php

session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}


require_once "../config.php";

$id = $_GET["id"];
$foto = $_GET["foto"];


mysqli_query($koneksi, "DELETE FROM tbl_dosen WHERE id = $id ");
if ($foto != 'profile.png') {
    unlink("../asset/image/" . $foto);
}

header("location:dosen.php?msg=deleted");
