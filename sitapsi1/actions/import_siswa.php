<?php

session_start();
require_once '../config/database.php';

// Validasi Keamanan
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'AdminPusat' && $_SESSION['role'] !== 'Admin')) {
    die("Akses ditolak!");
}

if (isset($_POST) && isset($_FILES['file_excel'])) {
    
    // 1. CEK ERROR UPLOAD DASAR
    if ($_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error_message'] = "Terjadi kesalahan sistem saat mengunggah file.";
        header("Location: ../views/admin/data_siswa.php");
        exit;
    }

    // 2. VALIDASI EKSTENSI FILE
    $fileName = $_FILES['file_excel']['name'];
    $fileTmpName = $_FILES['file_excel']['tmp_name'];
    
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['csv']; 

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error_message'] = "Format file ditolak! Anda mengunggah file .$fileExtension. Silakan gunakan template CSV yang disediakan.";
        header("Location: ../views/admin/data_siswa.php");
        exit;
    }

    // 3. PROSES BACA FILE
    $handle = fopen($fileTmpName, "r");
    if ($handle !== FALSE) {
        
        $baris_pertama = fgets($handle);
        $delimiter = (strpos($baris_pertama, ';') !== false) ? ';' : ',';
        rewind($handle); 

        $headers = fgetcsv($handle, 10000, $delimiter);
        
        if (isset($headers[0])) {
            $headers[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $headers[0]);
        }
        
        if (empty($headers) || count($headers) < 2) {
            $_SESSION['error_message'] = "Gagal! File CSV kosong atau format kolom berantakan.";
            header("Location: ../views/admin/data_siswa.php");
            exit;
        }

        // Mapping Header
        $map = [];
        foreach ($headers as $index => $col_name) {
            $col_name = strtolower(trim($col_name));
            if (strpos($col_name, 'induk') !== false) $map['no_induk'] = $index;
            elseif (strpos($col_name, 'nama peserta') !== false || strpos($col_name, 'nama siswa') !== false || $col_name == 'nama') $map['nama'] = $index;
            elseif ($col_name == 'l/p' || strpos($col_name, 'kelamin') !== false) $map['jk'] = $index;
            elseif (strpos($col_name, 'tempat') !== false) $map['kota'] = $index;
            elseif (strpos($col_name, 'tanggal lahir') !== false || strpos($col_name, 'tgl lahir') !== false) $map['tgl_lahir'] = $index;
            elseif (strpos($col_name, 'alamat') !== false) $map['alamat'] = $index;
            elseif (strpos($col_name, 'ayah') !== false && strpos($col_name, 'pekerjaan') === false) $map['nama_ayah'] = $index;
            elseif (strpos($col_name, 'pekerjaan ayah') !== false) $map['pekerjaan_ayah'] = $index;
            elseif (strpos($col_name, 'ibu') !== false && strpos($col_name, 'pekerjaan') === false) $map['nama_ibu'] = $index;
            elseif (strpos($col_name, 'pekerjaan ibu') !== false) $map['pekerjaan_ibu'] = $index;
            elseif (strpos($col_name, 'hp') !== false && strpos($col_name, 'ortu') === false) $map['no_hp'] = $index;
            elseif (strpos($col_name, 'username') !== false || strpos($col_name, 'wali') !== false || strpos($col_name, 'nik') !== false) $map['username_wali'] = $index; 
            elseif (strpos($col_name, 'kelas') !== false) $map['kelas'] = $index;
        }

        if (!isset($map['no_induk']) || !isset($map['nama'])) {
            $_SESSION['error_message'] = "Gagal! Kolom 'No Induk' dan 'Nama' wajib ada di dalam file.";
            header("Location: ../views/admin/data_siswa.php");
            exit;
        }

        // 4. KONEKSI TERPUSAT & INSERT DATABASE
        try {
            $pdo = getDBConnection();
            $pdo->beginTransaction(); 
            
            $stmt_tahun = $pdo->query("SELECT id_tahun FROM tb_tahun_ajaran WHERE status = 'Aktif' LIMIT 1");
            $tahun_aktif = $stmt_tahun->fetch(PDO::FETCH_ASSOC);
            $id_tahun = $tahun_aktif ? $tahun_aktif['id_tahun'] : null;

            if (!$id_tahun) {
                $_SESSION['error_message'] = "Gagal! Tidak ada Tahun Ajaran yang diatur sebagai Aktif.";
                header("Location: ../views/admin/data_siswa.php");
                exit;
            }

            $sukses = 0;
            while (($row = fgetcsv($handle, 10000, $delimiter)) !== FALSE) {
                if (empty(array_filter($row))) continue; 

                $no_induk = isset($map['no_induk']) && isset($row[$map['no_induk']]) ? trim($row[$map['no_induk']]) : '';
                $nama     = isset($map['nama']) && isset($row[$map['nama']]) ? trim($row[$map['nama']]) : '';
                
                if (empty($no_induk) || empty($nama)) continue;

                $jk             = isset($map['jk']) && isset($row[$map['jk']]) && trim($row[$map['jk']]) != '' ? trim($row[$map['jk']]) : 'L';
                $kota           = isset($map['kota']) && isset($row[$map['kota']]) ? trim($row[$map['kota']]) : null;
                $tgl_lahir      = isset($map['tgl_lahir']) && isset($row[$map['tgl_lahir']]) && trim($row[$map['tgl_lahir']]) != '' ? trim($row[$map['tgl_lahir']]) : null;
                $alamat         = isset($map['alamat']) && isset($row[$map['alamat']]) ? trim($row[$map['alamat']]) : null;
                $nama_ayah      = isset($map['nama_ayah']) && isset($row[$map['nama_ayah']]) ? trim($row[$map['nama_ayah']]) : null;
                $pekerjaan_ayah = isset($map['pekerjaan_ayah']) && isset($row[$map['pekerjaan_ayah']]) ? trim($row[$map['pekerjaan_ayah']]) : null;
                $nama_ibu       = isset($map['nama_ibu']) && isset($row[$map['nama_ibu']]) ? trim($row[$map['nama_ibu']]) : null;
                $pekerjaan_ibu  = isset($map['pekerjaan_ibu']) && isset($row[$map['pekerjaan_ibu']]) ? trim($row[$map['pekerjaan_ibu']]) : null;
                $no_hp          = isset($map['no_hp']) && isset($row[$map['no_hp']]) ? trim($row[$map['no_hp']]) : null;
                $username_xls   = isset($map['username_wali']) && isset($row[$map['username_wali']]) ? trim($row[$map['username_wali']]) : null; 
                $nama_kelas_xls = isset($map['kelas']) && isset($row[$map['kelas']]) ? trim($row[$map['kelas']]) : null;

                // LOGIKA AUTO-CREATE AKUN ORANG TUA
                $id_ortu = null;
                
                // Cek 1: Apakah Username sudah ada di Excel & bukan karakter kosong/strip?
                $clean_username_xls = trim(str_replace(['-','.', ' '], '', $username_xls));
                if (!empty($clean_username_xls)) {
                    $stmt_cek_user = $pdo->prepare("SELECT id_ortu FROM tb_orang_tua WHERE username = ? LIMIT 1");
                    $stmt_cek_user->execute([$username_xls]);
                    $ortu_db = $stmt_cek_user->fetch(PDO::FETCH_ASSOC);
                    if ($ortu_db) $id_ortu = $ortu_db['id_ortu'];
                }

                // Cek 2: Jika belum ketemu, cek berdasarkan No HP
                $clean_hp = trim(str_replace(['-','.', ' '], '', $no_hp));
                if (!$id_ortu && !empty($clean_hp)) {
                    $stmt_cek_hp = $pdo->prepare("SELECT id_ortu FROM tb_orang_tua WHERE no_hp_ortu = ? LIMIT 1");
                    $stmt_cek_hp->execute([$no_hp]);
                    $ortu_hp = $stmt_cek_hp->fetch(PDO::FETCH_ASSOC);
                    
                    if ($ortu_hp) {
                        $id_ortu = $ortu_hp['id_ortu']; 
                    } else {
                        // [FIX KETAT]: Bersihkan nama dari strip (-), titik (.), atau spasi gaib
                        $clean_ayah = trim(str_replace(['-','.', ' '], '', $nama_ayah));
                        $clean_ibu  = trim(str_replace(['-','.', ' '], '', $nama_ibu));

                        // HANYA buat akun jika $clean_ayah ATAU $clean_ibu punya huruf (tidak kosong)
                        if (!empty($clean_ayah) || !empty($clean_ibu)) {
                            
                            $pass_default = md5('123456'); 
                            $nama_wali = !empty($clean_ayah) ? $nama_ayah : $nama_ibu;
                            
                            $stmt_ins_ortu = $pdo->prepare("
                                INSERT INTO tb_orang_tua (password, nama_wali, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_hp_ortu, alamat)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                            ");
                            $stmt_ins_ortu->execute([$pass_default, $nama_wali, $nama_ayah, $pekerjaan_ayah, $nama_ibu, $pekerjaan_ibu, $no_hp, $alamat]);
                            $id_ortu = $pdo->lastInsertId();
                            
                            // Generate Username
                            $kata_pertama = explode(' ', trim($nama_wali))[0];
                            $nama_bersih = preg_replace('/[^a-z]/', '', strtolower($kata_pertama));
                            if(empty($nama_bersih)) $nama_bersih = 'ortu';
                            
                            $username_baru = $nama_bersih . $id_ortu;
                            $pdo->prepare("UPDATE tb_orang_tua SET username = ? WHERE id_ortu = ?")->execute([$username_baru, $id_ortu]);
                        }
                        // Jika nama benar-benar kosong/cuma strip, $id_ortu tetap null
                    }
                }

                // A. Simpan ke tb_siswa
                $stmt = $pdo->prepare("
                    INSERT INTO tb_siswa 
                    (no_induk, nama_siswa, jenis_kelamin, kota, tanggal_lahir, alamat, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_hp_ortu, id_ortu, status_aktif) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Aktif')
                    ON DUPLICATE KEY UPDATE 
                    nama_siswa = VALUES(nama_siswa), jenis_kelamin = VALUES(jenis_kelamin), kota = VALUES(kota),
                    tanggal_lahir = VALUES(tanggal_lahir), alamat = VALUES(alamat), nama_ayah = VALUES(nama_ayah),
                    pekerjaan_ayah = VALUES(pekerjaan_ayah), nama_ibu = VALUES(nama_ibu), pekerjaan_ibu = VALUES(pekerjaan_ibu),
                    no_hp_ortu = VALUES(no_hp_ortu), id_ortu = VALUES(id_ortu), status_aktif = 'Aktif'
                ");
                $stmt->execute([$no_induk, $nama, $jk, $kota, $tgl_lahir, $alamat, $nama_ayah, $pekerjaan_ayah, $nama_ibu, $pekerjaan_ibu, $no_hp, $id_ortu]);

                // B. Simpan ke tb_anggota_kelas
                if (!empty($nama_kelas_xls)) {
                    $stmt_kelas = $pdo->prepare("SELECT id_kelas FROM tb_kelas WHERE nama_kelas = ? LIMIT 1");
                    $stmt_kelas->execute([$nama_kelas_xls]);
                    $kelas_db = $stmt_kelas->fetch(PDO::FETCH_ASSOC);

                    if ($kelas_db) {
                        $id_kelas = $kelas_db['id_kelas'];
                        $stmt_cek = $pdo->prepare("SELECT id_anggota FROM tb_anggota_kelas WHERE no_induk = ? AND id_tahun = ?");
                        $stmt_cek->execute([$no_induk, $id_tahun]);
                        
                        if ($stmt_cek->rowCount() == 0) {
                            $stmt_ins_kls = $pdo->prepare("INSERT INTO tb_anggota_kelas (no_induk, id_kelas, id_tahun) VALUES (?, ?, ?)");
                            $stmt_ins_kls->execute([$no_induk, $id_kelas, $id_tahun]);
                        } else {
                            $stmt_upd_kls = $pdo->prepare("UPDATE tb_anggota_kelas SET id_kelas = ? WHERE no_induk = ? AND id_tahun = ?");
                            $stmt_upd_kls->execute([$id_kelas, $no_induk, $id_tahun]);
                        }
                    }
                }
                $sukses++;
            }

            $pdo->commit(); 
            fclose($handle);
            
            $_SESSION['success_message'] = "Berhasil memproses $sukses data siswa & sinkronisasi akun Wali Murid!";
            header("Location: ../views/admin/data_siswa.php");
            exit;

        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack(); 
            }
            $_SESSION['error_message'] = "Terjadi kesalahan sistem database: " . $e->getMessage();
            header("Location: ../views/admin/data_siswa.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Gagal membuka file. Pastikan file tidak sedang dibuka di Excel.";
        header("Location: ../views/admin/data_siswa.php");
        exit;
    }
} else {
    header("Location: ../views/admin/data_siswa.php");
    exit;
}
?>