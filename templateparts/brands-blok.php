<?php
if (!defined('ABSPATH')) exit;

/** Забираем атрибуты, переданные из шорткода */
$__atts = $GLOBALS['brands_blok_atts'] ?? [];
$tag    = $__atts['tag']   ?? '';
$title  = $__atts['title'] ?? '';

/** Если tag не задан — определяем по текущей странице */
if (empty($tag)) {
    if (is_page('kuzovnoj-remont')) {
        $tag   = 'kuzovnoj-remont';
        $title = $title ?: 'Кузовной ремонт авто по маркам автомобилей';
    } elseif (is_page('pokraska-avtomobilya')) {
        $tag   = 'pokraska-avtomobilya';
        $title = $title ?: 'Покраска автомобилей по маркам автомобилей';
    } elseif (is_page('remont-bamperov')) {
        $tag   = 'remont-bamperov';
        $title = $title ?: 'Ремонт бамперов по маркам автомобилей';
    }
}

if (empty($tag)) { return; } // нет контекста — ничего не выводим

$limit           = isset($__atts['limit']) ? (int)$__atts['limit'] : -1;
$exclude_current = !empty($__atts['exclude_current']) && $__atts['exclude_current'] !== '0';
$orderby         = isset($__atts['orderby']) ? sanitize_key($__atts['orderby']) : 'title';
$order           = (isset($__atts['order']) && strtoupper($__atts['order']) === 'DESC') ? 'DESC' : 'ASC';
$class           = isset($__atts['class']) ? sanitize_html_class($__atts['class']) : '';

/** Запрос страниц-брендов по метке */
$args_q = [
    'post_type'              => 'page',
    'post_status'            => 'publish',
    'posts_per_page'         => $limit,
    'orderby'                => $orderby,
    'order'                  => $order,
    'tax_query'              => [[
        'taxonomy' => 'post_tag',
        'field'    => 'slug',
        'terms'    => sanitize_title($tag),
    ]],
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
];

if ($exclude_current && function_exists('get_queried_object_id')) {
    $args_q['post__not_in'] = [ get_queried_object_id() ];
}

$q = new WP_Query($args_q);
if (!$q->have_posts()) { return; }
?>
<!-- brands-blok: render -->
<section class="brands-catalog <?php echo esc_attr($class); ?>">
    <?php if (!empty($title)): ?>
        <h2 class="brands-title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <div class="brands-grid">
        <?php while ($q->have_posts()): $q->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="brand-item" aria-label="<?php the_title_attribute(); ?>">
                <div class="brand-content">
                    <div class="brand-logo">
                        <?php if (has_post_thumbnail()):
                            the_post_thumbnail('medium', [
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'alt'      => esc_attr(get_the_title()),
                                'sizes'    => '(max-width:479px) 54px, (max-width:767px) 58px, 60px',
                            ]);
                        else: ?>
                            <div class="no-logo">Нет изображения</div>
                        <?php endif; ?>
                    </div>
                    <div class="brand-name"><?php echo esc_html(get_the_title()); ?></div>
                </div>
            </a>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>
<?php
// Чистим за собой, чтобы не тянуть аттрибуты в другие get_template_part
unset($GLOBALS['brands_blok_atts']);
