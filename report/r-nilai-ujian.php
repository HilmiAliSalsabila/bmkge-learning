<?php


session_start();


if (!isset($_SESSION['ssLogin'])) {
    header("location:../auth/login.php");
    exit();
}


require_once "../config.php";


$noUjian = $_GET['noUjian'];

$dataUjian = mysqli_query($koneksi, "SELECT * FROM tbl_ujian WHERE no_ujian = '$noUjian' ");
$data = mysqli_fetch_array($dataUjian);

$content = '

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>document</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .title {
            text-align: center;
        }

        h3 {
            margin-top: 20px;
        }

        h2 {
            margin-bottom: 30px;
        }

        .head-left {
            width: 100px;
            padding-left: 7px;
            padding-bottom: 5px;
        }

        .head-right {
            color: red;
        }

        hr {
            margin-bottom: 2px;
            margin-left: 5px;
        }

        .head-no {
            padding-left: 20px;
        }

        .head-matkul {
            width: 400px;
        }

        .head-nilai {
            width: 170px;
            text-align: center;
        }

        .data-no {
            padding-left: 20px;
        }

        .data-nilai {
            text-align: center;
        }

        .foot {
            padding-left: -28px;
            padding-bottom: 5px;
        }

        .sum-colon {
            margin-left: 28px;
        }

        .min-nilai {
            margin-left: 8px;
        }

        .max-colon {
            margin-left: 3px;
        }

        .foot-nilai {
            margin-left: 5px;
        }

        .avg-colon {
            margin-left: 34px;
        }
    </style>
</head>

<body>

    <div class="title">
        <h3>Laporan Nilai Ujian</h3>
        <h2>BMKG E-Learning</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th class="head-left">No Ujian</th>
                <th class="head-left"> : ' . $data['no_ujian'] . '</th>
                <th>Tangerang, ' . date('j F Y') . '</th>
            </tr>
            <tr>
                <th class="head-left">Tgl Ujian</th>
                <th class="head-left">: ' . date("d-m-Y", strtotime($data['tgl_ujian'])) . '</th>
            </tr>
            <tr>
                <th class="head-left">NIM</th>
                <th class="head-left">: ' . $data['nim'] . '</th>
            </tr>
            <tr>
                <th class="head-left">Jurusan</th>
                <th class="head-left">: ' . $data['jurusan'] . '</th>
                <th class="head-right">Hasil Ujian : ' . $data['hasil_ujian'] . '</th>
            </tr>
            <tr>
                <th colspan="3">
                    <hr>
                </th>
            </tr>
            <tr>
                <th class="head-no">No</th>
                <th class="head-matkul"> Mata Kuliah</th>
                <th class="head-nilai"> Nilai</th>
            </tr>
            <tr>
                <th colspan="3">
                    <hr>
                </th>
            </tr>

        </thead>
        <tbody>
        ';

$no = 1;
$nilaiUjian = mysqli_query($koneksi, "SELECT * FROM tbl_nilai_ujian WHERE no_ujian = '$noUjian'");
while ($nilai = mysqli_fetch_array($nilaiUjian)) {
    $content .=

        '<tr>
                <td class="data-no">' . $no++ . '</td>
                <td>' . $nilai['matkul'] . '</td>
                <td class="data-nilai">' . $nilai['nilai_ujian'] . '</td>
            </tr>';
}
$content .=
    '</tbody>
        <tfoot>
            <tr>
                <th colspan="3">
                    <hr>
                </th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="foot">Total Nilai<span class="sum-colon"> : ' . $data['total_nilai'] . '</span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="foot">Nilai Terendah :<span class="min-nilai">' . $data['nilai_terendah'] . '</span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="foot">Nilai Tertinggi <span class="max-colon">: </span><span class="foot-nilai">' . $data['nilai_tertinggi'] . '</span></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="foot">Rata-tara<span class="avg-colon"> : </span><span class="foot-nilai">' . $data['nilai_rata2'] . '</span></th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
';


require __DIR__ . '/../asset/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output();
