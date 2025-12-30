<?php
session_start();

/* PROTEKSI HALAMAN USER */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

    $alertSuccess = "";
    if (isset($_SESSION['success'])) {
        $alertSuccess = $_SESSION['success'];
        unset($_SESSION['success']);
    }

    $nama = $_SESSION['user_nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home User | Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($alertSuccess): ?>
    <div class="alert-success"><?= $alertSuccess; ?></div>
<?php endif; ?>

<?php include '../includes/user/navbar.php'; ?>

<!-- HERO USER -->
<section class="hero">
    <h1>Selamat Datang, <?= $nama; ?></h1>
    <p>Silakan ajukan dan pantau dokumen kependudukan Anda secara online.</p>

    <div class="hero-btn">
        <a href="ajukan.php" class="btn-primary">Ajukan Dokumen</a>
        <a href="status.php" class="btn-secondary">Status Pengajuan</a>
    </div>
</section>

<main class="container">

    <!-- FITUR UTAMA -->
    <section class="layanan">
        <h2>Fitur Utama</h2>

        <div class="layanan-grid">

            <div class="card">
                <h3>Ajukan Dokumen</h3>
                <p>Ajukan KTP, KK, Akta Kelahiran, dan dokumen lainnya secara online.</p>
                <a href="ajukan.php" class="btn">Ajukan</a>
            </div>

            <div class="card">
                <h3>Status Pengajuan</h3>
                <p>Pantau status pengajuan dokumen Anda secara real-time.</p>
                <a href="status.php" class="btn">Cek Status</a>
            </div>

            <div class="card">
                <h3>Profil Saya</h3>
                <p>Lihat dan perbarui data profil akun Anda.</p>
                <a href="profil.php" class="btn">Profil</a>
            </div>

        </div>
    </section>

    <!-- INFO ALUR -->
    <section class="cara" style="width: 100%;">
        <h2>Alur Pengajuan Dokumen</h2>
        <ol>
            <li>Pilih layanan dokumen</li>
            <li>Lengkapi data dan unggah berkas</li>
            <li>Menunggu verifikasi admin</li>
            <li>Dokumen selesai & dapat diunduh</li>
        </ol>
    </section>

</main>

<?php include '../includes/user/footer.php'; ?>

</body>
</html>
