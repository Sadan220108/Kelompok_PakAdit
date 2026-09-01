<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Kategori.php';

class KategoriController
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
        $data_kategori = getAllKategori($this->db);
        include 'app/views/kategori/index.php';
    }
    public function tambah()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }
        include 'app/views/kategori/tambah.php';
    }
    public function tambahproses()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }
        if($_POST){
            $nama = trim($_POST['nama_kategori'] ?? '');
            if (!empty($nama)) {
                $data_kategori = getAllKategori($this->db);
                $kategori_sudah_ada = false;

                foreach ($data_kategori as $kategori){
                    if (strtolower($kategori['nama_kategori']) === strtolower($nama)){
                        $kategori_sudah_ada = true;
                        break;
                    }
                }
                if ($kategori_sudah_ada) {
                    $_SESSION['error_msg'] = "Gagal: Kategori '<b>". htmlspecialchars($nama) . "<b>' sudah ada!";
                    header('Location: index.php?act=kategori-tambah');
                    exit;
                }else{
                    tambahKategori($this->db, $nama);
                    header('Location: index.php?act=kategori');
                    exit;
                }
            }
            $_SESSION['error_msg'] = "Nama Tidak Boleh Kosong!";
            header('Location: index.php?act=kategori-tambah');
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
            die("Error: ID kategori tidak ditemukan.");
        }

        $kat = getKategoriById($this->db, $id);

        if (!$kat) {
            die("Error: Kategori tidak ditemukan.");
        }

        include 'app/views/kategori/edit.php';
    }
    public function editproses()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php");
            exit;
        }

        if ($_POST) {

            $id = $_POST['id_kategori'] ?? '';
            $nama_baru = trim($_POST['nama_kategori'] ?? '');

            if (!empty($nama_baru) && !empty($id)) {

                // Ambil kategori lama
                $kategori_lama = getKategoriById($this->db, $id);

                if (!$kategori_lama) {
                    $_SESSION['error_msg'] = "Kategori tidak ditemukan.";
                    header("Location: index.php?act=kategori");
                    exit;
                }

                // Cek apakah nama kategori sudah digunakan
                $data_kategori = getAllKategori($this->db);

                $kategori_sudah_ada = false;

                foreach ($data_kategori as $kategori) {

                    // Jangan cek kategori yang sedang diedit
                    if (
                        $kategori['id_kategori'] != $id &&
                        strtolower($kategori['nama_kategori']) ===
                        strtolower($nama_baru)
                    ) {
                        $kategori_sudah_ada = true;
                        break;
                    }
                }

                // Jika nama kategori sudah digunakan
                if ($kategori_sudah_ada) {

                    $_SESSION['error_msg'] =
                        "Gagal update: Kategori '<b>" .
                        htmlspecialchars($nama_baru) .
                        "</b>' sudah digunakan!";

                    header(
                        "Location: index.php?act=kategori-edit&id=" . $id
                    );

                    exit;
                }

                // Update kategori
                updateKategori(
                    $this->db,
                    $id,
                    $nama_baru
                );

                $_SESSION['success_msg'] =
                    "Berhasil Edit Kategori";

                header(
                    "Location: index.php?act=kategori"
                );

                exit;
            }

            // Jika nama atau ID kosong
            $_SESSION['error_msg'] =
                "Nama kategori tidak boleh kosong!";

            header(
                "Location: index.php?act=kategori"
            );

            exit;
        }
    }
    public function hapus()
    {
        if (!isset($_SESSION['admin_id'])) {
        header("Location: index.php");
        exit;
    }
        if (isset($_GET['id'])) {
        $id = $_GET['id'];
        nonaktifkanKategori(
        $this->db,
        $id
        );
        $_SESSION['success_msg'] =
        "Berhasil Hapus Kategori";
    }
    header("Location: index.php?act=kategori");
    exit;
    }
}
?>