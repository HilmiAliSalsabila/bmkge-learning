<?php


session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit();
}

require_once "../config.php";

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_FILES['image']['name']);



    if ($foto != null) {
        $url = "add-mahasiswa.php";
        $foto = uploadimg($url);
    } else {
        $foto = 'profile.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_mahasiswa VALUES('$nim', '$nama', '$alamat', '$kelas', '$jurusan', '$foto')");

    echo "<script>
                alert('Data Mahasiswa berhasil disimpan');
                document.location.href = 'add-mahasiswa.php';
        </script>";
    return;
} else if (isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_POST['fotoLama']);


    if ($_FILES['image']['error'] === 4) {
        $fotoMahasiswa = $foto;
    } else {
        $url = "mahasiswa.php";
        $fotoMahasiswa = uploadimg($url);
        if ($foto != 'profile.png') {
            @unlink('../asset/image/' . $foto);
        }
    }

    mysqli_query($koneksi, "UPDATE tbl_mahasiswa SET
                            nama = '$nama',
                            kelas = '$kelas',
                            jurusan = '$jurusan',
                            alamat = '$alamat',
                            foto = '$fotoMahasiswa'
                            WHERE NIM = '$nim'
                            ");

    echo "<script>
            alert('Data Mahasiswa Berhasil diupdate');
            document.location.href='mahasiswa.php';    
        </script>";
    return;
}
