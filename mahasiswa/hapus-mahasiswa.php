<?php

session_start();


if (!isset($_SESSION['ssLogin'])) {
    header("Location:../auth/login.php");
    exit();
}


require_once "../config.php";

$id = $_GET['nim'];
$foto = $_GET['foto'];


mysqli_query($koneksi, "DELETE FROM tbl_mahasiswa WHERE nim = '$id'");

if ($fot != 'profile.png') {
    unlink('../asset/image/' . $foto);
}

echo "<script>
        alert('Data Mahasiswa berhasil dihapus..');
        document.location.href='mahasiswa.php';
    </script>";

return;
