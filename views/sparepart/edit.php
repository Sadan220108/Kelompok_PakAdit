<?php
$error = $_SESSION['error_msg'] ?? '';
unset($_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Edit Sparepart</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?act=sparepart-editproses" method="POST">

        <input type="hidden" name="id_sparepart" value="<?= $sparepart['id_sparepart'] ?>">

        <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control"
                   value="<?= htmlspecialchars($sparepart['kode_barang']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control"
                   value="<?= htmlspecialchars($sparepart['nama_barang']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php if (!empty($data_kategori)): ?>
                    <?php foreach ($data_kategori as $k): ?>
                        <option value="<?= $k['id_kategori'] ?>"
                            <?= $k['id_kategori'] == $sparepart['id_kategori'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok Saat Ini</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($sparepart['stok']) ?>" disabled>
            <div class="form-text">Stok tidak bisa diubah di sini, gunakan menu Transaksi untuk mengubah stok.</div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?act=sparepart" class="btn btn-secondary">Batal</a>

    </form>

</div>
</body>
</html>