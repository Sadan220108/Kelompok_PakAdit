<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sparepart Stok Menipis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Sparepart dengan Stok Menipis</h3>

    <div class="mb-3">
        <a href="index.php?act=sparepart" class="btn btn-secondary">&laquo; Kembali ke Data Sparepart</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_sparepart)): ?>
                <?php $no = 1; foreach ($data_sparepart as $s): ?>
                    <tr class="table-danger">
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($s['kode_barang']) ?></td>
                        <td><?= htmlspecialchars($s['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($s['stok']) ?></td>
                        <td>
                            <a href="index.php?act=transaksi-tambah" class="btn btn-sm btn-primary">Tambah Stok</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada sparepart dengan stok menipis</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
