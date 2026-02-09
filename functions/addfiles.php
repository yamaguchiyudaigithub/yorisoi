<?php
/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

define('TEMPLATE_DIRE', get_template_directory_uri());
define('TEMPLATE_PATH', get_template_directory());
define('PATH_CSS', '/assets/css/');
define('PATH_JS', '/assets/js/');
function add_files()
{

  function wp_css($css_name, $file_path)
  {
    wp_enqueue_style($css_name, TEMPLATE_DIRE . $file_path, array(), date('YmdGis', filemtime(TEMPLATE_PATH . $file_path)));
  }
  function wp_script($script_name, $file_path, $bool = true)
  {
    wp_enqueue_script($script_name, TEMPLATE_DIRE . $file_path, array('jquery'), date('YmdGis', filemtime(TEMPLATE_PATH . $file_path)), $bool);
  }

  $DEFAULT = 'maimai';
  $is_lp = is_page_template('page-lp.php');

  if ($is_lp) {
    // LPページ: lp.css / lp.js のみ（他テーマCSSと競合しないようにする）
    wp_enqueue_style('lp', TEMPLATE_DIRE . '/assets/css/lp.css', array(), date('YmdGis', filemtime(TEMPLATE_PATH . '/assets/css/lp.css')));
    wp_enqueue_script('lp', TEMPLATE_DIRE . '/assets/js/lp.js', array('jquery'), date('YmdGis', filemtime(TEMPLATE_PATH . '/assets/js/lp.js')), true);
    return;
  }

  // 通常ページ用のCSS
  $css_list = array(
    '/assets/css/slick-theme.css',
    '/assets/css/slick.css',
    // '/assets/css/animation.min.css',
    $DEFAULT . '.min'
  );

  if ($css_list) {
    foreach ($css_list as $value) {
      if (preg_match("/^\/assets\//", $value)) {
        wp_enqueue_style($value, TEMPLATE_DIRE . $value);
      } else {
        $filePath = PATH_CSS . $value . '.css';
        wp_css($value, $filePath);
      }
    }
  }

  // 通常ページ用のJS
  $js_list = array(
    '/assets/js/slick.min.js',
    $DEFAULT,
  );

  if ($js_list) {
    foreach ($js_list as $value) {
      if (preg_match("/^\/\//", $value)) {
        wp_enqueue_script($value, 'https:' . $value);
      } else if (preg_match("/^\/assets/", $value)) {
        wp_enqueue_script($value, TEMPLATE_DIRE . $value, array('jquery'));
      } else {
        $filePath = PATH_JS . $value . '.js';
        wp_script($value, $filePath);
      }
    }
  }
}
add_action('wp_enqueue_scripts', 'add_files', 1);

// add style for editor
add_editor_style(get_template_directory_uri() . '/assets/css/editor-style.min.css');