<?php
session_start();
include "../includes/koneksi.php";

$no = 1;

/* PROTEKSI ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

/* ALERT SUCCESS */
$alertSuccess = "";
if (isset($_SESSION['success'])) {
    $alertSuccess = $_SESSION['success'];
    unset($_SESSION['success']);
}

/* DATA ADMIN */
$nama = $_SESSION['user_nama'];

/* TOTAL PENGAJUAN */
$qTotal = mysqli_query($koneksi, "SELECT * FROM pengajuan");
$totalPengajuan = mysqli_num_rows($qTotal);  // Menggunakan mysqli_num_rows untuk menghitung jumlah pengajuan

/* TOTAL USER (ROLE USER) */
$qUser = mysqli_query($koneksi, "SELECT * FROM users WHERE role='user'");
$totalUser = mysqli_num_rows($qUser);  // Menggunakan mysqli_num_rows untuk menghitung jumlah pengguna dengan role 'user'

/* TOTAL PENGAJUAN SELESAI */
$qSelesai = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status='Selesai'");
$totalSelesai = mysqli_num_rows($qSelesai);  // Menggunakan mysqli_num_rows untuk menghitung jumlah pengajuan yang sudah selesai

/* RINGKASAN STATUS */
function hitungStatus($koneksi, $status)
{
    $q = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status='$status'");
    return mysqli_num_rows($q);  // Menggunakan mysqli_num_rows untuk menghitung jumlah pengajuan dengan status tertentu
}

$menunggu = hitungStatus($koneksi, 'Menunggu');
$diproses = hitungStatus($koneksi, 'Diproses');
$ditolak = hitungStatus($koneksi, 'Ditolak');
$selesai = hitungStatus($koneksi, 'Selesai');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="admin-wrapper">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if ($alertSuccess): ?>
            <div class="alert-success"><?= $alertSuccess; ?></div>
        <?php endif; ?>

        <?php include '../includes/admin/sidebar.php'; ?>

        <div class="admin-main">

            <?php include '../includes/admin/topbar.php'; ?>

            <div class="admin-content">
                <h2>Dashboard</h2>

                <div class="stat-grid">
                    <div class="stat-card">
                        <h3>Total Pengajuan</h3>
                        <p><?= $totalPengajuan; ?></p> <!-- Menampilkan jumlah total pengajuan -->
                    </div>

                    <div class="stat-card">
                        <h3>Pengguna Website</h3>
                        <p><?= $totalUser; ?></p> <!-- Menampilkan jumlah pengguna dengan role 'user' -->
                    </div>

                    <div class="stat-card">
                        <h3>Pengajuan Selesai</h3>
                        <p><?= $totalSelesai; ?></p> <!-- Menampilkan jumlah pengajuan yang sudah selesai -->
                    </div>
                </div>


                <div class="admin-section">
                    <h3>Ringkasan Status Pengajuan</h3>

                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status Pengajuan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><span class="status menunggu">Menunggu</span></td>
                                    <td><?= $menunggu; ?></td> <!-- Jumlah pengajuan dengan status 'Menunggu' -->
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><span class="status diproses">Diproses</span></td>
                                    <td><?= $diproses; ?></td> <!-- Jumlah pengajuan dengan status 'Diproses' -->
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><span class="status ditolak">Ditolak</span></td>
                                    <td><?= $ditolak; ?></td> <!-- Jumlah pengajuan dengan status 'Ditolak' -->
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><span class="status selesai">Selesai</span></td>
                                    <td><?= $selesai; ?></td> <!-- Jumlah pengajuan dengan status 'Selesai' -->
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>


            </div>
        </div>

    </div>

</body>

</html>