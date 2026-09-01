<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kategori Sparepart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; }
        h1 { color: #333; }
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

    <a class="btn" href="index.php?controller=kategori&action=create">+ Tambah Kategori</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kategoris)): ?>
                <?php $no = 1; ?>
                <?php foreach ($kategoris as $kategori): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($kategori['nama_kategori']) ?></td>
                        <td class="aksi">
                            <a class="edit" href="index.php?controller=kategori&action=edit&id=<?= $kategori['id_kategori'] ?>">Edit</a>
                            <a class="hapus" href="index.php?controller=kategori&action=delete&id=<?= $kategori['id_kategori'] ?>"
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