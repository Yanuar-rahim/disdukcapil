<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: status.php");
    exit;
}

$id = $_GET['id'];
$nama = $_SESSION['user_nama'];

$query = mysqli_query($koneksi, "
    SELECT * FROM pengajuan
    WHERE id = '$id' AND nama = '$nama'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: status.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan | Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body>

    <?php include '../includes/user/navbar.php'; ?>

    <div class="container" style="margin-top: 82px">
        <h2>Detail Pengajuan</h2>

        <div class="detail-card">

            <table class="detail-table">
                <tr>
                    <th>Jenis Dokumen</th>
                    <td><?= htmlspecialchars($data['jenis_dokumen']); ?></td>
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
                    <th>Catatan Admin</th>
                    <td>
                        <?= $data['catatan_admin']
                            ? nl2br(htmlspecialchars($data['catatan_admin']))
                            : '<em>Belum ada catatan</em>'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>
                        <?= $data['keterangan']
                            ? nl2br(htmlspecialchars($data['keterangan']))
                            : '<em>Tidak ada keterangan</em>'; ?>
                    </td>
                </tr>
            </table>

            <div class="detail-action">
                <a href="status.php" class="btn-back">← Kembali</a>
                <a href="cetak.php?id=<?= $data['id']; ?>" class="btn-sm">
                    Cetak Bukti
                </a>
            </div>

        </div>
    </div>

    <?php include '../includes/user/footer.php'; ?>

</body>

</html>