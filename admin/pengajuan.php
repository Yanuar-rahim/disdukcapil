<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM pengajuan ORDER BY id DESC ");

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengajuan | Admin Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="admin-wrapper">

        <?php include '../includes/admin/sidebar.php'; ?>

        <div class="admin-main">

            <header class="topbar">
                <span>Data Pengajuan</span>
                <div class="admin-user">
                    👤 <?= $_SESSION['user_nama']; ?>
                </div>
            </header>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-error"><?= $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert-success"><?= $_SESSION['success']; ?></div>
            <?php endif; ?>

            <div class="admin-content">
                <h2>Data Pengajuan</h2>

                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemohon</th>
                                <th>NIK</th>
                                <th>Jenis Dokumen</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['nik']; ?></td>
                                        <td><?= $row['jenis_dokumen']; ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                                        <td>
                                            <span class="status <?= strtolower($row['status']); ?>">
                                                <?= $row['status']; ?>
                                            </span>
                                        </td>
                                        <td style="display: flex; gap: 10px;">
                                            <a href="detail_pengajuan.php?id=<?= $row['id']; ?>" class="btn-sm btn-view">
                                                Detail
                                            </a>
                                            <a href="verifikasi.php?id=<?= $row['id']; ?>" class="btn-sm btn-verifikasi">
                                                Verifikasi
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-data">
                                        Belum ada pengajuan
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>

</html>