<?php
include '../includes/koneksi.php';  // Pastikan koneksi database mysqli

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Query untuk mencari data pengajuan tanpa prepared statement
$sql = "SELECT * FROM pengajuan 
        WHERE 
            nama LIKE '%$keyword%' OR
            nik LIKE '%$keyword%' OR
            jenis_dokumen LIKE '%$keyword%' OR
            status LIKE '%$keyword%'
        ORDER BY tanggal_pengajuan DESC";

$query = mysqli_query($koneksi, $sql);

// Inisialisasi TCPDF
require_once('../tcpdf/tcpdf.php');  // Pastikan path ke TCPDF benar
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set margin
$pdf->SetMargins(15, 25, 15);  // Kiri, Atas, Kanan
$pdf->SetAutoPageBreak(TRUE, 15);  // Jarak otomatis di halaman bawah
$pdf->SetFont('helvetica', '', 12); // Set font standar

// Menambahkan halaman
$pdf->AddPage();

// HEADER
$pdf->SetFont('helvetica', 'B', 16);  // Bold untuk judul
$pdf->Cell(0, 10, 'Laporan Pengajuan Dokumen', 0, 1, 'C');
$pdf->Ln(5);

// Menambahkan garis horizontal
$pdf->SetLineWidth(0.5);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());  // Gambar garis horizontal
$pdf->Ln(8);  // Menambah jarak setelah garis

// Tabel Header dengan warna latar belakang
$pdf->SetFillColor(33, 150, 243);  // Warna biru untuk header tabel
$pdf->SetFont('helvetica', 'B', 12);  // Bold untuk header tabel
$pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Nama', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'NIK', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Jenis Dokumen', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Tanggal Pengajuan', 1, 0, 'C', 1);
$pdf->Cell(20, 10, 'Status', 1, 1, 'C', 1);

// Isi tabel dengan data dari database
$pdf->SetFont('helvetica', '', 12);  // Font standar untuk isi tabel
$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(45, 10, $row['nama'], 1, 0, 'L');
    $pdf->Cell(30, 10, $row['nik'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['jenis_dokumen'], 1, 0, 'C');
    $pdf->Cell(45, 10, $row['tanggal_pengajuan'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['status'], 1, 1, 'C');
}

// Footer
$pdf->SetY(270);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->Cell(0, 10, 'Disdukcapil | Laporan Pengajuan', 0, 0, 'C');

// Output PDF
$pdf->Output('Laporan_Pengajuan.pdf', 'I');  // 'I' untuk menampilkan di browser
exit;
?>
