<?php
/**
 * templateparts/reviews.php — версия с фиксом CLS
 * - заменён query_posts на WP_Query
 * - для картинок используется helper alt_img_local() (ID/array/URL)
 * - контейнеры изображений имеют aspect-ratio, чтобы не было «прыжка»
 */

if (!defined('ABSPATH')) { exit; }

/** Хелпер: безопасный вывод изображения (ID / ACF array / URL) с нужными атрибутами */
if (!function_exists('alt_img_local')) {
  function alt_img_local($img, $size = 'large', $attrs = []) {
    $base_attrs = array_merge([
      'loading'  => 'lazy',
      'decoding' => 'async',
      // тянем картинку на весь контейнер без искажений
      'style'    => 'width:100%;height:100%;object-fit:cover;display:block;',
      'alt'      => '',
    ], $attrs);

    // attachment ID
    if (is_numeric($img)) {
      return wp_get_attachment_image((int)$img, $size, false, $base_attrs);
    }

    // ACF array
    if (is_array($img)) {
      if (!empty($img['ID'])) {
        return wp_get_attachment_image((int)$img['ID'], $size, false, $base_attrs);
      }
      if (!empty($img['url'])) {
        $url = esc_url($img['url']);
        $alt = esc_attr($base_attrs['alt']);
        return '<img src="'.$url.'" alt="'.$alt.'" loading="'.$base_attrs['loading'].'" decoding="'.$base_attrs['decoding'].'" style="'.$base_attrs['style'].'">';
      }
    }

    // Строковый URL
    if (is_string($img) && $img !== '') {
      $id = attachment_url_to_postid($img);
      if ($id) {
        return wp_get_attachment_image($id, $size, false, $base_attrs);
      }
      $url = esc_url($img);
      $alt = esc_attr($base_attrs['alt']);
      return '<img src="'.$url.'" alt="'.$alt.'" loading="'.$base_attrs['loading'].'" decoding="'.$base_attrs['decoding'].'" style="'.$base_attrs['style'].'">';
    }

    return '';
  }
}
?>

<div id="reviews">
  <div class="center_wrap">
    <h2 class="block_title">Наши честные отзывы (До и после)</h2>
    <p class="block_undertitle">За 7 лет работы мы восстановили больше 450 автомобилей.<br>До — серьезные повреждения, после — как с салона.</p>

    <div class="review_slider_wrap">
      <div class="review_slider owl-carousel">
        <?php
        $q = new WP_Query([
          'cat'            => 6,
          'posts_per_page' => -1,
          'orderby'        => 'date',
          'order'          => 'DESC',
          'no_found_rows'  => true,
          'ignore_sticky_posts' => true,
        ]);

        if ($q->have_posts()):
          while ($q->have_posts()): $q->the_post();

            // Поля ACF
            $before = get_field('before_photo'); // может быть ID / array / URL
            $after  = get_field('after_photo');
            $works  = get_field('works');
            $srok   = get_field('srok');
            $price  = get_field('price');
            $author = get_field('author');

            // Контент записи как отзыв
            $review_content = apply_filters('the_content', get_post_field('post_content', get_the_ID()));

            // ALT для картинок
            $alt_before = 'До ремонта — ' . get_the_title();
            $alt_after  = 'После ремонта — ' . get_the_title();
        ?>
          <div class="item review_block">
            <div class="dt">
              <div class="dtc vat">
                <div class="review_block_img" style="aspect-ratio: 4/3; overflow: hidden;">
                  <?php echo alt_img_local($before, 'large', [
                    'alt'       => $alt_before,
                    'loading'   => 'eager',      // левая картинка часто выше фолда
                    'decoding'  => 'async',
                    'style'     => 'width:100%;height:100%;object-fit:cover;display:block;',
                    'fetchpriority' => 'high',
                  ]); ?>
                </div>
                <div class="review_block_info">
                  <p class="review_block_title">Выполненные работы:</p>
                  <?php echo $works ? $works : ''; ?>
                  <div class="price_and_srok">
                    <?php if ($srok): ?>
                      <p>Срок выполнения - <span class="bold"><span style="color:#e74c3c"><?php echo esc_html($srok); ?></span></span></p>
                    <?php endif; ?>
                    <?php if ($price): ?>
                      <p>Стоимость - <span class="bold"><span style="color:#0da2aa"><?php echo esc_html($price); ?></span></span></p>
                    <?php endif; ?>
                  </div>
                </div><!--/.review_block_info-->
              </div><!--/.dtc-->

              <div class="dtc vat">
                <div class="review_block_img" style="aspect-ratio: 4/3; overflow: hidden;">
                  <?php echo alt_img_local($after, 'large', [
                    'alt'      => $alt_after,
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'style'    => 'width:100%;height:100%;object-fit:cover;display:block;',
                  ]); ?>
                </div>
                <div class="review_block_info">
                  <p class="review_block_title">Отзыв клиента:</p>
                  <?php echo $review_content; ?>
                  <?php if ($author): ?>
                    <p class="review_author"><?php echo esc_html($author); ?></p>
                  <?php endif; ?>
                </div><!--/.review_block_info-->
              </div><!--/.dtc-->
            </div><!--/.dt-->
          </div><!--/.review_block-->
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div><!--/.review_slider-->

      <div class="review_notice">
        <p>Уважаемые посетители нашего сайта!</p>
        <ul>
          <li>Все работы, представленные на сайте - наши.</li>
          <li>Каждая работа — это процесс, в который мы привносим жизнь.</li>
        </ul>
        <p><span class="bold">Хотите такой же результат? Приезжайте или отправьте фото прямо сейчас</span></p>
      </div><!--/.review_notice-->
    </div><!--/.review_slider_wrap-->
  </div><!--/.center_wrap-->
</div><!--/#reviews-->
