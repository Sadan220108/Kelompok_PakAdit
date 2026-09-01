<?php
$success = $_SESSION['success_msg'] ?? '';
$error   = $_SESSION['error_msg'] ?? '';
unset($_SESSION['success_msg'], $_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Data Sparepart</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="mb-3 d-flex justify-content-between">
        <a href="index.php?act=sparepart-tambah" class="btn btn-primary">+ Tambah Sparepart</a>
        <a href="index.php?act=sparepart-stokmenipis" class="btn btn-warning">Stok Menipis</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_sparepart)): ?>
                <?php $no = 1; foreach ($data_sparepart as $s): ?>
                    <tr <?= $s['stok'] <= 5 ? 'class="table-danger"' : '' ?>>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($s['kode_barang']) ?></td>
                        <td><?= htmlspecialchars($s['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($s['nama_kategori']) ?></td>
                        <td><?= htmlspecialchars($s['stok']) ?></td>
                        <td>
                            <a href="index.php?act=sparepart-edit&id=<?= $s['id_sparepart'] ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="index.php?act=transaksi-detail&id=<?= $s['id_sparepart'] ?>" class="btn btn-sm btn-secondary">Riwayat</a>
                            <a href="index.php?act=sparepart-hapus&id=<?= $s['id_sparepart'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin menonaktifkan sparepart ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data sparepart</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>