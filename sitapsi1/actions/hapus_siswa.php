<?php


session_start();
require_once '../config/database.php';
require_once '../includes/session_check.php';

requireAdmin();

$no_induk = $_GET['no_induk'] ?? null;

if (!$no_induk) {
    $_SESSION['error_message'] = '❌ No Induk tidak valid';
    header('Location: ../views/admin/data_siswa.php');
    exit;
}

try {
    $pdo = getDBConnection();
    $pdo->beginTransaction();

    // Ambil nama siswa untuk pesan sukses
    $siswa = fetchOne("SELECT nama_siswa FROM tb_siswa WHERE no_induk = :no_induk", ['no_induk' => $no_induk]);

    if (!$siswa) {
        throw new Exception('Siswa tidak ditemukan');
    }

    // Hapus dari tb_siswa
    executeQuery("UPDATE tb_siswa SET status_aktif = 'Keluar' WHERE no_induk = :no_induk", ['no_induk' => $no_induk]);

    $pdo->commit();

    $_SESSION['success_message'] = "✅ Siswa {$siswa['nama_siswa']} ($no_induk) berhasil dihapus permanen.";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error_message'] = '❌ Gagal: ' . $e->getMessage();
}

header('Location: ../views/admin/data_siswa.php');
exit;