<?php
# @Author: Waris Agung Widodo <user> - Modified for SIPANDU Design System
# @Filename: index_template.inc.php

$imagesDisk = \SLiMS\Filesystems\Storage::images();

// setup list view
$_SESSION['LIST_VIEW'] = $_POST['view'] ?? $_SESSION['LIST_VIEW'] ?? 'list';

// Load library fungsi bawaan
include_once 'classic.php';

// 1. LOAD HEADER (Berisi <head> dan awal <body>)
include 'parts/header.php'; 
?>

<style>
    :root { --primary-navy: #000080; --bg-slate: #F8FAFC; --border-slate: #E2E8F0; }
    .sipandu-wrapper { display: flex; min-height: 100vh; }
    .sipandu-sidebar { width: 260px; background: #ffffff; border-right: 1px solid #E2E8F0; position: fixed; height: 100vh; z-index: 1000; display: flex; flex-direction: column; box-shadow: 2px 0 8px rgba(0,0,0,0.06); }
    .sipandu-content { flex: 1; margin-left: 260px; padding: 2rem; width: calc(100% - 260px); }
    .brand-box { padding: 1.5rem; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 12px; }
    .nav-item-sipandu { padding: 0.75rem 1rem; margin: 0.2rem 1rem; border-radius: 0.5rem; color: #475569; display: block; text-decoration: none !important; font-weight: 500; transition: 0.2s; }
    .nav-item-sipandu:hover { background: #EEF2FF; color: #000080; }
    .nav-item-sipandu.active { background: #000080; color: white !important; font-weight: 600; }
    /* Sembunyikan navigasi asli */
    header.s-header, .navbar, .c-header, .mask { display: none !important; }
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-navy: #000080;
        --bg-slate: #F8FAFC;
        --border-slate: #E2E8F0;
        --text-main: #1E293B;
    }
    
    body { 
        font-family: 'Inter', sans-serif !important; 
        background-color: var(--bg-slate) !important;
        color: var(--text-main) !important;
        margin: 0; padding: 0;
    }

    /* Layout Wrapper */
    .sipandu-wrapper { display: flex; min-height: 100vh; }

    /* Sidebar Fixed w-64 */
    .sipandu-sidebar {
        width: 256px;
        background: #ffffff;
        border-right: 1px solid #E2E8F0;
        position: fixed;
        height: 100vh;
        display: flex;
        flex-direction: column;
        z-index: 1000;
        box-shadow: 2px 0 8px rgba(0,0,0,0.06);
    }

    /* Main Content Area */
    .sipandu-content {
        flex: 1;
        margin-left: 256px; /* Memberi ruang untuk sidebar */
        padding: 2rem;
        background: var(--bg-slate);
    }

    /* Branding Logo Box */
    .brand-box {
        padding: 1.25rem 1rem 1.25rem 1.25rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Logo container - menampilkan gambar atau inisial */
    .brand-icon-box {
        width: auto;
        height: auto;
        min-width: 50px;
        min-height: 50px;
        max-width: 75px; /* Medium size */
        max-height: 75px;
        border-radius: 0.75rem;
        /* overflow: hidden; */ /* Dihapus agar tidak memotong logo jika ada bayangan/overflow tipis */
        flex-shrink: 0;
        background: rgba(255,255,255,0.0);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px; /* Memberikan ruang atas-bawah agar tidak kepotong */
    }

    .brand-icon-box img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%; /* Mengikuti padding box */
        object-fit: contain;
        display: block;
    }


    /* Fallback inisial jika tidak ada logo */
    .brand-initial {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 800;
        font-family: 'Inter', sans-serif;
        line-height: 1;
    }

    .logo-container {
        background: var(--primary-navy);
        width: 40px; height: 40px;
        border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        color: white;
    }

    /* Sidebar Nav Item */
    .nav-item-sipandu {
        padding: 0.75rem 1rem;
        margin: 0.25rem 1rem;
        border-radius: 0.5rem;
        color: #475569;
        text-decoration: none !important;
        display: flex; align-items: center;
        transition: all 0.2s;
    }
    .nav-item-sipandu:hover {
        background: #EEF2FF;
        color: #000080;
    }
    .nav-item-sipandu.active {
        background: #000080;
        color: white !important;
        font-weight: 600;
    }

    /* Hide Original SLiMS Header Nav if necessary */
    header.s-header { display: none !important; } 


    /* ===== LANGUAGE DROPDOWN ===== */
    .sipandu-lang-dropdown {
        position: relative;
    }

    .sipandu-lang-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.6rem 0.875rem;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 0.5rem;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        transition: all 0.2s;
    }

    .sipandu-lang-btn:hover {
        background: #F1F5F9;
        border-color: #000080;
        color: #000080;
    }

    .sipandu-lang-btn .lang-label {
        flex: 1;
        text-align: left;
        letter-spacing: 0.03em;
    }

    .lang-chevron {
        transition: transform 0.2s;
        color: #94A3B8;
        flex-shrink: 0;
    }

    .sipandu-lang-dropdown.open .lang-chevron {
        transform: rotate(180deg);
    }

    .sipandu-lang-dropdown.open .sipandu-lang-btn {
        border-color: #000080;
        color: #000080;
        background: #EEF2FF;
    }

    .sipandu-lang-menu {
        display: none;
        position: absolute;
        bottom: calc(100% + 0.5rem);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1), 0 4px 8px rgba(0,0,0,0.06);
        z-index: 9999;
        overflow: hidden;
        padding: 0.375rem;
    }

    .sipandu-lang-dropdown.open .sipandu-lang-menu {
        display: block;
        animation: langMenuIn 0.15s ease;
    }

    @keyframes langMenuIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .lang-menu-header {
        font-size: 0.65rem;
        font-weight: 700;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.4rem 0.6rem 0.5rem;
    }

    .lang-menu-item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.5rem 0.625rem;
        border-radius: 0.5rem;
        text-decoration: none !important;
        font-size: 0.8rem;
        font-weight: 500;
        color: #475569;
        transition: all 0.15s;
        cursor: pointer;
    }

    .lang-menu-item:hover {
        background: #F1F5F9;
        color: #000080;
        text-decoration: none !important;
    }

    .lang-menu-item.active {
        background: #EEF2FF;
        color: #000080;
        font-weight: 700;
    }

    .lang-item-name {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* ===== END LANGUAGE DROPDOWN ===== */
    /* Targetkan tombol login bawaan SLiMS agar menjadi gaya SIPANDU */
/* Biasanya SLiMS menggunakan button[name="login"] atau .s-btn-primary */

button[name="login"], 
.login-form button[type="submit"],
.btn-primary {
    display: block;
    width: 100% !important;
    height: 3rem !important; /* h-12 */
    background-color: #000080 !important; /* Navy Blue */
    border-radius: 0.75rem !important; /* rounded-xl */
    font-weight: 800 !important;
    color: #FFFFFF !important;
    border: none !important;
    text-transform: uppercase;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

button[name="login"]:hover {
    background-color: #000066 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* ===== MEMBER AREA REDESIGN ===== */

/* Layout utama member area */
.member-area .container > .sipandu-card,
.member-area .container > div {
    padding: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

/* Wrapper seluruh konten member (tabel + profile) */
.member-area .container table,
.member-area .container > .sipandu-card table {
    width: 100%;
}

/* Profile card kiri */
.member-area table > tbody > tr > td:first-child,
.member-area .member-profile-box {
    vertical-align: top;
}

/* Photo profile */
.member-area img[src*="photo"],
.member-area img[src*="persons"],
.member-area img[alt="photo"],
.member-area .img-thumbnail {
    width: 110px !important;
    height: 110px !important;
    object-fit: cover !important;
    border-radius: 50% !important;
    border: 4px solid #E2E8F0 !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    display: block !important;
    margin: 0 auto 12px auto !important;
}

/* Nama member */
.member-area h2, .member-area .member-name {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: #1E293B !important;
    margin-bottom: 4px !important;
}

/* Badge tipe member (Kepala Sekolah, Guru, dll) */
.member-area .label, .member-area .badge,
.member-area small.text-muted,
.member-area .member-type {
    background: #EEF2FF !important;
    color: #4F46E5 !important;
    border-radius: 999px !important;
    padding: 2px 10px !important;
    font-size: 0.72rem !important;
    font-weight: 600 !important;
    display: inline-block !important;
    margin-bottom: 8px !important;
}

/* Tombol View Library Card */
.member-area a[href*="librarycard"],
.member-area a[href*="library_card"],
.member-area input[value*="LIBRARY"],
.member-area .btn-view-card,
.member-area a.btn-primary {
    display: block !important;
    width: 100% !important;
    background: #000080 !important;
    color: white !important;
    text-align: center !important;
    border-radius: 8px !important;
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    margin-bottom: 8px !important;
    border: none !important;
    letter-spacing: 0.5px !important;
}

/* Tombol Logout */
.member-area a[href*="logout"],
.member-area a.btn-danger,
.member-area .btn-logout {
    display: block !important;
    width: 100% !important;
    background: #DC2626 !important;
    color: white !important;
    text-align: center !important;
    border-radius: 8px !important;
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    border: none !important;
    letter-spacing: 0.5px !important;
}

/* Tab navigasi (Current Loan, Bookmark, dll) */
.member-area .nav-tabs {
    border-bottom: 2px solid #E2E8F0 !important;
    margin-bottom: 1.25rem !important;
    gap: 4px !important;
    display: flex !important;
    flex-wrap: wrap !important;
}
.member-area .nav-tabs li a,
.member-area .nav-tabs .nav-link {
    border: none !important;
    border-bottom: 3px solid transparent !important;
    border-radius: 0 !important;
    padding: 8px 14px !important;
    font-size: 0.8rem !important;
    font-weight: 600 !important;
    color: #64748B !important;
    background: transparent !important;
    text-decoration: none !important;
    transition: all 0.15s !important;
}
.member-area .nav-tabs li.active a,
.member-area .nav-tabs .nav-link.active,
.member-area .nav-tabs li a:hover {
    color: #000080 !important;
    border-bottom-color: #000080 !important;
}

/* Tab content area */
.member-area .tab-content {
    padding: 0 !important;
}

/* Judul seksi dalam tab */
.member-area .tab-pane h3,
.member-area .tab-pane h4,
.member-area h3, .member-area h4 {
    font-size: 1rem !important;
    font-weight: 700 !important;
    color: #1E293B !important;
    margin-bottom: 1rem !important;
    padding-bottom: 8px !important;
    border-left: 4px solid #000080 !important;
    padding-left: 10px !important;
}

/* Tabel data pinjaman */
.member-area table.table,
.member-area .tab-pane table {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 0.82rem !important;
}
.member-area table.table th {
    background: #F1F5F9 !important;
    color: #475569 !important;
    font-weight: 600 !important;
    padding: 10px 12px !important;
    border-bottom: 2px solid #E2E8F0 !important;
    text-transform: uppercase !important;
    font-size: 0.72rem !important;
    letter-spacing: 0.5px !important;
}
.member-area table.table td {
    padding: 10px 12px !important;
    border-bottom: 1px solid #F1F5F9 !important;
    color: #334155 !important;
    vertical-align: middle !important;
}
.member-area table.table tr:hover td {
    background: #F8FAFC !important;
}

/* No data state */
.member-area .alert,
.member-area .no-data,
.member-area p:empty + p {
    background: #F8FAFC !important;
    border: 1px dashed #CBD5E1 !important;
    border-radius: 10px !important;
    padding: 2rem !important;
    text-align: center !important;
    color: #94A3B8 !important;
    font-size: 0.85rem !important;
}

/* Tombol download */
.member-area a.btn-default,
.member-area a[href*="download"],
.member-area .btn-sm {
    background: #F1F5F9 !important;
    color: #475569 !important;
    border-radius: 6px !important;
    padding: 5px 12px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    border: 1px solid #E2E8F0 !important;
    text-decoration: none !important;
    display: inline-block !important;
    margin: 2px !important;
}
.member-area a.btn-default:hover {
    background: #E2E8F0 !important;
}

/* Panel profile kiri - beri card style */
.member-area > .container > .sipandu-card > table > tbody > tr > td:first-child {
    background: #ffffff !important;
    border-radius: 12px !important;
    padding: 24px 16px !important;
    border: 1px solid #E2E8F0 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
    width: 180px !important;
    vertical-align: top !important;
    text-align: center !important;
}

/* Panel konten kanan */
.member-area > .container > .sipandu-card > table > tbody > tr > td:last-child {
    padding-left: 24px !important;
    vertical-align: top !important;
}

/* Responsif mobile */
@media (max-width: 768px) {
    .member-area > .container > .sipandu-card > table,
    .member-area > .container > .sipandu-card > table tbody,
    .member-area > .container > .sipandu-card > table tr,
    .member-area > .container > .sipandu-card > table td {
        display: block !important;
        width: 100% !important;
    }
    .member-area > .container > .sipandu-card > table > tbody > tr > td:first-child {
        margin-bottom: 16px !important;
    }
}

/* Welcome text */
.member-area p.text-muted,
.member-area .welcome-text {
    font-size: 0.82rem !important;
    color: #64748B !important;
    line-height: 1.6 !important;
    margin-bottom: 16px !important;
}

/* ===== END MEMBER AREA ===== */
</style>

<div class="sipandu-wrapper">
    <aside class="sipandu-sidebar">
        <div class="brand-box">
            <div class="brand-icon-box">
                <?php
                // Deteksi logo dari berbagai setting SLiMS9
                $logoDisplayed = false;

                // Cara 1: logo_image — setting dari Admin > System Config (SLiMS lama)
                if (!$logoDisplayed && !empty($sysconf['logo_image'])) {
                    $lp = 'default/' . $sysconf['logo_image'];
                    try {
                        if ($imagesDisk->isExists($lp)) {
                            echo '<img src="' . SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $lp . '&width=150" alt="Logo">';
                            $logoDisplayed = true;
                        }
                    } catch(Exception $e) {}
                }

                // Cara 2: library_logo — setting dari Admin > System Config (SLiMS9 baru)
                if (!$logoDisplayed && !empty($sysconf['library_logo'])) {
                    // Coba path dengan prefix 'default/'
                    $lp = 'default/' . $sysconf['library_logo'];
                    try {
                        if (method_exists($imagesDisk, 'isExists') && $imagesDisk->isExists($lp)) {
                            echo '<img src="' . SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $lp . '&width=150" alt="Logo">';
                            $logoDisplayed = true;
                        }
                    } catch(Exception $e) {}

                    // Coba path langsung tanpa prefix
                    if (!$logoDisplayed) {
                        $lp2 = $sysconf['library_logo'];
                        try {
                            if (method_exists($imagesDisk, 'isExists') && $imagesDisk->isExists($lp2)) {
                                echo '<img src="' . SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $lp2 . '&width=150" alt="Logo">';
                                $logoDisplayed = true;
                            }
                        } catch(Exception $e) {}
                    }
                }

                // Cara 3: logo.png di assets template
                if (!$logoDisplayed && file_exists(CURRENT_TEMPLATE_DIR . 'assets/images/logo.png')) {
                    echo '<img src="' . assets('images/logo.png') . '" alt="Logo">';
                    $logoDisplayed = true;
                }

                // Fallback: kotak navy dengan inisial huruf pertama
                if (!$logoDisplayed) {
                    $initial = strtoupper(mb_substr($sysconf['library_name'] ?? 'L', 0, 1));
                    echo '<span class="brand-initial">' . htmlspecialchars($initial) . '</span>';
                }
                ?>
            </div>
            <div>
                <div style="font-weight: 800; color: #000080; font-size: 1.1rem; line-height: 1;">SLiMS</div>
                <div style="font-size: 0.6rem; color: #64748b; font-weight: 700; text-transform: uppercase;">
                    <?php echo $sysconf['library_name'] ?? 'SMPK SANTA MARIA 2'; ?>
                </div>
            </div>
        </div>

        <nav class="mt-3 flex-1">
            <a href="index.php" class="nav-item-sipandu <?php echo !isset($_GET['p']) ? 'active' : ''; ?>"><?php echo __('Home'); ?></a>
            <a href="index.php?p=libinfo" class="nav-item-sipandu <?php echo (isset($_GET['p']) && $_GET['p']=='libinfo') ? 'active' : ''; ?>"><?php echo __('Information'); ?></a>
            <a href="index.php?p=news" class="nav-item-sipandu <?php echo (isset($_GET['p']) && $_GET['p']=='news') ? 'active' : ''; ?>"><?php echo __('News'); ?></a>
            <a href="index.php?p=help" class="nav-item-sipandu <?php echo (isset($_GET['p']) && $_GET['p']=='help') ? 'active' : ''; ?>"><?php echo __('Help'); ?></a>
            <a href="index.php?p=librarian" class="nav-item-sipandu <?php echo (isset($_GET['p']) && $_GET['p']=='librarian') ? 'active' : ''; ?>"><?php echo __('Librarian'); ?></a>
            <a href="index.php?p=member" class="nav-item-sipandu <?php echo (isset($_GET['p']) && $_GET['p']=='member') ? 'active' : ''; ?>"><?php echo __('Member Area'); ?></a>
        </nav>
        
        <div class="p-4" style="border-top: 1px solid #E2E8F0;">
            <?php
            // 6 bahasa pilihan
            $sipandu_langs = [
                'en_US' => ['name' => 'English (US)', 'flag' => 'us', 'short' => 'EN-US'],
                'en_GB' => ['name' => 'English (UK)', 'flag' => 'gb', 'short' => 'EN-GB'],
                'id_ID' => ['name' => 'Indonesia',    'flag' => 'id', 'short' => 'ID'],
                'ko_KR' => ['name' => "한국어",      'flag' => 'kr', 'short' => 'KO'],
                'ja_JP' => ['name' => "日本語",      'flag' => 'jp', 'short' => 'JA'],
                'zh_CN' => ['name' => "中文",        'flag' => 'cn', 'short' => 'ZH'],
            ];
            $sipandu_cur_lang = isset($_COOKIE['select_lang']) ? $_COOKIE['select_lang'] : ($sysconf['default_lang'] ?? 'id_ID');
            $sipandu_cur     = $sipandu_langs[$sipandu_cur_lang] ?? $sipandu_langs['id_ID'];
            ?>
            <div class="sipandu-lang-dropdown" id="sipdLangDropdown">
                <button class="sipandu-lang-btn" onclick="toggleLangMenu(event)" type="button">
                    <span class="flag-icon flag-icon-<?= htmlspecialchars($sipandu_cur['flag']) ?>" style="border-radius:2px;width:18px;height:13px;display:inline-block;"></span>
                    <span class="lang-label"><?= htmlspecialchars($sipandu_cur['short']) ?></span>
                    <svg class="lang-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="sipandu-lang-menu" id="sipdLangMenu">
                    <div class="lang-menu-header">Pilih Bahasa / Language</div>
                    <?php foreach ($sipandu_langs as $lcode => $ldata): ?>
                    <a href="index.php?select_lang=<?= htmlspecialchars($lcode) ?>"
                       class="lang-menu-item <?= ($lcode === $sipandu_cur_lang) ? 'active' : '' ?>">
                        <span class="flag-icon flag-icon-<?= htmlspecialchars($ldata['flag']) ?>" style="border-radius:2px;width:18px;height:13px;display:inline-block;flex-shrink:0;"></span>
                        <span class="lang-item-name"><?= htmlspecialchars($ldata['name']) ?></span>
                        <?php if ($lcode === $sipandu_cur_lang): ?>
                        <svg style="margin-left:auto;flex-shrink:0;" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#000080" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <?php endif; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </aside>

    <div class="sipandu-content">
        <?php
        // LOGIKA PEMANGGILAN KONTEN ASLI SLIMS
        if (isset($_GET['p']) || isset($_GET['search'])) {
            if (isset($_GET['search'])) {
                include 'parts/_result-search.php';
            } else {
                if ($_GET['p'] == 'member') {
                    include 'parts/_member.php';
                } else {
                    include 'parts/_other.php';
                }
            }
        } else {
            include 'parts/_home.php';
        }
        ?>
    </div>
</div>

<script>
function toggleLangMenu(e) {
    e.stopPropagation();
    var dd = document.getElementById('sipdLangDropdown');
    var isOpen = dd.classList.contains('open');
    document.querySelectorAll('.sipandu-lang-dropdown.open').forEach(function(el) {
        el.classList.remove('open');
    });
    if (!isOpen) {
        dd.classList.add('open');
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#sipdLangDropdown')) {
        var dd = document.getElementById('sipdLangDropdown');
        if (dd) dd.classList.remove('open');
    }
});
</script>

<?php include 'parts/footer.php';
?>