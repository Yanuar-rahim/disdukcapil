<?php
session_start();
include '../includes/koneksi.php';
require_once('../tcpdf/tcpdf.php');

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id='$id' AND nama = '$_SESSION[user_nama]'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $pdf = new TCPDF();

        $pdf->SetMargins(15, 30, 15);
        $pdf->SetFont('helvetica', '', 12);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Laporan Pengajuan Dokumen', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', '', 12);

        $pdf->Cell(0, 10, 'Nama Lengkap: ' . $data['nama'], 0, 1);
        $pdf->Cell(0, 10, 'NIK: ' . $data['nik'], 0, 1);
        $pdf->Cell(0, 10, 'Jenis Dokumen: ' . $data['jenis_dokumen'], 0, 1);
        $pdf->Cell(0, 10, 'Tanggal Pengajuan: ' . date('d-m-Y', strtotime($data['tanggal_pengajuan'])), 0, 1);
        $pdf->Cell(0, 10, 'Status Pengajuan: ' . $data['status'], 0, 1);
        $pdf->Ln(5);

        $pdf->Cell(0, 10, 'Keterangan: ' . $data['keterangan'], 0, 1);
        $pdf->Ln(10);

        if ($data) {
            $pdf->MultiCell(0, 10, 'Harap disimpan dengan baik. Dokumen ini yang nantinya menjadi bukti ketika ' . $data['jenis_dokumen'] . ' sudah jadi. Pastikan semua data sudah benar dan sesuai dengan informasi yang tertera pada formulir pengajuan.', 0, 1);
        } else {
            $pdf->Cell(0, 20, 'Data layanan tidak ditemukan.', 0, 1);
        }

        $pdf->Ln(10);

        $pdf->SetLineWidth(0.5);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Disdukcapil | Laporan Pengajuan', 0, 1, 'C');

        $file_name = 'Laporan_Pengajuan_' . $data['id'] . '.pdf';

        $pdf->Output($file_name, 'D');
        exit;
    } else {
        echo "Pengajuan tidak ditemukan.";
    }
} else {
    echo "ID pengajuan tidak ditemukan.";
}
?>