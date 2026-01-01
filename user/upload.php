<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: status.php");
    exit;
}

$pengajuan_id = $_GET['id'];    
$nama = $_SESSION['user_nama'];

$cek = mysqli_query($koneksi, "
    SELECT * FROM pengajuan 
    WHERE id='$pengajuan_id' AND nama='$nama'
");

if (mysqli_num_rows($cek) == 0) {
    header("Location: status.php");
    exit;
}

$success = "";
$error = "";

if (isset($_POST['upload'])) {

    $nama_berkas = $_POST['nama_berkas'];
    $file = $_FILES['file'];

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

    if (!in_array(strtolower($ext), $allowed)) {
        $error = "Format file tidak diperbolehkan!";
    } else {
        $nama_file = time() . "_" . $file['name'];
        $path = "../uploads/" . $nama_file;

        if (move_uploaded_file($file['tmp_name'], $path)) {

            mysqli_query($koneksi, "
                INSERT INTO berkas_pengajuan 
                (id, nama_berkas, file_path)
                VALUES 
                ('$pengajuan_id', '$nama_berkas', '$nama_file')
            ");

            $success = "Berkas berhasil diupload.";
        } else {
            $error = "Gagal upload file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Upload Dokumen</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body>

    <?php include '../includes/user/navbar.php'; ?>

    <div class="container upload-wrapper">
        <div class="upload-card">
            <h2>Upload Persyaratan Dokumen</h2>
            <p>Silakan unggah berkas sesuai dengan persyaratan dokumen.</p>

            <?php if ($success): ?>
                <div class="alert success"><?= $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert error"><?= $error; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nama Berkas</label>
                    <input type="text" name="nama_berkas" required>
                </div>

                <div class="form-group">
                    <label>Upload File</label>
                    <input type="file" name="file" required>
                    <small>Format yang diperbolehkan: PDF, JPG, PNG</small>
                </div>

                <button type="submit" name="upload" class="btn-upload">
                    Upload Dokumen
                </button>

            </form>
        </div>
    </div>

    <?php include '../includes/user/footer.php'; ?>
</body>

</html>