<?php
session_start();
include '../includes/koneksi.php';

/* PROTEKSI ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

/* VALIDASI ID */
if (!isset($_GET['id'])) {
    header("Location: pengajuan.php");
    exit;
}

$id = $_GET['id'];

/* QUERY DETAIL */
$query = mysqli_query($koneksi, "
        SELECT * FROM pengajuan WHERE id = '$id'
");

$data = mysqli_fetch_assoc($query);

$berkas = mysqli_query($koneksi, "
    SELECT * FROM berkas_pengajuan 
    WHERE id = '$id'
");


if (!$data) {
    $_SESSION['error'] = "Data pengajuan tidak ditemukan.";
    header("Location: pengajuan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan | Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">

    <?php include '../includes/admin/sidebar.php'; ?>

    <div class="admin-main">
        <?php include '../includes/admin/topbar.php'; ?>

        <div class="admin-content">

            <h2 style="margin-bottom: 10px;">Detail Pengajuan Dokumen</h2>

            <div class="detail-card">

                <table class="detail-table">
                    <tr>
                        <th>Nama Pemohon</th>
                        <td><?= $data['nama']; ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?= $data['nik']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $data['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Dokumen</th>
                        <td><?= $data['jenis_dokumen']; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td><?= date('d-m-Y', strtotime($data['tanggal_pengajuan'])); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="status <?= strtolower($data['status']); ?>">
                                <?= $data['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>
                            <?= $data['keterangan'] 
                                ? nl2br($data['keterangan'])
                                : '<em>Tidak ada keterangan</em>'; ?>
                        </td>
                    </tr>
                </table>

                <h3 style="margin-top:30px;">Berkas Persyaratan</h3>

                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Berkas</th>
                                <th>File</th>
                                <th>Tanggal Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($berkas) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($b = mysqli_fetch_assoc($berkas)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($b['nama_berkas']); ?></td>
                                <td>
                                    <a href="../uploads/<?= $b['file_path']; ?>" target="_blank">
                                        Lihat File
                                    </a>
                                </td>
                                <td><?= date('d-m-Y', strtotime($b['uploaded_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="empty-data">
                                    Belum ada berkas diupload
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="detail-action">
                    <a href="pengajuan.php" class="btn-back">← Kembali</a>
                </div>

            </div>

        </div>
    </div>

</div>

</body>
</html>
