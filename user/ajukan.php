<?php
session_start();
include '../includes/koneksi.php';

/* PROTEKSI USER */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$success = "";
$error = "";

$nama = $_SESSION['user_nama'];
$query_user = mysqli_query($koneksi,"SELECT * FROM users WHERE nama = '$nama'");
$user = mysqli_fetch_array($query_user);

if (isset($_POST['ajukan'])) {
    $email = $user['email'];
    $nik = $user['nik'];
    $jenis = $_POST['jenis_dokumen'];
    $tanggal = date('Y-m-d');
    $keterangan = $_POST['keterangan'];

    $insert = mysqli_query($koneksi, "
        INSERT INTO pengajuan (nama, email, nik, jenis_dokumen, tanggal_pengajuan, keterangan)
        VALUES ('$nama', '$email', '$nik', '$jenis', '$tanggal', '$keterangan')
    ");

    if ($insert) {
        $success = "Pengajuan berhasil dikirim.";
    } else {
        $error = "Gagal mengajukan dokumen.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Dokumen | Disdukcapil</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<?php include '../includes/user/navbar.php'; ?>

<main class="auth-container">
    <div class="auth-card">
        <h2>Ajukan Dokumen</h2>
        <p class="auth-subtitle">Isi form pengajuan dokumen</p>

        <?php if ($success): ?>
            <div class="alert success"><?= $success; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert error"><?= $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Jenis Dokumen</label>
                <select name="jenis_dokumen" required style="margin-bottom: 20px;">
                    <option value="">-- Pilih Dokumen --</option>
                    <option value="KTP Elektronik">KTP Elektronik</option>
                    <option value="Kartu Keluarga">Kartu Keluarga</option>
                    <option value="Akta Kelahiran">Akta Kelahiran</option>
                    <option value="Akta Kematian">Akta Kematian</option>
                </select>
                <div class="form-group">
                    <label>Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="4"
                        placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                </div>
                <input type="" value="<?= $user['nama']; ?>" hidden>
                <input type="" value="<?= $user['nik']; ?>" hidden>
                <input type="" value="<?= $user['email']; ?>" hidden>
            </div>

            <button type="submit" name="ajukan" class="btn-auth">
                Ajukan Dokumen
            </button>
        </form>
    </div>
</main>

<?php include '../includes/user/footer.php'; ?>

</body>
</html>
