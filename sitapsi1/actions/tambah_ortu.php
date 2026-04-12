<?php
session_start();
require_once '../config/database.php';
require_once '../includes/session_check.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_wali = trim($_POST['nama_wali']); // Menggantikan NIK
    $nama_ayah = trim($_POST['nama_ayah']);
    $pekerjaan_ayah = trim($_POST['pekerjaan_ayah']);
    $nama_ibu = trim($_POST['nama_ibu']);
    $pekerjaan_ibu = trim($_POST['pekerjaan_ibu']);
    $no_hp = trim($_POST['no_hp_ortu']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama_wali) || empty($no_hp)) {
        $_SESSION['error_message'] = "Data Nama Wali dan No HP wajib diisi!";
        header("Location: ../views/admin/data_ortu.php");
        exit;
    }

    try {
        // Cek duplikasi No HP (karena NIK dihapus, No HP jadi acuan unik)
        $cek = fetchOne("SELECT id_ortu FROM tb_orang_tua WHERE no_hp_ortu = ?", [$no_hp]);
        if ($cek) {
            throw new Exception("Nomor HP tersebut sudah terdaftar di sistem!");
        }

        $pass_default = md5('123456');

        // Insert data awal tanpa username (karena username butuh ID)
        executeQuery("
            INSERT INTO tb_orang_tua (password, nama_wali, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_hp_ortu, alamat)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ", [$pass_default, $nama_wali, $nama_ayah, $pekerjaan_ayah, $nama_ibu, $pekerjaan_ibu, $no_hp, $alamat]);

        // Ambil ID yang baru saja masuk berdasarkan No HP yang unik tadi
        $data_baru = fetchOne("SELECT id_ortu FROM tb_orang_tua WHERE no_hp_ortu = ?", [$no_hp]);
        $id_baru = $data_baru['id_ortu'];

        // LOGIKA BIKIN USERNAME OTOMATIS (Nama depan + ID)
        $kata_pertama = explode(' ', trim($nama_wali))[0];
        $kata_pertama = strtolower($kata_pertama);
        $nama_bersih = preg_replace('/[^a-z]/', '', $kata_pertama); 
        if(empty($nama_bersih)) $nama_bersih = 'ortu'; // Jaga-jaga jika inputannya aneh
        
        $username_baru = $nama_bersih . $id_baru;

        // Update row dengan username yang sudah dibuat
        executeQuery("UPDATE tb_orang_tua SET username = ? WHERE id_ortu = ?", [$username_baru, $id_baru]);

        $_SESSION['success_message'] = "✅ Wali Murid berhasil ditambah! USERNAME LOGIN: " . $username_baru . " (Sandi: 123456)";

    } catch (Exception $e) {
        $_SESSION['error_message'] = "❌ Gagal: " . $e->getMessage();
    }
}

header("Location: ../views/admin/data_ortu.php");
exit;