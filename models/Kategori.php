<?php
// models/Kategori.php
// Model untuk tabel: kategori

// Ambil semua kategori yang statusnya aktif
function getAllKategori($koneksi) {
    $sql = "SELECT * FROM kategori WHERE status = 'aktif'";
    return mysqli_query($koneksi, $sql);
}

// Ambil 1 kategori berdasarkan id
function getKategoriById($koneksi, $id) {
    $sql = "SELECT * FROM kategori WHERE id_kategori = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Tambah kategori baru
function tambahKategori($koneksi, $nama_kategori) {
    $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nama_kategori);
    return mysqli_stmt_execute($stmt);
}

// Edit nama kategori
function updateKategori($koneksi, $id, $nama_kategori) {
    $sql = "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nama_kategori, $id);
    return mysqli_stmt_execute($stmt);
}

// Nonaktifkan kategori (soft delete, bukan hapus permanen)
function nonaktifkanKategori($koneksi, $id) {
    $sql = "UPDATE kategori SET status = 'nonaktif' WHERE id_kategori = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>
