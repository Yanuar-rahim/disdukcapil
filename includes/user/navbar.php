<?php
$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;
?>

<header>
    <h1>Disdukcapil</h1>

    <nav>
        <?php if (!$isLogin): ?>
            <div class="nav-link">
                <a href="index.php#home">Home</a>
                <a href="index.php#layanan">Layanan</a>
                <a href="index.php#cara">Cara Pengajuan</a>
                <a href="login.php">Cek Status</a>
            </div>
            <div class="auth-btn">
                <a href="login.php" class="login">Login</a>
                <a href="register.php" class="regis">Daftar</a>
            </div>

        <?php else: ?>
            <div class="nav-link">
                <a href="index.php">Home</a>
                <a href="ajukan.php">Ajukan Dokumen</a>
                <a href="status.php">Status Pengajuan</a>
                <a href="profil.php">Profil</a>
            </div>
            <div class="auth-btn">
                <a href="../logout.php" class="login">Logout</a>
            </div>
        <?php endif; ?>
    </nav>
</header>