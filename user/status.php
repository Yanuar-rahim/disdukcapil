<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$nama = $_SESSION['user_nama'];

$query = mysqli_query($koneksi, "
    SELECT * FROM pengajuan
    WHERE nama = '$nama'
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pengajuan | Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body>

    <?php include '../includes/user/navbar.php'; ?>

    <div class="container" style="margin-top: 80px;">
        <h2>Status Pengajuan Dokumen</h2>

        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
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
                                <td><?= $row['jenis_dokumen']; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                                <td>
                                    <span class="status <?= strtolower($row['status']); ?>">
                                        <?= $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail.php?id=<?= $row['id']; ?>" class="btn-sm">
                                        Detail
                                    </a>
                                    <a href="upload.php?id=<?= $row['id']; ?>" class="btn-sm" style="background: limegreen;">
                                        Upload
                                    </a>

                                    <?php if ($row['status'] == 'Selesai'): ?>
                                        <a href="download.php?id=<?= $row['id']; ?>" class="btn-sm" style="background-color: navy;">
                                            Download
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-data">
                                Belum ada pengajuan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/user/footer.php'; ?>

</body>

</html>