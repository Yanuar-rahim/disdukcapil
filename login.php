<?php
session_start();
include 'includes/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "
        SELECT * FROM users 
        WHERE email='$username' OR nik='$username'
        LIMIT 1
    ");

    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

            // SESSION LOGIN
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['success'] = "Berhasil login! Selamat datang, " . $user['nama'] . ".";

            // REDIRECT BERDASARKAN ROLE
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/index.php");
            }
            exit;

        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Disdukcapil</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<?php include 'includes/user/navbar.php'; ?>

<main class="auth-container">
    <div class="auth-card">
        <h2>Login</h2>
        <p class="auth-subtitle">Masuk ke sistem</p>

        <?php if ($error): ?>
            <div class="alert error"><?= $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Email / NIK</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login" class="btn-auth">Login</button>
        </form>

        <p class="auth-link">
            Belum punya akun?
            <a href="register.php">Daftar sekarang</a>
        </p>
    </div>
</main>

<?php include 'includes/user/footer.php'; ?>

</body>
</html>
