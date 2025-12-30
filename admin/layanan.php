<?php
session_start();
include '../includes/koneksi.php';

/* PROTEKSI ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$success = "";
$error = "";

/* TAMBAH LAYANAN */
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_layanan'];
    $desk = $_POST['deskripsi'];

    if ($nama == "") {
        $error = "Nama layanan wajib diisi";
    } else {
        mysqli_query($koneksi, "
            INSERT INTO jenis_layanan (nama_layanan, deskripsi)
            VALUES ('$nama', '$desk')
        ");
        $success = "Jenis layanan berhasil ditambahkan";
    }
}

/* HAPUS */
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM jenis_layanan WHERE id='$id'");
    header("Location: layanan.php");
    exit;
}

/* DATA */
$data = mysqli_query($koneksi, "SELECT * FROM jenis_layanan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jenis Layanan | Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="admin-wrapper">

<?php include '../includes/admin/sidebar.php'; ?>

<div class="admin-main">
<header class="topbar">
    <span>Manajemen Jenis Layanan</span>
    <div class="admin-user">👤 <?= $_SESSION['user_nama']; ?></div>
</header>

<div class="admin-content layanan-wrapper">

    <h2 style="margin-bottom: 20px;">Jenis Layanan</h2>

    <?php if ($success): ?>
        <div class="alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-error"><?= $error; ?></div>
    <?php endif; ?>

    <!-- FORM TAMBAH -->
    <div class="layanan-card">
        <h3>Tambah Layanan</h3>

        <form method="post">
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3"></textarea>
            </div>

            <button type="submit" name="tambah" class="btn-save">
                Simpan
            </button>
        </form>
    </div>

    <!-- TABEL DATA -->
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($data) > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_layanan']); ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                    <td><?= date('d-m-Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="?hapus=<?= $row['id']; ?>"
                           onclick="return confirm('Hapus layanan ini?')"
                           class="btn-delete">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-data">
                        Belum ada jenis layanan
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
</div>

</body>
</html>
