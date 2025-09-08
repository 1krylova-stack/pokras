<?php
/**
 * templateparts/benefits.php — возврат естественных пропорций изображений (как было)
 * + сохраняем анти-CLS за счёт width/height у <img>
 */

if (!defined('ABSPATH')) { exit; }

/** Хелпер: безопасный вывод изображения с естественными пропорциями */
if (!function_exists('alt_img_local_natural')) {
  function alt_img_local_natural($img, $size = 'medium', $attrs = []) {
    // Базовые атрибуты: НЕТ высоты 100% и НЕТ object-fit
    $base = array_merge([
      'loading'  => 'lazy',
      'decoding' => 'async',
      'alt'      => '',
      'class'    => '',
      // естественные пропорции
      'style'    => 'display:block;width:100%;height:auto;',
    ], $attrs);

    // 1) attachment ID → wp_get_attachment_image (даёт width/height)
    if (is_numeric($img)) {
      return wp_get_attachment_image((int)$img, $size, false, $base);
    }

    // 2) ACF array
    if (is_array($img)) {
      if (!empty($img['ID'])) {
        return wp_get_attachment_image((int)$img['ID'], $size, false, $base);
      }
      if (!empty($img['url'])) {
        $url = esc_url($img['url']);
        $alt = esc_attr($base['alt']);

        // Попробуем взять реальные размеры из массива ACF
        $w = !empty($img['width'])  ? (int)$img['width']  : '';
        $h = !empty($img['height']) ? (int)$img['height'] : '';

        $wh = '';
        if ($w && $h) $wh = ' width="'.$w.'" height="'.$h.'"';

        return '<img src="'.$url.'" alt="'.$alt.'"'.$wh.' loading="'.$base['loading'].'" decoding="'.$base['decoding'].'" style="'.$base['style'].'" class="'.esc_attr($base['class']).'">';
      }
    }

    // 3) Строковый URL
    if (is_string($img) && $img !== '') {
      // Пробуем получить attachment ID по URL
      $id = attachment_url_to_postid($img);
      if ($id) {
        return wp_get_attachment_image($id, $size, false, $base);
      }

      // Иначе — URL может быть локальным: попробуем получить размеры
      $url  = esc_url($img);
      $alt  = esc_attr($base['alt']);
      $wh   = '';

      $uploads = wp_upload_dir();
      if (!empty($uploads['baseurl']) && !empty($uploads['basedir']) && str_starts_with($url, $uploads['baseurl'])) {
        $path = $uploads['basedir'] . str_replace($uploads['baseurl'], '', $url);
        if (file_exists($path)) {
          $dim = @getimagesize($path);
          if (is_array($dim)) {
            $wh = ' width="'.(int)$dim[0].'" height="'.(int)$dim[1].'"';
          }
        }
      }

      return '<img src="'.$url.'" alt="'.$alt.'"'.$wh.' loading="'.$base['loading'].'" decoding="'.$base['decoding'].'" style="'.$base['style'].'" class="'.esc_attr($base['class']).'">';
    }

    return '';
  }
}

// Данные из поста ID=7 (как у вас)
$rows = function_exists('get_field') ? get_field('benefits', 7) : [];
$rows_num = is_array($rows) ? count($rows) : 0;
$count = 1;
?>

<div id="benefits">
  <div class="center_wrap">
    <p class="block_title">Преимущества нашего сервиса</p>

    <div class="benefit_blocks">
      <?php if (function_exists('have_rows') && have_rows('benefits', 7)): ?>
        <?php while (have_rows('benefits', 7)) : the_row();
          $img   = get_sub_field('img');   // может быть ID/array/URL
          $title = get_sub_field('title');
          $text  = get_sub_field('text');
        ?>
          <div class="benefit_block">
            <?php if ($img): ?>
              <div class="benefit_block_img">
                <?php
                  echo alt_img_local_natural($img, 'medium', [
                    'alt'   => is_string($title) ? $title : '',
                    'class' => 'benefit_img',
                    // style уже выставлен на height:auto в хелпере
                  ]);
                ?>
              </div>
            <?php endif; ?>

            <div class="benefit_block_text">
              <?php if (!empty($title)): ?>
                <p class="benefit_block_title"><?php echo esc_html($title); ?></p>
              <?php endif; ?>

              <?php if (!empty($text)) echo wp_kses_post($text); ?>

              <?php if ($rows_num && $count === $rows_num): ?>
                <div class="benefit_button_wrap">
                  <p>Оставьте заявку, чтобы получить лучшую стоимость</p>
                  <a class="button" href="#call_order">Получить лучшую цену</a>
                </div>
              <?php endif; ?>
            </div>
          </div><!--/.benefit_block-->
        <?php $count++; endwhile; ?>
      <?php endif; ?>
    </div><!--/.benefit_blocks-->

  </div><!--/.center_wrap-->
</div><!--/#benefits-->
