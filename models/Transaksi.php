<?php
// models/Transaksi.php
// Model untuk tabel: transaksi (versi PDO)
// Membutuhkan models/Sparepart.php untuk update stok otomatis

require_once "Sparepart.php";

// Ambil semua riwayat transaksi beserta nama barang, urut terbaru dulu
function getAllTransaksi($koneksi) {
    $sql = "SELECT t.*, s.nama_barang, s.kode_barang
            FROM transaksi t
            JOIN sparepart s ON t.id_sparepart = s.id_sparepart
            ORDER BY t.tanggal DESC";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil riwayat transaksi untuk 1 sparepart tertentu
function getTransaksiBySparepart($koneksi, $id_sparepart) {
    $sql = "SELECT * FROM transaksi WHERE id_sparepart = :id_sparepart ORDER BY tanggal DESC";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id_sparepart', $id_sparepart, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Catat transaksi barang MASUK + otomatis tambah stok sparepart
function catatBarangMasuk($koneksi, $id_sparepart, $jumlah, $keterangan, $petugas) {
    $koneksi->beginTransaction();
    try {
        $sql = "INSERT INTO transaksi (id_sparepart, jenis, jumlah, keterangan, petugas) 
                VALUES (:id_sparepart, 'masuk', :jumlah, :keterangan, :petugas)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bindParam(':id_sparepart', $id_sparepart, PDO::PARAM_INT);
        $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
        $stmt->bindParam(':keterangan', $keterangan, PDO::PARAM_STR);
        $stmt->bindParam(':petugas', $petugas, PDO::PARAM_STR);
        $stmt->execute();

        tambahStok($koneksi, $id_sparepart, $jumlah);

        $koneksi->commit();
        return true;
    } catch (Exception $e) {
        $koneksi->rollBack();
        return false;
    }
}

// Catat transaksi barang KELUAR + otomatis kurangi stok sparepart
function catatBarangKeluar($koneksi, $id_sparepart, $jumlah, $keterangan, $petugas) {
    $koneksi->beginTransaction();
    try {
        $sql = "INSERT INTO transaksi (id_sparepart, jenis, jumlah, keterangan, petugas) 
                VALUES (:id_sparepart, 'keluar', :jumlah, :keterangan, :petugas)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bindParam(':id_sparepart', $id_sparepart, PDO::PARAM_INT);
        $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
        $stmt->bindParam(':keterangan', $keterangan, PDO::PARAM_STR);
        $stmt->bindParam(':petugas', $petugas, PDO::PARAM_STR);
        $stmt->execute();

        $baris_terupdate = kurangiStok($koneksi, $id_sparepart, $jumlah);
        if ($baris_terupdate === 0) {
            throw new Exception("Stok tidak mencukupi");
        }

        $koneksi->commit();
        return true;
    } catch (Exception $e) {
        $koneksi->rollBack();
        return false;
    }
}
?>