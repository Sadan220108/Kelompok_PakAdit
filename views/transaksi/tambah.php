<?php
$error = $_SESSION['error_msg'] ?? '';
unset($_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Tambah Transaksi</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?act=transaksi-tambahproses" method="POST">

        <div class="mb-3">
            <label class="form-label">Sparepart</label>
            <select name="id_sparepart" class="form-select" required>
                <option value="">-- Pilih Sparepart --</option>
                <?php if (!empty($data_sparepart)): ?>
                    <?php foreach ($data_sparepart as $s): ?>
                        <option value="<?= $s['id_sparepart'] ?>">
                            <?= htmlspecialchars($s['kode_barang']) ?> - <?= htmlspecialchars($s['nama_barang']) ?> (Stok: <?= htmlspecialchars($s['stok']) ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Transaksi</label>
            <select name="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="masuk">Barang Masuk</option>
                <option value="keluar">Barang Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Petugas</label>
            <input type="text" name="petugas" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php?act=transaksi" class="btn btn-secondary">Batal</a>

    </form>

</div>
</body>
</html>
