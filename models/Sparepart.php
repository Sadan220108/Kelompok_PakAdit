<?php
// models/Sparepart.php
// Model untuk tabel: sparepart

// Ambil semua sparepart aktif beserta nama kategorinya
function getAllSparepart($koneksi) {
    $sql = "SELECT s.*, k.nama_kategori 
            FROM sparepart s 
            JOIN kategori k ON s.id_kategori = k.id_kategori
            WHERE s.status = 'aktif'";
    return mysqli_query($koneksi, $sql);
}

// Ambil 1 sparepart berdasarkan id
function getSparepartById($koneksi, $id) {
    $sql = "SELECT * FROM sparepart WHERE id_sparepart = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Cari sparepart yang stoknya di bawah batas tertentu (contoh: stok menipis)
function getSparepartStokMenipis($koneksi, $batas = 5) {
    $sql = "SELECT * FROM sparepart WHERE stok <= ? AND status = 'aktif'";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $batas);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Tambah sparepart baru
function tambahSparepart($koneksi, $kode_barang, $nama_barang, $id_kategori, $stok) {
    $sql = "INSERT INTO sparepart (kode_barang, nama_barang, id_kategori, stok) 
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $kode_barang, $nama_barang, $id_kategori, $stok);
    return mysqli_stmt_execute($stmt);
}

// Edit data sparepart (tanpa ubah stok, stok diubah lewat transaksi)
function updateSparepart($koneksi, $id, $kode_barang, $nama_barang, $id_kategori) {
    $sql = "UPDATE sparepart 
            SET kode_barang = ?, nama_barang = ?, id_kategori = ? 
            WHERE id_sparepart = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $kode_barang, $nama_barang, $id_kategori, $id);
    return mysqli_stmt_execute($stmt);
}

// Tambah stok (dipanggil saat ada transaksi masuk)
function tambahStok($koneksi, $id, $jumlah) {
    $sql = "UPDATE sparepart SET stok = stok + ? WHERE id_sparepart = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $jumlah, $id);
    return mysqli_stmt_execute($stmt);
}

// Kurangi stok (dipanggil saat ada transaksi keluar)
function kurangiStok($koneksi, $id, $jumlah) {
    $sql = "UPDATE sparepart SET stok = stok - ? WHERE id_sparepart = ? AND stok >= ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $jumlah, $id, $jumlah);
    return mysqli_stmt_execute($stmt);
}

// Nonaktifkan sparepart (soft delete)
function nonaktifkanSparepart($koneksi, $id) {
    $sql = "UPDATE sparepart SET status = 'nonaktif' WHERE id_sparepart = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>
