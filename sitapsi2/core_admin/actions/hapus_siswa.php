<?php
/**
 * SITAPSI - Hapus Siswa
 * Menghapus siswa dari tb_siswa dan semua relasi
 */

session_start();
require_once '../../config/database.php';
require_once '../includes/session_check.php';

requireAdmin();

$no_induk = $_GET['no_induk'] ?? null;

if (!$no_induk) {
    $_SESSION['error_message'] = '❌ No Induk tidak valid';
    header('Location: ../views/data_siswa.php');
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

    // Cek apakah ada pelanggaran aktif
    $cek_pelanggaran = fetchOne("
        SELECT COUNT(*) as total
        FROM tb_pelanggaran_header h
        JOIN tb_anggota_kelas a ON h.id_anggota = a.id_anggota
        WHERE a.no_induk = :no_induk
    ", ['no_induk' => $no_induk]);

    if ($cek_pelanggaran['total'] > 0) {
        throw new Exception(
            'Tidak dapat menghapus! Siswa ini memiliki ' 
            . $cek_pelanggaran['total'] 
            . ' riwayat pelanggaran. Jika dihapus, status siswa menjadi Dikeluarkan/Keluar.'
        );
    } // Kita akan tetap lanjut, tapi memakai Soft Delete.

    // 1. Cabut keanggotaan kelas aktifnya supaya tidak bisa absen lagi
    // executeQuery("DELETE FROM tb_anggota_kelas WHERE no_induk = :no_induk", ['no_induk' => $no_induk]); // Dihapus logikanya, karena bisa jadi butuh riwayat kelas

    // 2. Ubah Status Siswa menjadi Nonaktif / Dikeluarkan / Keluar
    executeQuery("UPDATE tb_siswa SET status_aktif = 'Keluar' WHERE no_induk = :no_induk", ['no_induk' => $no_induk]);

    $pdo->commit();

    $_SESSION['success_message'] = "✅ Siswa {$siswa['nama_siswa']} ($no_induk) berhasil diarsipkan/dikeluarkan dari sistem.";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error_message'] = '❌ Gagal: ' . $e->getMessage();
}

header('Location: ../views/data_siswa.php');
exit;