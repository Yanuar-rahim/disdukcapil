<?php
session_start();
include 'includes/koneksi.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $nama  = $_POST['nama'];
    $nik   = $_POST['nik'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $konfirmasi  = $_POST['konfir-password'];

    // CEK KONFIRMASI PASSWORD
    if ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak sesuai!";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // CEK DUPLIKAT
        $cek = mysqli_query($koneksi, "
            SELECT * FROM users 
            WHERE nik='$nik' OR email='$email'
        ");

        if (mysqli_num_rows($cek) > 0) {
            $error = "NIK atau Email sudah terdaftar!";
        } else {
            mysqli_query($koneksi, "
                INSERT INTO users (nama, nik, email, password, role)
                VALUES ('$nama', '$nik', '$email', '$password_hash', 'user')
            ");

            $success = "Registrasi berhasil! <a href='login.php'>Silahkan login.</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar | Disdukcapil</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<?php include 'includes/user/navbar.php'; ?>

<main class="auth-container">
    <div class="auth-card">
        <h2>Daftar Akun</h2>
        <p class="auth-subtitle">Buat akun baru</p>

        <?php if ($error): ?>
            <div class="alert error"><?= $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" placeholder="Masukkan NIK" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Buat Password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfir-password" placeholder="Masukan ulang Password" required>
            </div>

            <button type="submit" class="btn-auth" name="register">Daftar</button>
        </form>

        <p class="auth-link">
            Sudah punya akun?
            <a href="login.php">Login</a>
        </p>
    </div>
</main>

<?php include 'includes/user/footer.php'; ?>

</body>
</html>
