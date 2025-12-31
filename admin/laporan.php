<?php
session_start();
include '../includes/koneksi.php';

/* PROTEKSI ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$nama = $_SESSION['user_nama'];

/* FILTER */
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

$query = mysqli_query($koneksi, "
    SELECT * FROM pengajuan
    WHERE 
        nama LIKE '%$keyword%' OR
        nik LIKE '%$keyword%' OR
        jenis_dokumen LIKE '%$keyword%' OR
        status LIKE '%$keyword%'
    ORDER BY tanggal_pengajuan DESC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan | Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="admin-wrapper">

        <?php include '../includes/admin/sidebar.php'; ?>

        <div class="admin-main">
            <header class="topbar">
                <span>Laporan Pengajuan Dokumen</span>
                <div class="admin-user">👤 <?= $_SESSION['user_nama']; ?></div>
            </header>

            <div class="admin-content laporan-wrapper">

                <h2 style="margin-bottom: 10px;">Laporan Pengajuan</h2>

                <!-- FILTER & ACTION -->
                <div class="laporan-action">
                    <form method="get" class="search-box">
                        <input type="text" name="keyword" placeholder="Cari nama, NIK, layanan, status"
                            value="<?= htmlspecialchars($keyword); ?>">
                        <button type="submit">Cari</button>
                    </form>

                    <div class="export-btn">
                        <a href="laporan_excel.php?keyword=<?= $keyword; ?>" class="btn-excel">Excel</a>
                        <a href="laporan_cetak.php?keyword=<?= $keyword; ?>" target="_blank" class="btn-pdf">PDF</a>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Dokumen</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) > 0): ?>
                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['nama']); ?></td>
                                        <td><?= htmlspecialchars($row['nik']); ?></td>
                                        <td><?= htmlspecialchars($row['jenis_dokumen']); ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                                        <td>
                                            <span class="status <?= strtolower($row['status']); ?>">
                                                <?= $row['status']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="empty-data">Data tidak ditemukan</td>
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