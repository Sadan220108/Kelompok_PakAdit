<?php
$success = $_SESSION['success_msg'] ?? '';
$error   = $_SESSION['error_msg'] ?? '';
unset($_SESSION['success_msg'], $_SESSION['error_msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kategori Sparepart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; }
        h1 { color: #333; }
        .alert {
            padding: 10px 14px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 15px;
            background: #2e7d32;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th { background: #333; color: #fff; }
        tr:hover { background: #f1f1f1; }
        .aksi a {
            margin-right: 8px;
            text-decoration: none;
        }
        .edit { color: #1565c0; }
        .hapus { color: #c62828; }
    </style>
</head>
<body>

    <h1>Data Kategori Sparepart</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <a class="btn" href="index.php?act=kategori-tambah">+ Tambah Kategori</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_kategori)): ?>
                <?php $no = 1; ?>
                <?php foreach ($data_kategori as $kategori): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($kategori['nama_kategori']) ?></td>
                        <td class="aksi">
                            <a class="edit" href="index.php?act=kategori-edit&id=<?= $kategori['id_kategori'] ?>">Edit</a>
                            <a class="hapus" href="index.php?act=kategori-hapus&id=<?= $kategori['id_kategori'] ?>"
                               onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada data kategori</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>