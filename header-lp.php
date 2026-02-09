<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preload" as="style" fetchpriority="high" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Gotu&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Gotu&display=swap" media="print" onload="this.media='all'" />
  <noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Gotu&display=swap" />
  </noscript>
  <?php if ( is_front_page() ) : ?>
    <base href="<?php echo esc_url( trailingslashit( get_template_directory_uri() ) ); ?>">
  <?php endif; ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php
  $theme_uri = get_template_directory_uri();
  $theme_dir = get_template_directory();
  $header_logo_rel = '/assets/images/yorisoi_logo.PYxNSU74.png';
  $header_logo_url = $theme_uri . $header_logo_rel;
  $header_logo_path = $theme_dir . $header_logo_rel;
  $drawer_bg_rel = '/assets/images/bg_img02.png';
  $drawer_bg_path = $theme_dir . $drawer_bg_rel;
  $drawer_bg_url = $theme_uri . $drawer_bg_rel;
  if ( file_exists( $drawer_bg_path ) ) {
    $drawer_bg_url .= '?v=' . filemtime( $drawer_bg_path );
  }
  ?>

  <header class="p-header l-header">
    <div class="p-header__inner">
      <div class="p-header__left">
        <?php if ( is_front_page() ) : ?>
          <h1 class="p-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="よりそいDX 医療版">
              <?php if ( file_exists( $header_logo_path ) ) : ?>
                <img src="<?php echo esc_url( $header_logo_url ); ?>" width="218" height="51" alt="よりそいDX" />
              <?php else : ?>
                <span>よりそいDX</span>
              <?php endif; ?>
            </a>
          </h1>
        <?php else : ?>
          <p class="p-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="よりそいDX 医療版">
              <?php if ( file_exists( $header_logo_path ) ) : ?>
                <img src="<?php echo esc_url( $header_logo_url ); ?>" width="218" height="51" alt="よりそいDX" />
              <?php else : ?>
                <span>よりそいDX</span>
              <?php endif; ?>
            </a>
          </p>
        <?php endif; ?>
        <p class="p-header__edition">医療版</p>
      </div>

      <div class="p-header__right">
        <a class="p-header__cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">まずは気軽に無料相談</a>

        <button class="p-header__hamburger js-hamburger" aria-label="メニューを開く" aria-expanded="false" aria-controls="drawer-menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- ドロワーはheader外に配置（headerのtransformの影響でfixedが効かないため） -->
  <div id="drawer-menu" class="p-header__drawer js-drawer" aria-hidden="true">
    <div class="p-header__drawer-bg" style="background-image: url('<?php echo esc_url( $drawer_bg_url ); ?>');" aria-hidden="true"></div>
    <button type="button" class="p-header__drawer-close p-header__hamburger is-open js-drawer-close" aria-label="メニューを閉じる">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="p-header__drawer-inner">
      <nav class="p-header__drawer-nav" aria-label="グローバルナビ">
        <ul class="p-header__drawer-list">
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#top' ) ); ?>">TOP</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#problems' ) ); ?>">こんなお悩みありませんか？</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#features' ) ); ?>">よりそいDVD医療版の特徴</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#areas' ) ); ?>">対応領域</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#plans' ) ); ?>">料金プラン</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#flow' ) ); ?>">導入までの流れ</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#company' ) ); ?>">会社概要</a></li>
          <li class="p-header__drawer-item"><a class="p-header__drawer-link" href="<?php echo esc_url( home_url( '/#staff' ) ); ?>">スタッフ紹介・実績</a></li>
        </ul>
      </nav>

      <div class="p-header__drawer-cta-area">
        <p class="p-header__drawer-note"><span class="u-mobile">初回は忙しい先生でも安心の<br>オンライン商談！</span><span class="u-desktop">初回は忙しい先生でも安心のオンライン商談。まずは気軽にご相談ください！</span></p>
        <a class="p-header__drawer-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
          <span class="p-header__drawer-cta-text">まずは気軽に無料相談</span>
          <span class="p-header__drawer-cta-icon" aria-hidden="true"></span>
        </a>
      </div>
    </div>
  </div>
