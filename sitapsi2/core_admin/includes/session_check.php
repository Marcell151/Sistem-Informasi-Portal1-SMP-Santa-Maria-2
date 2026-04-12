<?php
/**
 * PORTAL SEKOLAH - Session Security Check (Core)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ../../index.php');
        exit;
    }
    
    $timeout = 2 * 60 * 60; 
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > $timeout)) {
        session_destroy();
        header('Location: ../../index.php?timeout=1');
        exit;
    }
    $_SESSION['login_time'] = time();
}

function checkRole($allowed_roles = []) {
    checkLogin();
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        http_response_code(403);
        die("Akses Ditolak: Anda tidak memiliki hak akses ke halaman ini.");
    }
}

/**
 * DISESUAIKAN: Hanya Role 'Admin' (Master) yang boleh akses
 */
function requireSuperAdmin() {
    checkRole(['SuperAdmin']);
}

/**
 * DISESUAIKAN: Admin Utama & Admin Tatib boleh akses modul Tatib
 */
function requireAdmin() {
    checkRole(['Admin', 'SuperAdmin']);
}

function requireGuru() {
    checkRole(['Guru']);
}

function getCurrentUser() {
    checkLogin();
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? '',
        'nama_lengkap' => $_SESSION['nama_lengkap'],
        'role' => $_SESSION['role'],
        'login_type' => $_SESSION['login_type'] ?? ''
    ];
}

/**
 * DISESUAIKAN: Cek apakah user termasuk kategori admin manapun
 */
function isAdmin() {
    return isset($_SESSION['role']) && in_array($_SESSION['role'], ['Admin', 'AdminTatib']);
}

function isGuru() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Guru';
}

checkLogin();
?>