<?php
/**
 * @Created by: Waris Agung Widodo - Modified for SIPANDU Design System
 * @File name : _member.php
 */
?>

<?php if ($is_login) : ?>

    <div class="member-area pb-5">
        <?php include '_mini_carousel.php'; ?>

        <div class="container">
            <div class="sipandu-card p-4 p-md-5">
                <?php echo $main_content; ?>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="result-search page-member-area pb-5">
        <?php include '_mini_carousel.php'; ?>

        <div class="container">
            <!-- Search bar -->
            <div class="sipandu-inner-search mb-4">
                <?php include '_search-form.php'; ?>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="sipandu-card p-4">
                        <?php echo $main_content; ?>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>

<?php endif; ?>
