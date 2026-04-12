<?php
# @Author: Waris Agung Widodo - Modified for SIPANDU Design System
# @Filename: _navbar.php

$main_menus = [
  'home' => [
    'text' => __('Home'),
    'url' => 'index.php'
  ],
  'libinfo' => [
    'text' => __('Information'),
    'url' => 'index.php?p=libinfo'
  ],
  'news' => [
    'text' => __('News'),
    'url' => 'index.php?p=news'
  ],
  'help' => [
    'text' => __('Help'),
    'url' => 'index.php?p=help'
  ],
  'librarian' => [
    'text' => __('Librarian'),
    'url' => 'index.php?p=librarian'
  ]
];
?>
<nav class="navbar navbar-expand-lg sipandu-navbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
            <div class="brand-icon">
                <?php
                if(isset($sysconf['logo_image']) && $sysconf['logo_image'] != '' && $imagesDisk->isExists($path = 'default/'.$sysconf['logo_image'])){
                    echo '<img src="'.SWB . 'lib/minigalnano/createthumb.php?filename=images/' . $path.'&width=150" alt="logo" style="max-height: 55px; width: auto; object-fit: contain; padding: 2px;">';
                } elseif (file_exists(__DIR__ . '/../assets/images/logo.png')) {
                    echo '<img src="'.assets('images/logo.png').'" alt="logo" style="max-height: 55px; width: auto; object-fit: contain; padding: 2px;">';
                } else { ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6L23 9 12 3zm6 10.91L12 17 6 13.91V9.09L12 7l6 2.09v4.82z"/>
                    </svg>
                <?php } ?>
            </div>
            <div class="brand-text">
                <h1><?php echo $sysconf['library_name']; ?></h1>
                <?php if ($sysconf['template']['classic_library_subname']) : ?>
                <p><?php echo $sysconf['library_subname']; ?></p>
                <?php endif; ?>
            </div>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Nav links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <?php
              foreach ($main_menus as $key => $main_menu) {
                $active = '';
                if (isset($_GET['p'])) {
                  if ($key === $_GET['p']) $active = 'active';
                } elseif ($key === 'home') {
                  $active = 'active';
                }
                $menu_str = <<<HTML
<li class="nav-item {$active}">
    <a class="nav-link" href="{$main_menu['url']}">{$main_menu['text']}</a>
</li>
HTML;
                echo $menu_str;
              }
              ?>
            </ul>

            <!-- Right side -->
            <ul class="navbar-nav ml-auto align-items-center">
              <?php
              $menu_member_active = isset($_GET['p']) && $_GET['p'] === 'member' ? 'active' : '';
              if ($is_login) {
                ?>
                  <li class="nav-item <?= $menu_member_active; ?>">
                      <a class="nav-link" href="index.php?p=member&sec=title_basket">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 01-8 0"></path></svg>
                        <?php $count_basket = count($_SESSION['m_mark_biblio']); ?>
                          <sup id="count-basket"><?php echo $count_basket; ?></sup>
                      </a>
                  </li>
                  <li class="nav-item dropdown <?= $menu_member_active; ?>">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="false">
                          <img style="width:28px;height:28px;border-radius:50%;border:2px solid #E2E8F0;object-fit:cover;"
                               src="<?php echo $member_image_path; ?>"
                               alt="avatar">
                          <span style="margin-left:6px;font-weight:600;"><?php echo $_SESSION['m_name']; ?></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="index.php?p=member">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                              <?= __('Profile');?>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="index.php?p=member&sec=bookmark">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"></path></svg>
                              <?= __('Bookmark');?>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="index.php?p=member&logout=1" style="color:#EF4444;">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                              <?= __('Logout'); ?>
                          </a>
                      </div>
                  </li>
              <?php } else { ?>
                  <li class="nav-item <?= $menu_member_active; ?>">
                      <a class="nav-link btn-member" href="index.php?p=member">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          <?= __('Member Area') ?>
                      </a>
                  </li>
              <?php } ?>

              <!-- Language selector -->
              <?php if (!empty($available_languages)) : ?>
              <li class="nav-item dropdown ml-2">
                <?php
                $langstr = '';
                $current_lang = ['code' => 'id', 'name' => 'ID'];
                $select_lang = isset($_COOKIE['select_lang'])?$_COOKIE['select_lang']:$sysconf['default_lang'];
                foreach ($available_languages??[] AS $lang_index) {
                  $lang_code = $lang_index[0];
                  $lang_name = $lang_index[1];
                  $code_arr = explode('_', $lang_code);
                  $code_flag = strtolower($code_arr[1]);
                  if ($lang_code == $select_lang) {
                    $current_lang = ['name' => $lang_name, 'code' => $code_flag];
                  }
                  $langstr .= <<<HTML
    <a class="dropdown-item" href="index.php?select_lang={$lang_code}">
        <span class="flag-icon flag-icon-{$code_flag} mr-2" style="border-radius: 2px;"></span> {$lang_name}
    </a>
HTML;
                }
                ?>
                  <a class="nav-link dropdown-toggle cursor-pointer" type="button" id="languageMenuButton"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="flag-icon flag-icon-<?= $current_lang['code'] ?>" style="border-radius: 2px;"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <h6 class="dropdown-header"><?= __('Select Language'); ?></h6>
                    <?= $langstr; ?>
                  </div>
              </li>
              <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
