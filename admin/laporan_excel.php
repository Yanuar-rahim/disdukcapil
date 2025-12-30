<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login dan memiliki role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Mengambil parameter keyword jika ada
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

// Menyusun header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pengajuan_" . date('Ymd_His') . ".xls");

// Menambahkan nama kolom untuk file Excel
echo "No\tNama\tNIK\tJenis Dokumen\tTanggal Pengajuan\tStatus\tKeterangan\n";

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
        // Outputkan setiap data ke dalam format Excel
        echo $no++ . "\t" .
             $row['nama'] . "\t" .
             $row['nik'] . "\t" .
             $row['jenis_dokumen'] . "\t" .
             date('d-m-Y', strtotime($row['tanggal_pengajuan'])) . "\t" .
             $row['status'] . "\t" .
             $row['keterangan'] . "\n";
    }
} else {
    // Jika tidak ada data
    echo "Tidak ada data pengajuan yang ditemukan.\n";
}
?>
