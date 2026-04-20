<?php

session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil input dan bersihkan (Diubah dari nik ke username)
    $username = trim($_POST['username'] ?? '');
    $password_raw = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']); // Tangkap status Checkbox Ingat Saya
    
    if (empty($username) || empty($password_raw)) {
        $_SESSION['error_message'] = "⚠️ Username dan Password tidak boleh kosong.";
        header("Location: ../views/ortu/login.php");
        exit;
    }

    try {
        // Enkripsi inputan password menggunakan MD5
        $password_hashed = md5($password_raw);

        // Cek data di tabel tb_orang_tua (Gunakan username dan cek is_active)
        $ortu = fetchOne("SELECT * FROM tb_orang_tua WHERE username = :user AND password = :pass AND is_active = 1 LIMIT 1", [
            'user' => $username,
            'pass' => $password_hashed
        ]);

        if ($ortu) {
            // LOGIN BERHASIL: Buat Session Khusus Wali Murid
            
            $_SESSION['ortu_id'] = $ortu['id_ortu'];
            $_SESSION['ortu_username'] = $ortu['username']; // Ubah nama session
            
            // Ambil langsung dari kolom nama_wali sesuai struktur DB baru
            $_SESSION['nama_user'] = !empty($ortu['nama_wali']) ? $ortu['nama_wali'] : 'Wali Murid';
            
            // Tanda pengenal akses portal
            $_SESSION['role'] = 'Ortu'; 
            
            // LOGIKA REMEMBER ME (Simpan di Cookie Browser selama 30 Hari)
            if ($remember_me) {
                // Simpan Username dan Password raw ke cookie agar bisa di-load otomatis di form
                setcookie('saved_ortu_username', $username, time() + (86400 * 30), "/"); 
                setcookie('saved_ortu_pass', $password_raw, time() + (86400 * 30), "/");
            } else {
                // Jika tidak dicentang, hapus Cookie yang mungkin pernah tersimpan sebelumnya
                setcookie('saved_ortu_username', '', time() - 3600, "/");
                setcookie('saved_ortu_pass', '', time() - 3600, "/");
            }

            // Lempar ke Dashboard Utama (Hub)
            header("Location: ../views/ortu/dashboard.php");
            exit;
            
        } else {
            // LOGIN GAGAL: Username atau Password salah, atau Dinonaktifkan
            $_SESSION['error_message'] = "❌ Username/Password salah, atau Akun Anda Dinonaktifkan.";
            header("Location: ../views/ortu/login.php");
            exit;
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = "🚨 Terjadi kesalahan sistem: " . $e->getMessage();
    header("Location: ../views/ortu/login.php");
        exit;
    }
} else {
    // Jika ada yang mencoba akses file ini secara langsung via URL
    header("Location: ../views/ortu/login.php");
    exit;
}
?>