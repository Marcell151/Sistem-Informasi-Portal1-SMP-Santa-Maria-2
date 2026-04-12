<?php
session_start();
require_once '../config/database.php';
require_once '../includes/session_check.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ortu = $_POST['id_ortu'];
    $no_hp_lama = $_POST['no_hp_lama'];
    
    $nama_wali = trim($_POST['nama_wali']);
    $nama_ayah = trim($_POST['nama_ayah']);
    $pekerjaan_ayah = trim($_POST['pekerjaan_ayah']);
    $nama_ibu = trim($_POST['nama_ibu']);
    $pekerjaan_ibu = trim($_POST['pekerjaan_ibu']);
    $no_hp_baru = trim($_POST['no_hp_ortu']);
    $alamat = trim($_POST['alamat']);

    try {
        // Cek duplikasi HP jika diganti
        if ($no_hp_lama !== $no_hp_baru) {
            $cek = fetchOne("SELECT id_ortu FROM tb_orang_tua WHERE no_hp_ortu = ? AND id_ortu != ?", [$no_hp_baru, $id_ortu]);
            if ($cek) {
                throw new Exception("Nomor HP yang baru Anda masukkan sudah dipakai Wali Murid lain!");
            }
        }

        executeQuery("
            UPDATE tb_orang_tua SET 
                nama_wali = ?, nama_ayah = ?, pekerjaan_ayah = ?, 
                nama_ibu = ?, pekerjaan_ibu = ?, no_hp_ortu = ?, alamat = ?
            WHERE id_ortu = ?
        ", [$nama_wali, $nama_ayah, $pekerjaan_ayah, $nama_ibu, $pekerjaan_ibu, $no_hp_baru, $alamat, $id_ortu]);

        $_SESSION['success_message'] = "✅ Data Wali Murid berhasil diperbarui!";

    } catch (Exception $e) {
        $_SESSION['error_message'] = "❌ Gagal: " . $e->getMessage();
    }
}

header("Location: ../views/admin/data_ortu.php");
exit;