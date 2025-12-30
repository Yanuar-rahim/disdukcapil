<?php
session_start();

$no = 1;

/* PROTEKSI ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
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
                    <p>120</p>
                </div>

                <div class="stat-card">
                    <h3>Pengajuan Hari Ini</h3>
                    <p>8</p>
                </div>

                <div class="stat-card">
                    <h3>Pengajuan Selesai</h3>
                    <p>95</p>
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
                            <td>Menunggu</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Diproses</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Ditolak</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Selesai</td>
                            <td>90</td>
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
