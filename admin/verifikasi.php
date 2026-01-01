<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT * FROM pengajuan WHERE id='$id'"
));

if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $catatan = $_POST['catatan'];

    mysqli_query($koneksi, "
        UPDATE pengajuan 
        SET status='$status', catatan_admin='$catatan'
        WHERE id='$id'
    ");

    $_SESSION['success'] = "Status pengajuan berhasil diperbarui";
    header("Location: pengajuan.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Verifikasi Pengajuan</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="admin-wrapper">
        <?php include '../includes/admin/sidebar.php'; ?>

        <div class="admin-main">
            <header class="topbar">
                <span>Verifikasi Pengajuan</span>
                <div class="admin-user">
                    👤 <?= $_SESSION['user_nama']; ?>
                </div>
            </header>
            

            <div class="admin-content">
                <div class="admin-content verify-wrapper">
                    <div class="verify-card">
                        <h3>Verifikasi Pengajuan Dokumen</h3>

                        <form method="post">

                            <div class="form-group">
                                <label>Status Pengajuan</label>
                                <select name="status" required>
                                    <option <?= $data['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                    <option <?= $data['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                    <option <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                    <option <?= $data['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Catatan Admin</label>
                                <textarea name="catatan" rows="4"
                                    placeholder="Tambahkan catatan atau alasan penolakan..."><?= $data['catatan_admin']; ?></textarea>
                            </div>

                            <div class="verify-action">
                                <a href="pengajuan.php" class="btn-cancel">← Kembali</a>
                                <button type="submit" name="update" class="btn-save">
                                    Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>