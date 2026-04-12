<!--  --><?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-01-29 22:16
 * @File name           : login_template.inc.php
 */

if (isset($_GET['p']) && $_GET['p'] === 'visitor') {
  global $main_content;
  $imagesDisk = \SLiMS\Filesystems\Storage::images();
  include __DIR__ . '/classic.php';
  include __DIR__ . '/parts/header.php';
  echo $main_content;
  include __DIR__ . '/assets/js/vegas.js.php';
  echo '</body></html>';
} else {
  include __DIR__ . '/index_template.inc.php';
}