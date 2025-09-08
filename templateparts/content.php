<?php
/**
 * templateparts/content.php
 * Версия с фиксом CLS:
 *  - Все IMG получают width/height (WP attachment или getimagesize для статичных иконок)
 *  - Герой и галерея — с aspect-ratio (без «прыжков» при загрузке)
 *  - Минимизируем изменения разметки, чтобы не сломать текущие стили
 */

if (!defined('ABSPATH')) { exit; }

/** ХЕЛПЕР: безопасный вывод изображения (ID/array/URL) c width/height */
function _alt_img_safe($img, $size = 'large', $attrs = []) {
    // Приоритет: ID или массив ACF -> wp_get_attachment_image (сам проставит w/h/srcset)
    if (is_numeric($img)) {
        return wp_get_attachment_image((int)$img, $size, false, $attrs);
    }
    if (is_array($img)) {
        if (!empty($img['ID'])) {
            return wp_get_attachment_image((int)$img['ID'], $size, false, $attrs);
        }
        if (!empty($img['url'])) {
            // Внешний URL из ACF
            $url = esc_url($img['url']);
            $alt = !empty($attrs['alt']) ? esc_attr($attrs['alt']) : '';
            $loading  = !empty($attrs['loading'])  ? esc_attr($attrs['loading'])  : 'lazy';
            $decoding = !empty($attrs['decoding']) ? esc_attr($attrs['decoding']) : 'async';
            return '<img src="'.$url.'" alt="'.$alt.'" loading="'.$loading.'" decoding="'.$decoding.'" style="display:block;width:100%;height:auto;">';
        }
    }
    if (is_string($img) && $img !== '') {
        // Попробуем получить ID по URL из медиа-библиотеки
        $id = attachment_url_to_postid($img);
        if ($id) {
            return wp_get_attachment_image($id, $size, false, $attrs);
        }
        // Внешний URL
        $url = esc_url($img);
        $alt = !empty($attrs['alt']) ? esc_attr($attrs['alt']) : '';
        $loading  = !empty($attrs['loading'])  ? esc_attr($attrs['loading'])  : 'lazy';
        $decoding = !empty($attrs['decoding']) ? esc_attr($attrs['decoding']) : 'async';
        return '<img src="'.$url.'" alt="'.$alt.'" loading="'.$loading.'" decoding="'.$decoding.'" style="display:block;width:100%;height:auto;">';
    }
    return '';
}

/** ХЕЛПЕР: статичная иконка из темы с реальными размерами */
function _theme_icon_img($rel_path, $alt = '') {
    $src = get_template_directory_uri() . $rel_path;
    $fs  = get_template_directory()      . $rel_path;
    $w = $h = 0;
    if (file_exists($fs)) {
        $dim = @getimagesize($fs);
        if (is_array($dim)) { $w = (int)$dim[0]; $h = (int)$dim[1]; }
    }
    $w_attr = $w ? ' width="'.$w.'"' : '';
    $h_attr = $h ? ' height="'.$h.'"' : '';
    return '<img src="'.esc_url($src).'" alt="'.esc_attr($alt).'"'.$w_attr.$h_attr.' loading="lazy" decoding="async" />';
}

?>
<div id="content">
  <div class="center_wrap">

    <?php get_template_part('templateparts/breadcrumbs')?>

    <?php if ( !is_category(6) ): ?>
      <div id="page_content">

        <!-- Заголовок/герой -->
        <p class="content_title"><?php the_field('top_content_title')?></p>

        <div class="dt">
          <div class="dtc vat page_content <?php if(!get_field('photos')):?>otrmargin<?php endif;?>">
            <?php if(!get_field('photos')):?>
              <div class="center_wrap">
            <?php endif;?>

            <?php
              // Верхний текст
              the_field('top_content_info');

              // Блок с «фичами» (иконки) – не показываем на технич шаблоне
              if ( !is_page_template('template-technical.php') ):
            ?>
              <table>
                <tr>
                  <td><?php echo _theme_icon_img('/img/content_icon_1.png', ''); ?></td>
                  <td><strong>Подбор оригинальных запчастей или аналогов на выбор</strong></td>
                </tr>
                <tr>
                  <td><?php echo _theme_icon_img('/img/content_icon_2.png', ''); ?></td>
                  <td><strong>Фотоотчет и согласование каждого этапа</strong></td>
                </tr>
              </table>
            <?php endif; ?>

            <?php if(!get_field('photos')):?></div><?php endif;?>

            <?php
              // Блок выбора дочерних страниц (как был)
              $child_pages = get_pages([
                'child_of'    => get_the_ID(),
                'sort_column' => 'menu_order',
                'sort_order'  => 'ASC'
              ]);
            ?>
            <?php if ( !empty($child_pages) ): ?>
              <div class="choose_block">
                <?php
                  if ( is_page_template( 'template-servicepage.php' ) ) {
                    echo '<p>Выберите услугу или марку автомобиля</p>';
                  }
                  if ( is_page_template( 'template-markapage.php' ) ) {
                    echo '<p>Выберите модель автомобиля</p>';
                  }
                ?>
                <div class="dt">
                  <div class="dtc">
                    <div class="select">
                      <?php if(is_page_template( 'template-servicepage.php' )):?>
                        <span class="select_text">Выбрать</span>
                      <?php endif;?>
                      <?php if(is_page_template( 'template-markapage.php' )):?>
                        <span class="select_text">модель автомобиля</span>
                      <?php endif;?>
                      <ul>
                        <?php foreach($child_pages as $child_page):?>
                          <li><a href="<?php echo get_permalink($child_page->ID)?>"><?php echo esc_html($child_page->post_title)?></a></li>
                        <?php endforeach;?>
                      </ul>
                    </div><!--/.select-->
                  </div><!--/.dtc-->
                  <div class="dtc">
                    <a href="#benefits" class="scrollto">Узнать больше о сервисе</a>
                  </div>
                </div><!--/.dt-->
              </div><!--/.choose_block-->
            <?php endif; ?>

            <div class="content_form_wrap">
              <?php
                // если тут была форма/шорткод – оставьте как было, пример:
                // echo do_shortcode('[contact-form-7 id="..."]');
                // CLS-фиксы делаются в CSS: .wpcf7-response-output{min-height:48px;}
              ?>
            </div>

          </div><!--/.page_content-->

          <?php
            // ФОТОГАЛЕРЕЯ (если есть ACF-поле 'photos')
            $photos = get_field('photos'); // ACF Gallery
            if ($photos && is_array($photos) && !empty($photos)):
              // Главная (большая) фотка – возьмем первую
              $first = $photos[0];

              // Определим размеры для «большой» версии: берём 'large' (или полную)
              $first_html = '';
              if (!empty($first['ID'])) {
                // attachment
                $first_html = wp_get_attachment_image((int)$first['ID'], 'large', false, [
                  'class'         => 'page_content_photo_big_img',
                  'decoding'      => 'async',
                  'loading'       => 'eager',
                  'fetchpriority' => 'high'
                ]);
                $first_url = wp_get_attachment_image_url((int)$first['ID'], 'full');
              } else {
                // внешний URL / массив без ID
                $first_url  = !empty($first['url']) ? esc_url($first['url']) : '';
                $first_html = '<img class="page_content_photo_big_img" src="'.$first_url.'" alt="" decoding="async" loading="eager" />';
              }
          ?>

          <div class="dtc vat page_content_photo">
            <div class="page_content_photo_big">
              <!-- Резерв места под большую фотку -->
              <div class="photo-big-media" style="aspect-ratio: 4/3; overflow:hidden;">
                <a href="<?php echo esc_url($first_url); ?>" class="fancybox_gallery">
                  <?php echo $first_html; ?>
                </a>
              </div>
            </div>

            <div class="page_content_photo_thumbs">
              <ul>
                <?php
                  $count = 1;
                  foreach ($photos as $photo):
                    // Для превью используем размер content-thumb, если он объявлен,
                    // и возьмём точные размеры, чтобы не было CLS
                    $thumb_src   = '';
                    $thumb_w     = '';
                    $thumb_h     = '';
                    $full_url    = '';

                    if (!empty($photo['ID'])) {
                      // attachment — безопаснее через wp_get_attachment_image_src
                      $thumb = wp_get_attachment_image_src((int)$photo['ID'], 'content-thumb');
                      if (!$thumb) { $thumb = wp_get_attachment_image_src((int)$photo['ID'], 'thumbnail'); }
                      if ($thumb) {
                        $thumb_src = $thumb[0];
                        $thumb_w   = (int)$thumb[1];
                        $thumb_h   = (int)$thumb[2];
                      }
                      $full_url = wp_get_attachment_image_url((int)$photo['ID'], 'full');
                    } else {
                      // массив ACF (галерея) — у него обычно есть ['sizes']['content-thumb'] и ['sizes']['content-thumb-width']
                      if (!empty($photo['sizes']['content-thumb'])) {
                        $thumb_src = $photo['sizes']['content-thumb'];
                        if (!empty($photo['sizes']['content-thumb-width']))  $thumb_w = (int)$photo['sizes']['content-thumb-width'];
                        if (!empty($photo['sizes']['content-thumb-height'])) $thumb_h = (int)$photo['sizes']['content-thumb-height'];
                      } elseif (!empty($photo['sizes']['thumbnail'])) {
                        $thumb_src = $photo['sizes']['thumbnail'];
                        if (!empty($photo['sizes']['thumbnail-width']))  $thumb_w = (int)$photo['sizes']['thumbnail-width'];
                        if (!empty($photo['sizes']['thumbnail-height'])) $thumb_h = (int)$photo['sizes']['thumbnail-height'];
                      } elseif (!empty($photo['url'])) {
                        $thumb_src = $photo['url'];
                      }
                      $full_url = !empty($photo['url']) ? esc_url($photo['url']) : '';
                    }

                    $wh = '';
                    if ($thumb_w && $thumb_h) {
                      $wh = ' width="'.$thumb_w.'" height="'.$thumb_h.'"';
                    }
                ?>
                  <li>
                    <img src="<?php echo esc_url($thumb_src); ?>"
                         <?php echo $wh; ?>
                         alt=""
                         loading="lazy"
                         decoding="async"
                         <?php if (1 === $count):?>class="active"<?php endif;?>
                         data-big="<?php echo esc_url($full_url); ?>"/>
                  </li>
                <?php
                    $count++;
                  endforeach;
                ?>
              </ul>
            </div>
          </div><!--/.page_content_photo-->
          <?php endif; // photos ?>

        </div><!--/.dt-->
      </div><!--/#page_content-->
    <?php endif; ?>

  </div><!--/.center_wrap-->
</div><!--/#content-->
