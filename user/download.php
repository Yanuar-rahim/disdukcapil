<?php
session_start();
include "../includes/koneksi.php";

// Pastikan user sudah login dan memiliki role user
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID pengajuan
    $query = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Styling untuk tampilan laporan menggunakan layout card
        echo '<style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 0;
                    background-color: #f9f9f9;
                }

                .container {
                    padding: 20px 30px;
                    margin-top: 20px;
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    width: 80%;
                    margin: 0 auto;
                }

                h1 {
                    text-align: center;
                    color: #333;
                    font-size: 24px;
                    margin-bottom: 20px;
                    font-weight: bold;
                }

                .card {
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                    padding: 20px;
                }

                .card-header {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                    margin-bottom: 15px;
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px;
                    border-radius: 5px;
                }

                .card-body {
                    font-size: 14px;
                    line-height: 1.6;
                    color: #333;
                    margin-bottom: 20px;
                }

                .card-body table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 14px;
                }

                .card-body th, .card-body td {
                    padding: 10px;
                    text-align: left;
                    border: 1px solid #ddd;
                }

                .card-body th {
                    background-color: #4CAF50;
                    color: white;
                    text-align: center;
                }

                .card-body td {
                    background-color: #fff;
                    text-align: center;
                }

                .card-body table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                .row {
                    display: flex;
                    align-items: center;
                }

                .row p {
                    width: 200px;
                }

                .btn-auth {
                    width: 100%;
                    padding: 12px;
                    background: linear-gradient(135deg, #2563eb, #1e40af);
                    color: #fff;
                    border: none;
                    border-radius: 6px;
                    font-weight: bold;
                    cursor: pointer;
                    margin-top: 10px;
                }

                .btn-auth:hover {
                    opacity: 0.9;
                }

                @media print {
                    .btn-auth {
                        display: none;
                    }
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

        // Card untuk Data Pengajuan
        echo '<div class="card">
        <div class="card-header">Informasi Pengajuan</div>
        <div class="card-body">
            <div class="row">
                <p><strong>Nama</strong></p>
                <span>' . $data['nama'] . '</span>
            </div>
            <div class="row">
                <p><strong>NIK</strong></p>
                <span>' . $data['nik'] . '</span>
            </div>
            <div class="row">
                <p><strong>Jenis Dokumen</strong></p>
                <span>' . $data['jenis_dokumen'] . '</span>
            </div>
            <div class="row">
                <p><strong>Tanggal Pengajuan</strong></p>
                <span>' . date('d-m-Y', strtotime($data['tanggal_pengajuan'])) . '</span>
            </div>
            <div class="row">
                <p><strong>Status Pengajuan</strong></p>
                <span>' . $data['status'] . '</span>
            </div>
            <div class="row">
                <p><strong>Keterangan</strong></p>
                <span>' . $data['keterangan'] . '</span>
            </div>
            <div class="row" style="align-items: baseline;">
                <p><strong>Pesan</strong></p>
                <span style="width: 50%;">Harap disimpan dengan baik, Dokumen ini yang nantinya menjadi bukti ketika ' . $data['jenis_dokumen'] . ' sudah jadi. Pastikan semua data sudah benar dan sesuai dengan informasi yang tertera pada formulir pengajuan.</span>
            </div>
        </div>
    </div>';

        // Card untuk Tabel Laporan
        echo '<div class="card">
                <div class="card-header">Detail Pengajuan</div>
                <div class="card-body">
                    <table>
                        <thead>
                            <tr><th>No</th><th>Nama</th><th>NIK</th><th>Jenis Dokumen</th><th>Tanggal Pengajuan</th><th>Status</th></tr>
                        </thead>
                        <tbody>';

        // Menampilkan data pengajuan berdasarkan ID
        echo '<tr>';
        echo '<td>1</td>';
        echo '<td style="text-align: left;"><span>' . $data['nama'] . '</span></td>';
        echo '<td><span>' . $data['nik'] . '</span></td>';
        echo '<td><span>' . $data['jenis_dokumen'] . '</span></td>';
        echo '<td><span>' . date('d-m-Y', strtotime($data['tanggal_pengajuan'])) . '</span></td>';
        echo '<td><span>' . $data['status'] . '</span></td>';
        echo '</tr>';

        echo '</tbody></table>';
        echo '</div>';
        echo '</div>';

        // Button untuk mencetak dan kembali
        echo '<div style="text-align: center; margin-top: 20px; display: flex; justify-content: center; width: 30%; gap: 10px;">
                <button onclick="window.print()" class="btn-auth">Cetak Laporan</button>
                <button onclick="window.history.back()" class="btn-auth">Kembali</button>
              </div>';

        // Footer Laporan
        echo '<div class="footer"><p>&copy;2025 Disdukcapil. All rights reserved.</p></div>';

        echo '</div>';
    } else {
        echo "Pengajuan tidak ditemukan.";
    }
} else {
    echo "ID pengajuan tidak ditemukan.";
}
?>
