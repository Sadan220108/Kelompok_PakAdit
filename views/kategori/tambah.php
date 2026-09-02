<?php
$error = $_SESSION['error_msg'] ?? '';
unset($_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Tambah Kategori</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="index.php?act=kategori-tambahproses" method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php?act=kategori" class="btn btn-secondary">Batal</a>

    </form>

</div>
</body>
</html>