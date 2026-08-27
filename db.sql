CREATE DATABASE project_inventory
USE project_inventory

CREATE TABLE kategori(
id_kategori INT PRIMARY KEY AUTO_INCREMENT,
nama_kategori VARCHAR (40) NOT NULL,
STATUS ENUM ("aktif", "nonaktif")
)

CREATE TABLE sparepart (
    id_sparepart INT PRIMARY KEY AUTO_INCREMENT,
    kode_barang VARCHAR(20) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    id_kategori INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    STATUS ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
)

CREATE TABLE transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_sparepart INT NOT NULL,
    jenis ENUM('masuk','keluar') NOT NULL,
    jumlah INT NOT NULL,
    keterangan VARCHAR(255),
    petugas VARCHAR(50),
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_sparepart) REFERENCES sparepart(id_sparepart)
);

INSERT INTO kategori (nama_kategori) VALUES
('PSU'),
('RAM'),
('HDD/SSD'),
('Kabel'),
('Fan/Kipas');

INSERT INTO sparepart (kode_barang, nama_barang, id_kategori, stok) VALUES
('PSU-001', 'PSU 450W Corsair', 1, 5 ),
('RAM-001', 'RAM DDR3 4GB', 2, 3 ),
('SSD-001', 'SSD 240GB', 3, 4),
('KBL-001', 'Kabel HDMI 1.5m', 4, 10 ),
('FAN-001', 'Fan Casing 12cm', 5, 6 );

INSERT INTO transaksi (id_sparepart, jenis, jumlah, keterangan, petugas, tanggal) VALUES
(1, 'keluar', 1, 'Ganti PSU PC Lobby', 'Dani', NOW());