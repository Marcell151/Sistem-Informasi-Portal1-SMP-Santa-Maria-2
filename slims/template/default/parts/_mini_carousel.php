<?php
/**
 * Mini Hero Carousel - Digunakan di semua halaman selain Beranda
 * Ukuran lebih kecil (200px), sama slidenya, ada caption nama perpustakaan
 */

// Tentukan judul halaman untuk caption
$pageLabels = [
    'libinfo'    => __('Library Information'),
    'news'       => __('News'),
    'help'       => __('Help'),
    'librarian'  => __('Our Librarians'),
    'member'     => __('Member Area'),
    'show_detail'=> __('Collection Detail'),
];
$currentPage = $_GET['p'] ?? '';
$pageLabel   = $pageLabels[$currentPage] ?? $page_title ?? '';
?>

<!-- ============================================================
     MINI HERO CAROUSEL (halaman selain Beranda)
     ============================================================ -->
<div class="sipandu-mini-hero-wrap mb-4">
    <div id="miniCarousel" class="carousel slide sipandu-mini-hero" data-ride="carousel" data-interval="4000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo assets('images/slide1.png'); ?>" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="<?php echo assets('images/slide2.jpg'); ?>" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="<?php echo assets('images/slide3.jpg'); ?>" class="d-block w-100" alt="Slide 3">
            </div>
            <div class="carousel-item">
                <img src="<?php echo assets('images/slide4.jpg'); ?>" class="d-block w-100" alt="Slide 4">
            </div>
        </div>

        <!-- Kontrol Prev/Next -->
        <a class="carousel-control-prev" href="#miniCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#miniCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <!-- Caption overlay - di luar carousel-inner agar tidak ikut slide -->
        <div class="sipandu-mini-caption">
            <div class="mini-caption-breadcrumb">
                <span><?php echo htmlspecialchars($sysconf['library_name'] ?? ''); ?></span>
                <?php if ($pageLabel): ?>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="2.5">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="mini-caption-current"><?php echo htmlspecialchars($pageLabel); ?></span>
                <?php endif; ?>
            </div>
            <?php if ($pageLabel): ?>
            <h2 class="mini-caption-title"><?php echo htmlspecialchars($pageLabel); ?></h2>
            <?php endif; ?>
        </div>

        <!-- Indicator dots -->
        <ol class="carousel-indicators mini-indicators">
            <li data-target="#miniCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#miniCarousel" data-slide-to="1"></li>
            <li data-target="#miniCarousel" data-slide-to="2"></li>
            <li data-target="#miniCarousel" data-slide-to="3"></li>
        </ol>
    </div>
</div>
