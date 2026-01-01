<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "User tidak ditemukan.";
    exit;
}

$err = "";
$scs = "";

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $update_query = "UPDATE users SET nama='$nama', nik='$nik', email='$email' WHERE id='$user_id'";
    if (mysqli_query($koneksi, $update_query)) {
        $_SESSION['user_nama'] = $nama;
        header("Location: profil.php");
        exit;
    } else {
        $err = "Gagal memperbarui profil.";
    }
}

if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $query_pass = mysqli_query($koneksi, "SELECT password FROM users WHERE id='$user_id'");
    $user_data = mysqli_fetch_assoc($query_pass);

    if (password_verify($current_password, $user_data['password'])) {
        if ($new_password === $confirm_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_pass_query = "UPDATE users SET password='$new_password_hash' WHERE id='$user_id'";
            if (mysqli_query($koneksi, $update_pass_query)) {
                $scs = "Password berhasil diperbarui!";
            } else {
                $err = "Gagal memperbarui password.";
            }
        } else {
            $err = "Password baru dan konfirmasi password tidak cocok.";
        }
    } else {
        $err = "Password lama salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
</head>

<body>

    <div class="admin-wrapper">

        <?php include '../includes/user/navbar.php'; ?>

        <div class="admin-main">
            <div class="admin-content profil-wrapper">
                <h2>Profil Saya</h2>

                <?php if ($err): ?>
                    <div class="alert error"><?= $err; ?></div>
                <?php endif; ?>

                <?php if ($scs): ?>
                    <div class="alert success"><?= $scs; ?></div>
                <?php endif; ?>

                <section class="card-profil">
                    <h3>Informasi Profil</h3>
                    <form method="post" action="profil.php">
                        <div class="input-field">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
                        </div>

                        <div class="input-field">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" value="<?= htmlspecialchars($user['nik']); ?>" required>
                        </div>

                        <div class="input-field">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <button type="submit" name="update" class="btn-primary">Perbarui Profil</button>
                    </form>
                </section>

                <section class="card-profil">
                    <h3>Ganti Password</h3>
                    <form method="post">
                        <div class="input-field">
                            <label for="current_password">Password Lama</label>
                            <input type="password" name="current_password" required>
                        </div>

                        <div class="input-field">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" required>
                        </div>

                        <div class="input-field">
                            <label for="confirm_password">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" required>
                        </div>

                        <button type="submit" name="change_password" class="btn-primary">Ganti Password</button>
                    </form>
                </section>
            </div>
        </div>

        <?php include '../includes/user/footer.php'; ?>

    </div>

</body>

</html>