<?php
# @Author: Waris Agung Widodo - Modified for SIPANDU Design System
# @Filename: _home.php
?>

<!-- ============================================================
     HERO CAROUSEL
     ============================================================ -->
<div class="container-fluid px-3 px-md-4 mb-4">
    <div id="sipanduCarousel" class="carousel slide sipandu-hero" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#sipanduCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#sipanduCarousel" data-slide-to="1"></li>
            <li data-target="#sipanduCarousel" data-slide-to="2"></li>
            <li data-target="#sipanduCarousel" data-slide-to="3"></li>
        </ol>
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

        <!-- Caption overlay - di luar carousel-inner agar tidak ikut slide -->
        <div class="sipandu-hero-caption d-none d-md-block">
            <h2><?php echo htmlspecialchars($sysconf['library_name'] ?? ''); ?></h2>
            <?php if (!empty($sysconf['library_subname'])) : ?>
            <p><?php echo htmlspecialchars($sysconf['library_subname']); ?></p>
            <?php endif; ?>
        </div>
        <a class="carousel-control-prev" href="#sipanduCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#sipanduCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- ============================================================
     SEARCH FORM (floating overlap hero)
     ============================================================ -->
<div class="sipandu-search-wrapper">
    <div class="container">
        <div class="sipandu-search-box">
            <?php include '_search-form.php'; ?>
        </div>
    </div>
</div>

<!-- ============================================================
     HOME CONTENT
     ============================================================ -->
<div id="slims-home" class="mt-5">

    <!-- Topic Browser -->
    <section class="container mb-5">
        <div class="sipandu-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="sipandu-section-title"><?php echo __('Browse by Topic'); ?></h4>
                    <p class="sipandu-section-subtitle mb-0"><?php echo __('Select the topic you are interested in'); ?></p>
                </div>
            </div>
            <ul class="topic d-flex flex-wrap justify-content-center justify-content-md-start px-0 gap-3" style="gap:1rem;">
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=000-099&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/0-chemical.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">000 - 099</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('General Works'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=100-199&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/1-memory.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">100 - 199</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Philosophy'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=200-299&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/2-cross.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">200 - 299</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Religion'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=300-399&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/3-diploma.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">300 - 399</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Social Sciences'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=400-499&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/4-translation.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">400 - 499</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Language'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=500-599&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/5-math.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">500 - 599</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Natural Sciences'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=600-699&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/6-blackboard.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">600 - 699</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Applied Sciences'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=700-799&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/7-quill.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">700 - 799</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Art & Recreation'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=800-899&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/8-books.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">800 - 899</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('Literature'); ?></span>
                    </a>
                </li>
                <li class="d-flex justify-content-center align-items-center">
                    <a href="index.php?title=&author=&subject=&isbn=&publishyear=&location=900-999&gmd=&colltype=&search=search" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100 w-100 p-2">
                        <img src="<?php echo assets('images/9-return-to-the-past.png'); ?>" width="48" class="mb-2"/>
                        <span style="font-size:0.7rem;font-weight:600;">900 - 999</span>
                        <span style="font-size:0.6rem;color:#666;"><?php echo __('History & Geography'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <!-- Latest Collections -->
    <section class="container mb-5">
        <div class="sipandu-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="sipandu-section-title"><?php echo __('Latest Collections'); ?></h4>
                    <p class="sipandu-section-subtitle mb-0"><?php echo __('Newly added to our library'); ?></p>
                </div>
                <a href="index.php?search=search" class="btn btn-outline-primary btn-sm" style="font-size:0.8rem;font-weight:600;">
                    <?php echo __('See All'); ?> &rarr;
                </a>
            </div>
            <slims-collection url="index.php?p=api/biblio/latest"></slims-collection>
        </div>
    </section>

    <!-- Popular Collections -->
    <?php if ($sysconf['template']['classic_popular_collection']) : ?>
    <section class="container mb-5">
        <div class="sipandu-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="sipandu-section-title"><?php echo __('Popular Collections'); ?></h4>
                    <p class="sipandu-section-subtitle mb-0"><?php echo __('Most read by our members'); ?></p>
                </div>
            </div>
            <slims-collection url="index.php?p=api/biblio/popular"></slims-collection>
        </div>
    </section>
    <?php endif; ?>

    <!-- Top Readers -->
    <?php if ($sysconf['template']['classic_top_reader']) : ?>
    <section class="container mb-5">
        <div class="sipandu-card p-4">
            <div class="mb-4">
                <h4 class="sipandu-section-title"><?php echo __('Top Reader of the Year'); ?></h4>
                <p class="sipandu-section-subtitle mb-0"><?php echo __('Our most active readers this year'); ?></p>
            </div>
            <slims-group-member url="index.php?p=api/member/top"></slims-group-member>
        </div>
    </section>
    <?php endif; ?>

    <!-- Map -->
    <?php if ($sysconf['template']['classic_map']) : ?>
    <section class="container mb-5">
        <div class="sipandu-card overflow-hidden p-0">
            <div class="row no-gutters align-items-center">
                <div class="col-md-6">
                    <iframe class="w-100 d-block"
                            src="<?= $sysconf['template']['classic_map_link']; ?>"
                            height="380" frameborder="0" style="border:0;" allowfullscreen></iframe>
                </div>
                <div class="col-md-6 p-4 p-md-5">
                    <h4 class="sipandu-section-title mb-2"><?= $sysconf['library_name']; ?></h4>
                    <p style="color:#475569;font-size:0.875rem;line-height:1.7;"><?= $sysconf['template']['classic_map_desc']; ?></p>
                    <div class="d-flex flex-row gap-2 mt-3" style="gap:0.5rem;">
                        <?php if (!empty($sysconf['template']['classic_fb_link'])) : ?>
                        <a target="_blank" href="<?= $sysconf['template']['classic_fb_link'] ?>"
                           title="Facebook"
                           style="width:40px;height:40px;background:#3b5998;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($sysconf['template']['classic_twitter_link'])) : ?>
                        <a target="_blank" href="<?= $sysconf['template']['classic_twitter_link'] ?>"
                           title="Twitter/X"
                           style="width:40px;height:40px;background:#1da1f2;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($sysconf['template']['classic_youtube_link'])) : ?>
                        <a target="_blank" href="<?= $sysconf['template']['classic_youtube_link'] ?>"
                           title="YouTube"
                           style="width:40px;height:40px;background:#ff0000;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($sysconf['template']['classic_instagram_link'])) : ?>
                        <a target="_blank" href="<?= $sysconf['template']['classic_instagram_link'] ?>"
                           title="Instagram"
                           style="width:40px;height:40px;background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>
