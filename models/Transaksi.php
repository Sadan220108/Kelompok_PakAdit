<?php
// models/Transaksi.php
// Model untuk tabel: transaksi
// Membutuhkan models/Sparepart.php untuk update stok otomatis

require_once "Sparepart.php";

// Ambil semua riwayat transaksi beserta nama barang, urut terbaru dulu
function getAllTransaksi($koneksi) {
    $sql = "SELECT t.*, s.nama_barang, s.kode_barang
            FROM transaksi t
            JOIN sparepart s ON t.id_sparepart = s.id_sparepart
            ORDER BY t.tanggal DESC";
    return mysqli_query($koneksi, $sql);
}

// Ambil riwayat transaksi untuk 1 sparepart tertentu
function getTransaksiBySparepart($koneksi, $id_sparepart) {
    $sql = "SELECT * FROM transaksi WHERE id_sparepart = ? ORDER BY tanggal DESC";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_sparepart);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Catat transaksi barang MASUK + otomatis tambah stok sparepart
function catatBarangMasuk($koneksi, $id_sparepart, $jumlah, $keterangan, $petugas) {
    mysqli_begin_transaction($koneksi);
    try {
        $sql = "INSERT INTO transaksi (id_sparepart, jenis, jumlah, keterangan, petugas) 
                VALUES (?, 'masuk', ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "iiss", $id_sparepart, $jumlah, $keterangan, $petugas);
        mysqli_stmt_execute($stmt);

        tambahStok($koneksi, $id_sparepart, $jumlah);

        mysqli_commit($koneksi);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        return false;
    }
}

// Catat transaksi barang KELUAR + otomatis kurangi stok sparepart
function catatBarangKeluar($koneksi, $id_sparepart, $jumlah, $keterangan, $petugas) {
    mysqli_begin_transaction($koneksi);
    try {
        $sql = "INSERT INTO transaksi (id_sparepart, jenis, jumlah, keterangan, petugas) 
                VALUES (?, 'keluar', ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "iiss", $id_sparepart, $jumlah, $keterangan, $petugas);
        mysqli_stmt_execute($stmt);

        $berhasil = kurangiStok($koneksi, $id_sparepart, $jumlah);
        if (!$berhasil || mysqli_affected_rows($koneksi) === 0) {
            throw new Exception("Stok tidak mencukupi");
        }

        mysqli_commit($koneksi);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        return false;
    }
}
?>
