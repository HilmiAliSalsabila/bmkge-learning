<?php



session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}

require_once "../config.php";


if (isset($_POST['simpan'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $agama = $_POST['agama'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_FILES['image']['name']);


    $cekNip = mysqli_query($koneksi, "SELECT nip FROM tbl_dosen WHERE nip = '$nip'");
    if (mysqli_num_rows($cekNip) > 0) {
        header('location:add-dosen.php?msg=cancel');
        return;
    }

    if ($foto != null) {
        $url = "add-dosen.php";
        $foto = uploadimg($url);
    } else {
        $foto = 'profile.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_dosen VALUES(null, '$nip', '$nama', '$alamat', '$telepon', '$agama', '$foto')");

    header("location:add-dosen.php?msg=added");
    return;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $agama = $_POST['agama'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_POST['fotoLama']);

    $sqlDosen = mysqli_query($koneksi, "SELECT * FROM tbl_dosen WHERE id = $id");
    $data = mysqli_fetch_array($sqlDosen);
    $curNip = $data['nip'];

    $newNip = mysqli_query($koneksi, "SELECT nip FROM tbl_dosen WHERE nip = '$nip' ");

    if ($nip != $curNip) {
        if (mysqli_num_rows($newNip) > 0) {
            header("location:dosen.php?msg=cancel");
            return;
        }
    }

    if ($_FILES['image']['error'] === 4) {
        $fotoDosen = $foto;
    } else {
        $url = "dosen.php";
        $fotoDosen = uploadimg($url);
        if ($foto !== 'profile.png') {
            @unlink('../asset/image/' . $foto);
        }
    }

    mysqli_query($koneksi, "UPDATE tbl_dosen SET
                            nip = '$nip',
                            nama = '$nama',
                            alamat = '$alamat',
                            telepon = '$telepon',
                            agama = '$agama',
                            foto = '$fotoDosen'
                            WHERE id = '$id'
                            ");

    header("location:dosen.php?msg=updated");
    return;
}
