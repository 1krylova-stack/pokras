<?php
$current_tag = '';
$current_title = '';

if (is_page('kuzovnoj-remont')) {
    $current_tag = 'kuzovnoj-remont';
    $current_title = 'С какими авто мы работаем?';
} elseif (is_page('pokraska-avtomobilya')) {
    $current_tag = 'pokraska-avtomobilya';
    $current_title = 'С какими авто мы работаем?';
} elseif (is_page('remont-bamperov')) {
    $current_tag = 'remont-bamperov';
    $current_title = 'С какими авто мы работаем?';
}

if ($current_tag):
    $brand_pages = get_posts([
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tag'            => $current_tag,
    ]);

    if ($brand_pages): ?>
        <section class="brands-catalog">
            <h2 class="brands-title"><?php echo esc_html($current_title); ?></h2>
            <div class="brands-grid">
                <?php foreach ($brand_pages as $post): setup_postdata($post); ?>
                    <a href="<?php the_permalink(); ?>" class="brand-item">
                        <div class="brand-content">
                            <div class="brand-logo">
                                <?php if (has_post_thumbnail($post->ID)) {
                                    echo get_the_post_thumbnail($post->ID, 'medium');
                                } else {
                                    echo '<div class="no-logo">Нет изображения</div>';
                                } ?>
                            </div>
                            <div class="brand-name"><?php echo get_the_title($post->ID); ?></div>
                        </div>
                    </a>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </section>

      <style>
/* Контейнер и заголовок */
.brands-catalog{
  padding:40px 20px;
  max-width:1200px;
  margin:0 auto;
}
.brands-catalog *{box-sizing:border-box}
.brands-title{margin-bottom:24px;font-size:24px;}

/* Сетка (по умолчанию — 10 в ряд) */
.brands-grid{
  display:grid;
  grid-template-columns:repeat(10,1fr);
  gap:12px;
  width:100%;
  overflow:hidden;
}

/* Карточка */
.brand-item{display:block;color:inherit;text-decoration:none}

/* Контент: плашка с логотипом + подпись снизу */
.brand-content{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:8px;
  width:100%;
}

/* ПЛАШКА */
.brand-logo{
  width:100%;
  min-height:72px;
  padding:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  border:1px solid #eee;
  border-radius:10px;
  background:#fff;
  transition:box-shadow .18s ease, border-color .18s ease;
}
.brand-logo img{
  max-width:46px;
  max-height:46px;
  width:auto;
  height:auto;
  object-fit:contain;
  display:block;
}
.no-logo{
  width:46px;
  height:46px;
  background:#f2f4f7;
  color:#666;
  font-size:11px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:8px;
}

/* ХОВЕР (только десктопы с hover) */
@media (hover:hover){
  .brand-item:hover .brand-logo,
  .brand-item:focus-visible .brand-logo{
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    border-color:#e5e7eb;
  }
}
/* доступность */
.brand-item:focus .brand-logo{outline:2px solid #dbeafe;outline-offset:2px}

/* Подпись */
.brand-name{
  text-align:center;
  font-size:13px;
  line-height:1.2;
  padding:0 4px;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
  min-height:2.4em;
  word-break:break-word;
  overflow-wrap:anywhere;
}

/* ——— Кол-во колонок ——— */
/* ≥1280: 10 */
@media (min-width:1280px){
  .brands-grid{grid-template-columns:repeat(10,1fr)}
}
/* 1024–1279: 9 */
@media (max-width:1279px){
  .brands-grid{grid-template-columns:repeat(9,1fr)}
}
/* 900–1023: 8 */
@media (max-width:1023px){
  .brands-grid{grid-template-columns:repeat(8,1fr)}
}
/* 768–899: 7 */
@media (max-width:899px){
  .brands-grid{grid-template-columns:repeat(7,1fr)}
}

/* ——— Мобилка: 5 в ряд, без горизонтального скролла ——— */
@media (max-width:767px){
  .brands-title{font-size:20px;padding-left:12px}

  .brands-catalog{
    max-width:100vw;
    overflow-x:hidden;
    padding:0;               /* убрали паддинги */
    margin:0 auto;
  }
  .brands-grid{
    grid-template-columns:repeat(5, minmax(0,1fr));
    gap:8px;
    width:100%;
    max-width:100%;
    padding:0;
    margin:0;
    overflow:hidden;
  }

  /* чтобы дети могли сжиматься */
  .brands-grid > *{min-width:0}
  .brand-item{min-width:0}
  .brand-content{width:100%;min-width:0}

  /* карточки компактнее */
  .brand-content{gap:4px}
  .brand-logo{
    min-height:44px;
    padding:4px;
    border-radius:8px;
  }
  .brand-logo img,.no-logo{
    max-width:28px;
    max-height:28px;
    width:28px;
    height:28px;
  }
  .brand-name{
    font-size:11px;
    min-height:2.2em;
    padding:0 2px;
    text-overflow:ellipsis;
    overflow:hidden;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
  }

  /* без ховеров/тени на тач */
  .brand-item:hover .brand-logo{transform:none;box-shadow:none}
  .brand-item:focus .brand-logo{outline:none}
}

/* ——— Очень узкие — можно перейти на 4 в ряд ——— */
@media (max-width:359px){
  .brands-grid{grid-template-columns:repeat(4, minmax(0,1fr))}
}

		  
		  
		  
		  
</style>


    <?php endif;
endif;
?>
