<?php
// models/Kategori.php
// Model untuk tabel: kategori (versi PDO, menyesuaikan Database.php)

// Ambil semua kategori yang statusnya aktif
function getAllKategori($koneksi) {
    $sql = "SELECT * FROM kategori WHERE status = 'aktif'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil 1 kategori berdasarkan id
function getKategoriById($koneksi, $id) {
    $sql = "SELECT * FROM kategori WHERE id_kategori = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Tambah kategori baru
function tambahKategori($koneksi, $nama_kategori) {
    $sql = "INSERT INTO kategori (nama_kategori) VALUES (:nama_kategori)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':nama_kategori', $nama_kategori, PDO::PARAM_STR);
    return $stmt->execute();
}

// Edit nama kategori
function updateKategori($koneksi, $id, $nama_kategori) {
    $sql = "UPDATE kategori SET nama_kategori = :nama_kategori WHERE id_kategori = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':nama_kategori', $nama_kategori, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Nonaktifkan kategori (soft delete, bukan hapus permanen)
function nonaktifkanKategori($koneksi, $id) {
    $sql = "UPDATE kategori SET status = 'nonaktif' WHERE id_kategori = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>