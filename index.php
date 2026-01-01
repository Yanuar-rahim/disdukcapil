<?php
include 'includes/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM jenis_layanan")
    ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Disdukcapil | Layanan Dokumen Kependudukan</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    <span id="home">
        <?php include 'includes/user/navbar.php'; ?>
    </span>

    <section class="hero" style="margin-top: 82px;">
        <h1>Layanan Pengajuan Dokumen Kependudukan Online</h1>
        <p>Ajukan KTP, KK, Akta, dan dokumen lainnya tanpa datang ke kantor.</p>
        <div class="hero-btn">
            <a href="login.php" class="btn-primary">Ajukan Sekarang</a>
            <a href="login.php" class="btn-secondary">Cek Status</a>
        </div>
        <span id="layanan"></span>
    </section>


    <div class="container">

        <section class="layanan">
            <h2>Layanan Kami</h2>
            <div class="layanan-grid">
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <div class="card">
                            <h3><?= $row['nama_layanan']; ?></h3>
                            <p><?= $row['deskripsi']; ?></p>
                            <a href="login.php" class="btn">Ajukan</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-data">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </div>
        </section>
        <section class="cara-cta" id="cara">
            <div class="cara">
                <h2>Cara Pengajuan</h2>
                <ol>
                    <li>Registrasi akun</li>
                    <li>Login ke sistem</li>
                    <li>Pilih layanan dokumen</li>
                    <li>Upload berkas persyaratan</li>
                    <li>Menunggu proses verifikasi</li>
                    <li>Dokumen selesai</li>
                </ol>
            </div>

            <div class="cta">
                <h2>Mulai Ajukan Dokumen Anda Sekarang</h2>
                <a href="register.php" class="btn-secondary cta-btn">Daftar Sekarang</a>
            </div>
        </section>

    </div>

    <?php include 'includes/user/footer.php'; ?>

</body>

</html>