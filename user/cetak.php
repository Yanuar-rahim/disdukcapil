<?php
session_start();
include '../includes/koneksi.php';

$id = $_GET['id'];
$nama = $_SESSION['user_nama'];

$data = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT * FROM pengajuan WHERE id='$id' AND nama='$nama'"
));
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bukti Pengajuan</title>
    <style>
        body {
            font-family: Arial;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>Bukti Pengajuan Dokumen</h2>

    <table>
        <tr>
            <th>Jenis Dokumen</th>
            <td><?= $data['jenis_dokumen']; ?></td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td><?= $data['tanggal_pengajuan']; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= $data['status']; ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?= $data['keterangan']; ?></td>
        </tr>
    </table>

    <p style="margin-top:30px;">
        Disdukcapil — Sistem Informasi Pengajuan Dokumen
    </p>

</body>

</html>