```php
<?php

include_once 'config/database.php';
include_once 'app/models/Transaksi.php';

class TransaksiController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Menampilkan semua riwayat transaksi
    public function index()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        $data_transaksi = getAllTransaksi($this->db);

        include 'app/views/transaksi/index.php';
    }

    // Menampilkan riwayat transaksi berdasarkan sparepart
    public function detail()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        $id_sparepart = $_GET['id'] ?? '';

        if (empty($id_sparepart)) {
            die("Error: ID sparepart tidak ditemukan.");
        }

        $data_transaksi = getTransaksiBySparepart(
            $this->db,
            $id_sparepart
        );

        include 'app/views/transaksi/detail.php';
    }

    // Menampilkan form tambah transaksi
    public function tambah()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        include 'app/views/transaksi/tambah.php';
    }

    // Proses transaksi barang masuk / keluar
    public function tambahproses()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        if ($_POST) {

            $id_sparepart = $_POST['id_sparepart'] ?? '';
            $jenis = $_POST['jenis'] ?? '';
            $jumlah = $_POST['jumlah'] ?? '';
            $keterangan = trim($_POST['keterangan'] ?? '');
            $petugas = trim($_POST['petugas'] ?? '');

            // Validasi data
            if (
                !empty($id_sparepart) &&
                !empty($jenis) &&
                !empty($jumlah) &&
                !empty($petugas)
            ) {

                // Pastikan jumlah berupa angka
                if (!is_numeric($jumlah) || $jumlah <= 0) {
                    $_SESSION['error_msg'] =
                        "Jumlah transaksi harus lebih dari 0.";

                    header(
                        "Location: index.php?act=transaksi-tambah"
                    );
                    exit;
                }

                // Transaksi barang masuk
                if ($jenis === 'masuk') {

                    $hasil = catatBarangMasuk(
                        $this->db,
                        $id_sparepart,
                        $jumlah,
                        $keterangan,
                        $petugas
                    );

                    if ($hasil) {
                        $_SESSION['success_msg'] =
                            "Berhasil mencatat barang masuk.";
                    } else {
                        $_SESSION['error_msg'] =
                            "Gagal mencatat barang masuk.";
                    }

                // Transaksi barang keluar
                } elseif ($jenis === 'keluar') {

                    $hasil = catatBarangKeluar(
                        $this->db,
                        $id_sparepart,
                        $jumlah,
                        $keterangan,
                        $petugas
                    );

                    if ($hasil) {
                        $_SESSION['success_msg'] =
                            "Berhasil mencatat barang keluar.";
                    } else {
                        $_SESSION['error_msg'] =
                            "Gagal mencatat barang keluar. Stok mungkin tidak mencukupi.";
                    }

                } else {

                    $_SESSION['error_msg'] =
                        "Jenis transaksi tidak valid.";
                }

                header("Location: index.php?act=transaksi");
                exit;
            }

            $_SESSION['error_msg'] =
                "Data transaksi tidak boleh kosong.";

            header(
                "Location: index.php?act=transaksi-tambah"
            );
            exit;
        }
    }
}

?>