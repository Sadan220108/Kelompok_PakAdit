<?php
session_start();

// Website ini tidak memakai sistem login, tapi controller-controller
// kamu tetap mengecek $_SESSION['admin_id'] di setiap method.
// Baris ini otomatis mengisi session tersebut supaya semua halaman
// bisa langsung diakses tanpa proses login.
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['admin_id'] = 1;
}

// Include semua controller
include_once 'controllers/KategoriController.php';
include_once 'controllers/SparepartController.php';
include_once 'controllers/TransaksiController.php';

// Ambil parameter act dari URL, contoh: sparepart-tambah
$act = $_GET['act'] ?? 'sparepart';

// Pisahkan jadi [modul, aksi]
// Contoh: "sparepart-tambah" => modul = "sparepart", aksi = "tambah"
// Contoh: "sparepart"        => modul = "sparepart", aksi = "index"
$parts  = explode('-', $act, 2);
$modul  = $parts[0];
$aksi   = $parts[1] ?? 'index';

// Mapping nama modul (di URL) ke nama class Controller
$controllerMap = [
    'kategori'  => 'KategoriController',
    'sparepart' => 'SparepartController',
    'transaksi' => 'TransaksiController',
];

// Kalau modul tidak dikenali, tampilkan pesan sederhana
if (!isset($controllerMap[$modul])) {
    die("Halaman tidak ditemukan: modul '$modul' tidak dikenali.");
}

$namaController = $controllerMap[$modul];
$controller     = new $namaController();

// Kalau method aksi-nya tidak ada di controller tersebut
if (!method_exists($controller, $aksi)) {
    die("Halaman tidak ditemukan: aksi '$aksi' tidak ada di $namaController.");
}

// Panggil method-nya
$controller->$aksi();