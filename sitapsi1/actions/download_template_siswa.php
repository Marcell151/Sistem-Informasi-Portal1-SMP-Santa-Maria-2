<?php

session_start();
require_once '../config/database.php';

// Validasi Keamanan
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'AdminPusat' && $_SESSION['role'] !== 'Admin')) {
    die("Akses ditolak!");
}

// 1. SET HEADER AGAR BROWSER MENDOWNLOAD FILE CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Template_Import_Siswa_SITAPSI.csv');
header('Cache-Control: max-age=0');

$output = fopen('php://output', 'w');

// 2. MAGIC TRICK: Tambahkan BOM agar Microsoft Excel membaca file ini dengan rapi
fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

// 3. SET JUDUL KOLOM (HEADER) - [PENYESUAIAN] NIK diubah jadi Username
$headers = [
    'No Induk', 'Nama Peserta Didik', 'L/P', 'Tempat Lahir', 'Tanggal Lahir',
    'Alamat Jalan', 'Nama Ayah', 'Pekerjaan Ayah', 'Nama Ibu', 'Pekerjaan Ibu',
    'No HP', 'Username Wali', 'Kelas' 
];
fputcsv($output, $headers, ',');


// 4. SET CONTOH DATA SEBAGAI PANDUAN TU
// Jika Username dikosongi, sistem akan otomatis membuatkan akun wali murid baru berdasarkan No HP
$contoh_data = [
    '2025001', 'Ahmad Dani', 'L', 'Malang', '2010-05-15',
    'Jl. Merdeka No. 1, Malang', 'Budi Santoso', 'Wiraswasta', 'Siti Aminah', 'Ibu Rumah Tangga',
    '081234567890', '', 'VII A' 
];
fputcsv($output, $contoh_data, ',');

fclose($output);
exit;
?>