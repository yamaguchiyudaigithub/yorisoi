<?php
/* the_archive_title 余計な文字を削除 */
add_filter('get_the_archive_title', function ($title) {
  if (is_category()) {
    $title = single_cat_title('', false);
  } elseif (is_tag()) {
    $title = single_tag_title('', false);
  } elseif (is_tax()) {
    $title = single_term_title('', false);
  } elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
  } elseif (is_date()) {
    $title = get_the_time('Y年n月');
  } elseif (is_search()) {
    $title = '検索結果：' . esc_html(get_search_query(false));
  } elseif (is_404()) {
    $title = '「404」ページが見つかりません';
  } else {
  }
  return $title;
});

function the_breadcrumbs()
{
  global $post;
  $results = '';
  // ターム情報生成
  $taxonomy = get_post_taxonomies($post);
  $term     = get_the_terms($post, $taxonomy[0]);
  // 変数に格納
  $results .=
    '
    <div class="breadcrumbs">
  <ol class="l-breadcrumbs-list">
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--home">
      <a href="' . home_url('/') . '">
        ホーム
      </a>
    </li>
  ';
  // 製品アーカイブの場合
  if (is_post_type_archive('product')) {
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">製品・ソリューション</li>
    ';
  }
  // 導入事例アーカイブの場合
  if (is_post_type_archive('case')) {
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">導入事例</li>
    ';
  }
  // トピックス（投稿）アーカイブの場合
  if (is_post_type_archive('post')) {
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">トピックス一覧</li>
      ';
  }
  // イベントアーカイブの場合
  if (is_post_type_archive('event')) {
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">セミナー・展示会</li>
      ';
  }
  // トピックス（投稿）カテゴリーの場合
  if (is_category()) {
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">トピックス一覧</li>
      ';
  }
  // 製品投稿の場合
  else if (is_singular('product')) {
    $results .= '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current"><a href="' . esc_url(home_url('/product')) . '">製品・ソリューション</a></li>';
    if ($term) {
      $results .=
        '
      <li class="l-breadcrumbs-list__item">
        <a href="' . get_term_link($term[0], $taxonomy[0]) . '">
          ' . $term[0]->name . '
        </a>
      </li>
      ';
    }
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
      ' . get_the_title($post) . '
    </li>
    ';
  }
  // 導入事例投稿の場合
  else if (is_singular('case')) {
    $results .= '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current"><a href="' . esc_url(home_url('/case')) . '">導入事例</a></li>';
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
      ' . get_the_title($post) . ' 様
    </li>
    ';
  }
  // 投稿の場合
  else if (is_single()) {
    $results .= '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current"><a href="' . esc_url(home_url('/info')) . '">トピックス</a></li>';
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
      ' . get_the_title($post) . '
    </li>
    ';
  }
  //お問い合わせ
  else if (is_page(array('confirm-f', 'confirm-d', 'complete-f', 'complete-d'))) {
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">お問い合わせ</li>
      ';
  }
  // 会社概要ページの場合
  else if (is_page('corporate')) {
    $results .= '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">会社案内</li>';
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
      ' . get_the_title($post) . '
    </li>
    ';
  }
  // 会社概要の子ページの場合
  else if (is_page()) {
    // 親ページがある場合祖先から階層出力
    if ($post->post_parent != 0) {
      $post_data = get_post($post->post_parent);
      $parent_slug = $post_data->post_name;
      if ($parent_slug === 'corporate') {
        $results .= '<li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">会社案内</li>';
      }
    }
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
        ' . get_the_title($post) . '
      </li>
      ';
  }
  // ページの場合
  else if (is_page()) {
    // 親ページがある場合祖先から階層出力
    if ($post->post_parent != 0) {
      $ancestors = array_reverse($post->ancestors);
      foreach ($ancestors as $ancestor) {
        $results .=
          '
          <li class="l-breadcrumbs-list__item">
            <a href="' . get_permalink($ancestor) . '">
              ' . get_the_title($ancestor) . '
            </a>
          </li>';
      }
    }
    $results .=
      '
      <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
        ' . get_the_title($post) . '
      </li>
      ';
  }
  // 404の場合
  else if (is_404()) {
    $results .=
      '
    <li class="l-breadcrumbs-list__item l-breadcrumbs-list__item--current">
      404 Not Found
    </li>
    ';
  }
  $results .= '</div></ol>';
  // 出力
  echo $results;
}
