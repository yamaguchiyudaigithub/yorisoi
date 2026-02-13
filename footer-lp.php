<?php
$theme_uri = get_template_directory_uri();
$theme_dir = get_template_directory();
$footer_logo_rel = '/assets/images/logo_white.Dwhr1FzQ.png';
$footer_logo_url = $theme_uri . $footer_logo_rel;
$footer_logo_path = $theme_dir . $footer_logo_rel;
?>

<footer class="p-footer">
  <div class="p-footer__inner l-inner">
    <?php if ( file_exists( $footer_logo_path ) ) : ?>
    <img class="p-footer__logo" src="<?php echo esc_url( $footer_logo_url ); ?>" width="371" height="96" alt="株式会社まいまい" />
    <?php else : ?>
    <p class="p-footer__company">株式会社まいまい</p>
    <?php endif; ?>

    <div class="p-footer__text">
      <?php if ( file_exists( $footer_logo_path ) ) : ?>
      <p class="p-footer__company">株式会社まいまい</p>
      <?php endif; ?>
      <p class="p-footer__address">〒240-0006　神奈川県横浜市保土ヶ谷区星川1-13-6</p>
      <p class="p-footer__url">
        <a href="https://www.maimai-it.co.jp/" target="_blank" rel="noopener noreferrer">https://www.maimai-it.co.jp/</a>
      </p>
      <p class="p-footer__copy">©Maimai Co., Ltd.</p>
    </div>
  </div>
</footer>

<?php if ( is_front_page() || is_page_template( 'page-lp.php' ) ) : ?>
<div class="p-top-dx__fixed-bar">
  <a class="c-dx-cta c-dx-cta--fixed" href="https://timerex.net/s/maimai.maiko.matsue_106c/dd00f206">
    <span class="c-dx-cta__text">まずは気軽に無料相談</span>
    <span class="c-dx-cta__icon" aria-hidden="true"></span>
  </a>
  <a class="p-top-dx__to-top" href="#top" aria-label="TOPへ戻る">
    <span class="p-top-dx__to-top-icon" aria-hidden="true"></span>
  </a>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
