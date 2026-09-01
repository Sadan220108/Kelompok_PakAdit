<?php

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Sparepart.php';
class SparepartController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        $data_sparepart = getAllSparepart($this->db);
        include __DIR__ . '/../views/sparepart/index.php';
    }

    public function tambah()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        include __DIR__ . '/../views/sparepart/tambah.php';
    }

    public function tambahproses()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        if ($_POST) {
            $kode_barang = trim($_POST['kode_barang'] ?? '');
            $nama_barang = trim($_POST['nama_barang'] ?? '');
            $id_kategori = $_POST['id_kategori'] ?? '';
            $stok = $_POST['stok'] ?? '';

            if (
                !empty($kode_barang) &&
                !empty($nama_barang) &&
                !empty($id_kategori) &&
                $stok !== ''
            ) {
                $hasil = tambahSparepart(
                    $this->db,
                    $kode_barang,
                    $nama_barang,
                    $id_kategori,
                    $stok
                );

                if ($hasil) {
                    $_SESSION['success_msg'] = "Berhasil Tambah Sparepart";
                    header("Location: index.php?act=sparepart");
                    exit;
                }

                $_SESSION['error_msg'] = "Gagal Tambah Sparepart";
                header("Location: index.php?act=sparepart-tambah");
                exit;
            }

            $_SESSION['error_msg'] = "Data sparepart tidak boleh kosong!";
            header("Location: index.php?act=sparepart-tambah");
            exit;
        }
    }

    public function edit()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        $id = $_GET['id'] ?? '';

        if (empty($id)) {
            die("Error: ID sparepart tidak ditemukan.");
        }

        $sparepart = getSparepartById($this->db, $id);

        if (!$sparepart) {
            die("Error: Sparepart tidak ditemukan.");
        }

        include __DIR__ . '/../views/sparepart/edit.php';
    }

    public function editproses()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        if ($_POST) {
            $id = $_POST['id_sparepart'] ?? '';
            $kode_barang = trim($_POST['kode_barang'] ?? '');
            $nama_barang = trim($_POST['nama_barang'] ?? '');
            $id_kategori = $_POST['id_kategori'] ?? '';

            if (
                !empty($id) &&
                !empty($kode_barang) &&
                !empty($nama_barang) &&
                !empty($id_kategori)
            ) {
                $sparepart_lama = getSparepartById($this->db, $id);

                if (!$sparepart_lama) {
                    $_SESSION['error_msg'] = "Sparepart tidak ditemukan.";
                    header("Location: index.php?act=sparepart");
                    exit;
                }

                $hasil = updateSparepart(
                    $this->db,
                    $id,
                    $kode_barang,
                    $nama_barang,
                    $id_kategori
                );

                if ($hasil) {
                    $_SESSION['success_msg'] = "Berhasil Edit Sparepart";
                } else {
                    $_SESSION['error_msg'] = "Gagal Edit Sparepart";
                }

                header("Location: index.php?act=sparepart");
                exit;
            }

            $_SESSION['error_msg'] = "Data sparepart tidak lengkap!";
            header("Location: index.php?act=sparepart");
            exit;
        }
    }

    public function stokmenipis()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        $batas = 5;
        $data_sparepart = getSparepartStokMenipis($this->db, $batas);

        include __DIR__ . '/../views/sparepart/stokmenipis.php';
    }

    public function hapus()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $hasil = nonaktifkanSparepart($this->db, $id);

            if ($hasil) {
                $_SESSION['success_msg'] = "Berhasil Hapus Sparepart";
            } else {
                $_SESSION['error_msg'] = "Gagal Hapus Sparepart";
            }
        }

        header("Location: index.php?act=sparepart");
        exit;
    }
}

?>