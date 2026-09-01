<?php
$success = $_SESSION['success_msg'] ?? '';
$error   = $_SESSION['error_msg'] ?? '';
unset($_SESSION['success_msg'], $_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Riwayat Transaksi</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="index.php?act=transaksi-tambah" class="btn btn-primary">+ Tambah Transaksi</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
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
                        <td><?= htmlspecialchars($t['kode_barang']) ?></td>
                        <td><?= htmlspecialchars($t['nama_barang']) ?></td>
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
                    <td colspan="8" class="text-center">Belum ada data transaksi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>