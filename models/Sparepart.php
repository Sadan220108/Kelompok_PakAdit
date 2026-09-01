<?php
// models/Sparepart.php
// Model untuk tabel: sparepart (versi PDO)

// Ambil semua sparepart aktif beserta nama kategorinya
function getAllSparepart($koneksi) {
    $sql = "SELECT s.*, k.nama_kategori 
            FROM sparepart s 
            JOIN kategori k ON s.id_kategori = k.id_kategori
            WHERE s.status = 'aktif'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil 1 sparepart berdasarkan id
function getSparepartById($koneksi, $id) {
    $sql = "SELECT * FROM sparepart WHERE id_sparepart = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cari sparepart yang stoknya di bawah batas tertentu (contoh: stok menipis)
function getSparepartStokMenipis($koneksi, $batas = 5) {
    $sql = "SELECT * FROM sparepart WHERE stok <= :batas AND status = 'aktif'";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':batas', $batas, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Tambah sparepart baru
function tambahSparepart($koneksi, $kode_barang, $nama_barang, $id_kategori, $stok) {
    $sql = "INSERT INTO sparepart (kode_barang, nama_barang, id_kategori, stok) 
            VALUES (:kode_barang, :nama_barang, :id_kategori, :stok)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':kode_barang', $kode_barang, PDO::PARAM_STR);
    $stmt->bindParam(':nama_barang', $nama_barang, PDO::PARAM_STR);
    $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);
    $stmt->bindParam(':stok', $stok, PDO::PARAM_INT);
    return $stmt->execute();
}

// Edit data sparepart (tanpa ubah stok, stok diubah lewat transaksi)
function updateSparepart($koneksi, $id, $kode_barang, $nama_barang, $id_kategori) {
    $sql = "UPDATE sparepart 
            SET kode_barang = :kode_barang, nama_barang = :nama_barang, id_kategori = :id_kategori 
            WHERE id_sparepart = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':kode_barang', $kode_barang, PDO::PARAM_STR);
    $stmt->bindParam(':nama_barang', $nama_barang, PDO::PARAM_STR);
    $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Tambah stok (dipanggil saat ada transaksi masuk)
function tambahStok($koneksi, $id, $jumlah) {
    $sql = "UPDATE sparepart SET stok = stok + :jumlah WHERE id_sparepart = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Kurangi stok (dipanggil saat ada transaksi keluar)
// Return jumlah baris yang ke-update (0 kalau stok gak cukup)
function kurangiStok($koneksi, $id, $jumlah) {
    $sql = "UPDATE sparepart SET stok = stok - :jumlah WHERE id_sparepart = :id AND stok >= :jumlah2";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':jumlah2', $jumlah, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

// Nonaktifkan sparepart (soft delete)
function nonaktifkanSparepart($koneksi, $id) {
    $sql = "UPDATE sparepart SET status = 'nonaktif' WHERE id_sparepart = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>