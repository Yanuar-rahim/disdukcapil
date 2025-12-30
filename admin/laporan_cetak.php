<?php
include '../includes/koneksi.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

$query = mysqli_query($koneksi, "
    SELECT * FROM pengajuan
    WHERE 
        nama LIKE '%$keyword%' OR
        nik LIKE '%$keyword%' OR
        jenis_dokumen LIKE '%$keyword%' OR
        status LIKE '%$keyword%'
    ORDER BY tanggal_pengajuan DESC
");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengajuan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #000; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">

    <h2>Laporan Pengajuan Dokumen</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Jenis Dokumen</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nik']; ?></td>
            <td><?= $row['jenis_dokumen']; ?></td>
            <td><?= $row['tanggal_pengajuan']; ?></td>
            <td><?= $row['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
