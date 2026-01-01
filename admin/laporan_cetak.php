<?php
session_start();
include "../includes/koneksi.php";

$no = 1;

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

// Styling untuk tampilan laporan
echo '<style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 40px;
                background-color: #f9f9f9;
            }

            .container {
                padding: 20px 30px;
                margin-top: 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                // width: 80%;
                margin: 0 auto;
            }

            h1 {
                text-align: center;
                color: #333;
                font-size: 24px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 14px;
            }

            table th, table td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }

            table th {
                background-color: #4CAF50;
                color: white;
                text-align: center;
            }

            table td {
                background-color: #fff;
            }

            table tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #777;
                margin-top: 40px;
            }

        </style>';

echo '<div class="container">';

// Judul Laporan
echo '<h1>Laporan Pengajuan Dokumen Disdukcapil</h1>';
echo '<table>';
echo '<thead>';
echo '<tr><th>No</th><th>Nama</th><th>NIK</th><th>Jenis Dokumen</th><th>Tanggal Pengajuan</th><th>Status</th></tr>';
echo '</thead><tbody>';

// Query untuk mengambil data pengajuan dari database
$query_pengajuan = mysqli_query($koneksi, "SELECT * FROM pengajuan ORDER BY tanggal_pengajuan DESC");
while ($row = mysqli_fetch_assoc($query_pengajuan)) {
    echo '<tr>';
    echo '<td style="text-align: center;">' . $no++ . '</td>';
    echo '<td>' . $row['nama'] . '</td>';
    echo '<td style="text-align: center;">' . $row['nik'] . '</td>';
    echo '<td style="text-align: center;">' . $row['jenis_dokumen'] . '</td>';
    echo '<td style="text-align: center;">' . date('d-m-Y', strtotime($row['tanggal_pengajuan'])) . '</td>';
    echo '<td style="text-align: center;">' . $row['status'] . '</td>';
    echo '</tr>';
}

echo '</tbody></table>';

// Footer Laporan
echo '<div class="footer"><p>&copy;2025 Disdukcapil. All rights reserved.</p></div>';

// Fungsi untuk mencetak laporan
echo '<script>window.print();</script>';
echo '</div>';
exit();
?>