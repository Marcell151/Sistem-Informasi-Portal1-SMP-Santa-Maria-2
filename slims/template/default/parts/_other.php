<?php
/**
 * @Created by: Waris Agung Widodo - Modified for SIPANDU Design System
 * @File name : _other.php
 */
?>

<div class="result-search pb-5">

    <?php
    // Include mini carousel di semua halaman kecuali show_detail
    if (!isset($_GET['p']) || $_GET['p'] !== 'show_detail') {
        include '_mini_carousel.php';
    }
    ?>

    <div class="container">

        <?php if (!isset($_GET['p']) || $_GET['p'] !== 'show_detail'): ?>
        <!-- Search bar kecil di bawah carousel -->
        <div class="sipandu-inner-search mb-4">
            <?php include '_search-form.php'; ?>
        </div>
        <?php endif; ?>

        <!-- Konten utama halaman -->
        <div class="sipandu-card p-4 p-md-5">
            <?php if (!isset($_GET['p']) || $_GET['p'] !== 'show_detail'): ?>
            <h3 class="sipandu-page-title mb-4"><?php echo htmlspecialchars($page_title ?? ''); ?></h3>
            <?php endif; ?>

            <?php
            if (isset($_GET['p']) && $_GET['p'] === 'librarian') {
                echo '<div class="d-flex flex-row flex-wrap">' . $main_content . '</div>';
            } else {
                echo $main_content;
            }
            ?>
        </div>

    </div>
</div>
