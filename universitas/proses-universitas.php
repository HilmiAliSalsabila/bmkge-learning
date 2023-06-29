<?php


session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit;
}


require_once "../config.php";



// jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    // ambil value yang diposting
    $id = $_POST['id'];
    $nama = trim(htmlspecialchars($_POST['nama']));
    $email = trim(htmlspecialchars($_POST['email']));
    $status = $_POST['status'];
    $akreditasi = $_POST['akreditasi'];
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $visimisi = trim(htmlspecialchars($_POST['visimisi']));
    $gbr = trim(htmlspecialchars($_POST['gbrLama']));


    // cek apakah gambar user
    if ($_FILES['image']['error'] === 4) {
        $gbrUniversitas = $gbr;
    } else {
        $url = 'profile-universitas.php';
        $gbrUniversitas = uploadimg($url);
        @unlink('..asset/image/' . $gbr);
    }

    // update_data
    mysqli_query($koneksi, "UPDATE tbl_universitas SET 
                            nama = '$nama',
                            email = '$email',
                            status = '$status',
                            akreditasi = '$akreditasi',
                            alamat = '$alamat',
                            visimisi = '$visimisi',
                            gambar = '$gbrUniversitas'
                            WHERE id = $id
                            ");
    header("location:profile-universitas.php?msg=updated");
    return;
}
