<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Riwayat Transaksi Sparepart</h3>

    <div class="mb-3">
        <a href="index.php?act=sparepart" class="btn btn-secondary">&laquo; Kembali ke Data Sparepart</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_transaksi)): ?>
                <?php $no = 1; foreach ($data_transaksi as $t): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($t['tanggal']) ?></td>
                        <td>
                            <?php if ($t['jenis'] === 'masuk'): ?>
                                <span class="badge bg-success">Masuk</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Keluar</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($t['jumlah']) ?></td>
                        <td><?= htmlspecialchars($t['keterangan'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['petugas']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada riwayat transaksi untuk sparepart ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
