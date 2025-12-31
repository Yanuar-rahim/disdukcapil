<?php
session_start();
include '../includes/koneksi.php';
require_once('../tcpdf/tcpdf.php');  // Pastikan path TCPDF sudah benar

/* PROTEKSI USER */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pengajuan berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id='$id' AND nama = '$_SESSION[user_nama]'");
    $data = mysqli_fetch_assoc($query);

    // Pastikan data pengajuan ditemukan
    if ($data) {
        // Inisialisasi TCPDF
        $pdf = new TCPDF();
        
        // Set margin dan font
        $pdf->SetMargins(15, 30, 15);  // Kiri, Atas, Kanan
        $pdf->SetFont('helvetica', '', 12);  // Set font standar

        // Tambahkan halaman
        $pdf->AddPage();

        // Header
        $pdf->SetFont('helvetica', 'B', 16);  // Font tebal untuk judul
        $pdf->Cell(0, 10, 'Laporan Pengajuan Dokumen', 0, 1, 'C');
        $pdf->Ln(5);  // Jarak

        // Set font untuk konten
        $pdf->SetFont('helvetica', '', 12);

        // Informasi Pengajuan
        $pdf->Cell(0, 10, 'Nama Lengkap: ' . $data['nama'], 0, 1);
        $pdf->Cell(0, 10, 'NIK: ' . $data['nik'], 0, 1);
        $pdf->Cell(0, 10, 'Jenis Dokumen: ' . $data['jenis_dokumen'], 0, 1);
        $pdf->Cell(0, 10, 'Tanggal Pengajuan: ' . date('d-m-Y', strtotime($data['tanggal_pengajuan'])), 0, 1);
        $pdf->Cell(0, 10, 'Status Pengajuan: ' . $data['status'], 0, 1);
        $pdf->Ln(5); // Jarak

        // Keterangan Dokumen
        $pdf->Cell(0, 10, 'Keterangan: ' . $data['keterangan'], 0, 1);
        $pdf->Ln(10); // Jarak

        // Memeriksa apakah data layanan ditemukan
        if ($data) {
            $pdf->MultiCell(0, 10, 'Harap disimpan dengan baik. Dokumen ini yang nantinya menjadi bukti ketika ' . $data['jenis_dokumen'] . ' sudah jadi. Pastikan semua data sudah benar dan sesuai dengan informasi yang tertera pada formulir pengajuan.', 0, 1);
        } else {
            // Jika data layanan tidak ditemukan
            $pdf->Cell(0, 20, 'Data layanan tidak ditemukan.', 0, 1);
        }

        // Tambahkan jarak (margin bawah) setelah teks
        $pdf->Ln(10);  // Menambahkan jarak 10mm setelah pesan

        // Add a line for section separation
        $pdf->SetLineWidth(0.5);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());  // Draw horizontal line
        $pdf->Ln(5);  // Jarak

        // Footer informasi
        $pdf->SetFont('helvetica', 'I', 8);  // Italic for footer
        $pdf->Cell(0, 10, 'Disdukcapil | Laporan Pengajuan', 0, 1, 'C');

        // Tentukan nama file dan output ke browser untuk langsung mendownload
        $file_name = 'Laporan_Pengajuan_' . $data['id'] . '.pdf';

        // Output PDF langsung ke browser dan memaksa download
        $pdf->Output($file_name, 'D');  // 'D' untuk download langsung
        exit;
    } else {
        echo "Pengajuan tidak ditemukan.";
    }
} else {
    echo "ID pengajuan tidak ditemukan.";
}
?>
