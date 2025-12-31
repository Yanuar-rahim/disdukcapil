<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login dan memiliki role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Mengambil parameter keyword jika ada
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

// Menyusun header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pengajuan_" . date('Ymd_His') . ".xls");

// Menambahkan deskripsi di atas tabel
echo "<h2 style='text-align: center; font-family: Arial, sans-serif;'>Laporan Pengajuan Dokumen</h2>";
echo "<p style='text-align: center; font-family: Arial, sans-serif; font-size: 14px;'>
        Laporan ini berisi daftar pengajuan dokumen yang telah dilakukan oleh pengguna. <br>
        Data ini mencakup informasi terkait nama, NIK, jenis dokumen, tanggal pengajuan, status, dan keterangan.<br>
        Laporan ini dihasilkan berdasarkan filter pencarian yang diberikan oleh admin.
      </p>";
echo "<br>";

// Menambahkan nama kolom untuk file Excel dengan format lebih profesional
echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; font-family: Arial, sans-serif;'>";
echo "<thead style='background-color: #4CAF50; color: white; font-weight: bold;'>";
echo "<tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>Jenis Dokumen</th>
        <th>Tanggal Pengajuan</th>
        <th>Status</th>
        <th>Keterangan</th>
      </tr>";
echo "</thead>";
echo "<tbody>";

// Menentukan query SQL berdasarkan keyword pencarian
if ($keyword != "") {
    $query = mysqli_query($koneksi, "
        SELECT * FROM pengajuan
        WHERE 
            nama LIKE '%$keyword%' OR
            nik LIKE '%$keyword%' OR
            jenis_dokumen LIKE '%$keyword%' OR
            status LIKE '%$keyword%'
        ORDER BY tanggal_pengajuan DESC
    ");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM pengajuan ORDER BY tanggal_pengajuan DESC");
}

// Mengecek apakah ada data yang ditemukan
if (mysqli_num_rows($query) > 0) {
    $no = 1;
    // Menampilkan data per baris
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        echo "<td style='text-align: center;'>$no</td>";
        echo "<td>{$row['nama']}</td>";
        echo "<td>{$row['nik']}</td>";
        echo "<td>{$row['jenis_dokumen']}</td>";
        echo "<td style='text-align: center;'>" . date('d-m-Y', strtotime($row['tanggal_pengajuan'])) . "</td>";
        echo "<td style='text-align: center;'>{$row['status']}</td>";
        echo "<td>{$row['keterangan']}</td>";
        echo "</tr>";
        $no++;
    }
} else {
    // Jika tidak ada data
    echo "<tr><td colspan='7' style='text-align: center;'>Tidak ada data pengajuan yang ditemukan.</td></tr>";
}

echo "</tbody>";
echo "</table>";
?>
