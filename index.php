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

<section class="hero">
    <h1>Layanan Pengajuan Dokumen Kependudukan Online</h1>
    <p>Ajukan KTP, KK, Akta, dan dokumen lainnya tanpa datang ke kantor.</p>
    <div class="hero-btn">
        <a href="login.php" class="btn-primary">Ajukan Sekarang</a>
        <a href="login.php" class="btn-secondary">Cek Status</a>
    </div>
    <span id="layanan"></span>
</section>


<main class="container">

    <!-- Section Layanan -->
    <section class="layanan">
        <h2>Layanan Kami</h2>
        <div class="layanan-grid">

            <div class="card">
                <h3>Pembuatan KTP</h3>
                <p>Pengajuan pembuatan dan perpanjangan KTP secara online.</p>
                <a href="login.php" class="btn">Ajukan</a>
            </div>

            <div class="card">
                <h3>Kartu Keluarga</h3>
                <p>Pengurusan KK baru, perubahan, dan pembaruan data.</p>
                <a href="login.php" class="btn">Ajukan</a>
            </div>

            <div class="card">
                <h3>Akta Kelahiran</h3>
                <p>Pengajuan akta kelahiran anak secara online.</p>
                <a href="login.php" class="btn">Ajukan</a>
            </div>

            <div class="card">
                <h3>Akta Kematian</h3>
                <p>Pelaporan dan penerbitan akta kematian.</p>
                <a href="login.php" class="btn">Ajukan</a>
            </div>

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
    
        <!-- Call To Action -->
        <div class="cta">
            <h2>Mulai Ajukan Dokumen Anda Sekarang</h2>
            <a href="register.php" class="btn-secondary cta-btn">Daftar Sekarang</a>
        </div>
    </section>

</main>

<?php include 'includes/user/footer.php'; ?>

</body>
</html>
