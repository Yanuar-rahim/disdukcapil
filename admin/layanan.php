<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

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
        $_SESSION['success'] = "Jenis layanan berhasil ditambahkan";
    }
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM jenis_layanan WHERE id='$id'");
    $row = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama_layanan'];
    $desk = $_POST['deskripsi'];
    $id = $_POST['id'];

    if ($nama == "") {
        $error = "Nama layanan wajib diisi";
    } else {
        mysqli_query($koneksi, "
            UPDATE jenis_layanan SET nama_layanan='$nama', deskripsi='$desk' WHERE id='$id'
        ");
        $_SESSION['success'] = "Jenis layanan berhasil ditambahkan";

        header("Location: layanan.php");
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM jenis_layanan WHERE id='$id'");
    $_SESSION["success"] = "Jenis layanan berhasil dihapus";
    header("Location: layanan.php");
    exit;
}

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

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert-success"><?= $_SESSION['success']; ?></div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert-error"><?= $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>


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

                <?php if (isset($_GET['edit'])): ?>
                    <div class="layanan-card">
                        <h3>Edit Layanan</h3>

                        <form method="post">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">

                            <div class="form-group">
                                <label>Nama Layanan</label>
                                <input type="text" name="nama_layanan" value="<?= $row['nama_layanan']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" rows="3" required><?= $row['deskripsi']; ?></textarea>
                            </div>

                            <button type="submit" name="update" class="btn-save">
                                Update Layanan
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

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
                                        <td style="text-align: left;"><?= $row['nama_layanan']; ?></td>
                                        <td style="text-align: left;"><?= substr($row['deskripsi'], 0, 40); ?>...</td>
                                        <td><?= date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <a href="?edit=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                                            <a href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus layanan ini?')"
                                                class="btn-delete">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-data">Belum ada jenis layanan</td>
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