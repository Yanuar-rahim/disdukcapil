<?php
session_start();

/*
    Session dianggap login jika:
    $_SESSION['user_login'] bernilai true
*/
$isLogin = isset($_SESSION['user_login']) && $_SESSION['user_login'] === true;
?>

<header>
    <h1>Disdukcapil</h1>

    <nav>
        <?php if (!$isLogin): ?>
            <!-- NAVBAR PUBLIK (SEBELUM LOGIN) -->
            <a href="/index.php">Home</a>
            <a href="/user/layanan.php">Layanan</a>
            <a href="/user/cara-pengajuan.php">Cara Pengajuan</a>
            <a href="/login.php">Cek Status</a>
            <a href="/login.php">Login / Daftar</a>

        <?php else: ?>
            <!-- NAVBAR USER (SETELAH LOGIN) -->
            <a href="/user/home.php">Home</a>
            <a href="/user/ajukan.php">Ajukan Dokumen</a>
            <a href="/user/status.php">Status Pengajuan</a>
            <a href="/user/profil.php">Profil</a>
            <a href="/logout.php">Logout</a>
        <?php endif; ?>
    </nav>
</header>
