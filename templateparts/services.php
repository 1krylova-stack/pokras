<?php
function pa_render_brand_grid_by_tag($tag_slug){
    $brand_pages = get_posts([
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tag'            => $tag_slug,
        'suppress_filters' => false
    ]);

    if (!$brand_pages) return;
    ?>
    <section class="brands-catalog" data-panel="<?php echo esc_attr($tag_slug); ?>" hidden>
        <div class="brands-grid">
            <?php foreach ($brand_pages as $brand): 
                $brand_id    = $brand->ID;
                $brand_url   = get_permalink($brand_id);
                $brand_title = get_the_title($brand_id);
                ?>
                <a href="<?php echo esc_url($brand_url); ?>" class="brand-item">
                    <div class="brand-content">
                        <div class="brand-logo">
                            <?php 
                            if (has_post_thumbnail($brand_id)) {
                                echo get_the_post_thumbnail($brand_id, 'medium', ['loading'=>'lazy']);
                            } else {
                                echo '<div class="no-logo">Нет<br>лого</div>';
                            } 
                            ?>
                        </div>
                        <div class="brand-name"><?php echo esc_html($brand_title); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

?>

<div id="main_page_services" class="services-wrap">
    <div class="center_wrap">
	<h2 class="services-main-title">Услуги автосервиса</h2>
        <!-- Панель услуг: как табы на десктопе и как аккордеон на мобилке -->
        <div class="services-nav" role="tablist" aria-label="Выбор услуги">
            <!-- Кузовной ремонт (табы/аккордеон) -->
            <button class="service-item js-switch" role="tab"
                    aria-selected="false"
                    aria-controls="panel-kuzovnoj-remont"
                    data-target="kuzovnoj-remont">
                <div class="service-item__img">
                    <img src="<?php bloginfo('template_url')?>/img/main_page_service_1.jpg" alt="">
                </div>
                <span class="service-item__title">Кузовной ремонт</span>
                <span class="service-item__chev" aria-hidden="true"></span>
            </button>

            <!-- Покраска автомобиля (табы/аккордеон) -->
            <button class="service-item js-switch" role="tab"
                    aria-selected="false"
                    aria-controls="panel-pokraska-avtomobilya"
                    data-target="pokraska-avtomobilya">
                <div class="service-item__img">
                    <img src="<?php bloginfo('template_url')?>/img/main_page_service_2.jpg" alt="">
                </div>
                <span class="service-item__title">Покраска автомобиля</span>
                <span class="service-item__chev" aria-hidden="true"></span>
            </button>

            <!-- Ремонт бамперов (табы/аккордеон) -->
            <button class="service-item js-switch" role="tab"
                    aria-selected="false"
                    aria-controls="panel-remont-bamperov"
                    data-target="remont-bamperov">
                <div class="service-item__img">
                    <img src="<?php bloginfo('template_url')?>/img/main_page_service_3.jpg" alt="">
                </div>
                <span class="service-item__title">Ремонт бамперов</span>
                <span class="service-item__chev" aria-hidden="true"></span>
            </button>

            <!-- Ремонт авто после ДТП (прямой переход) -->
            <a class="service-item service-item--link"
               href="<?php echo esc_url(home_url('/remont-avto-posle-dtp/')); ?>">
                <div class="service-item__img">
                    <img src="<?php bloginfo('template_url')?>/img/main_page_service_4.jpg" alt="">
                </div>
                <span class="service-item__title">Ремонт после ДТП</span>
            </a>

            <!-- Ремонт порогов (прямой переход) -->
            <a class="service-item service-item--link"
               href="<?php echo esc_url(home_url('/remont-porogov/')); ?>">
                <div class="service-item__img">
                    <img src="<?php bloginfo('template_url')?>/img/main_page_service_5.jpg" alt="">
                </div>
                <span class="service-item__title">Ремонт порогов</span>
            </a>

            <span class="tabs-underline" aria-hidden="true"></span>
        </div>

        <!-- Панели брендов. По умолчанию скрыты. На десктопе активируем первую. На мобиле — всё закрыто. -->
        <div class="services-panels" id="services-panels">
            <?php
            pa_render_brand_grid_by_tag('kuzovnoj-remont');
            pa_render_brand_grid_by_tag('pokraska-avtomobilya');
            pa_render_brand_grid_by_tag('remont-bamperov');
            ?>
        </div>

    </div>
</div>

<style>
.services-main-title{
  font-size:26px;
  line-height:1.3;
  margin:40px 0 20px;   /* верхний отступ 40px, нижний 20px */
  font-weight:600;
  text-align:left;
}
@media (max-width:767px){
  .services-main-title{
    font-size:22px;
    margin:24px 0 16px; /* на мобилке чуть компактнее */
    padding-left:4px;
  }
}	
	
/* универсально — чтобы размеры не «распухали» */
#main_page_services, 
#main_page_services * { box-sizing: border-box; }

/* ===== ПАНЕЛЬ УСЛУГ (иконка + текст) ===== */
.services-nav { position:relative; display:grid; gap:12px; }

/* базовая карточка услуги */
.service-item,
.service-item--link{
  display:grid;
  grid-template-columns:56px 1fr auto;
  align-items:center;
  gap:12px;
  padding:10px 12px;
  background:#fff;
  border:1px solid #ececec;        /* тоньше граница */
  border-radius:10px;              /* мягкий радиус */
  cursor:pointer;
  text-decoration:none;
  color:inherit;
  overflow:hidden;                  /* запрещаем вылезать */
  min-width:0;                      /* защита внутри grid/flex */
}
.service-item__img{
  width:56px; height:56px; border-radius:8px;
  display:flex; align-items:center; justify-content:center;
  background:#fff;
  overflow:hidden;
}
.service-item__img img{
  max-width:100%; max-height:100%;
  width:auto; height:auto; object-fit:contain; display:block;
}
.service-item__title{ font-size:16px; line-height:1.25; word-break:break-word; }
.service-item__chev::before{
  content:""; display:block; width:8px; height:8px;
  border-right:2px solid #999; border-bottom:2px solid #999;
  transform:rotate(-45deg); transition:transform .2s ease;
}
.service-item[aria-selected="true"] .service-item__chev::before{ transform:rotate(135deg); }

/* линия-индикатор для табов (desktop) */
.tabs-underline{
  display:none; position:absolute; left:0; bottom:-2px;
  height:3px; width:120px; background:#e53935; border-radius:2px;
  transition: transform .25s ease, width .25s ease;
}

/* ===== ДЕСКТОП ≥992px: всё в одну строку, текст под иконкой ===== */
@media (min-width:992px){
  .services-nav{
    display:flex; flex-wrap:nowrap; justify-content:space-between;
    align-items:flex-end; gap:14px; padding-bottom:14px; border-bottom:1px solid #eee;
  }
  .service-item, .service-item--link{
    width:calc((100% - 14px*4)/5); min-width:150px; max-width:220px;
    grid-template-columns:1fr; grid-template-rows:auto auto; gap:8px;
    padding:10px; text-align:center; border:1px solid transparent; background:transparent;
  }
  .service-item__img{ width:48px; height:48px; margin:0 auto; }
  .service-item__title{ font-size:14px; line-height:1.2; }
  .service-item__chev{ display:none; }
  .service-item[aria-selected="true"]{ border-color:#e53935; background:#fff; }
  .tabs-underline{ display:block; }
}

/* ===== МОБИЛКА <992px: аккордеон (иконка слева, текст справа) ===== */
@media (max-width:991px){
  .service-item, .service-item--link{
    grid-template-columns:52px 1fr 12px; gap:10px; padding:10px 12px;
  }
  .service-item__img{ width:52px; height:52px; }
  .service-item__title{ font-size:16px; }
}
@media (max-width:360px){
  .service-item, .service-item--link{ grid-template-columns:46px 1fr 12px; gap:8px; }
  .service-item__img{ width:46px; height:46px; }
}

/* ===== БРЕНДЫ: аккуратные плашки, логотип строго по центру ===== */
.brands-catalog{ padding:24px 0; }
.brands-title{ margin:0 0 16px; font-size:22px; }

/* Грид без налезаний: карточка не ужимается меньше минимума */
.brands-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); /* адаптивно и безопасно */
  gap:12px;
}

/* ссылка-тайл бренда */
.brand-item{ display:block; color:inherit; text-decoration:none; min-width:0; }
.brand-content{ display:flex; flex-direction:column; align-items:center; gap:6px; min-width:0; }

/* плашка-рамка */
.brand-logo{
  width:100%;
  aspect-ratio: 5/3;                 /* стабильная форма плитки */
  padding: clamp(6px, 1.2vw, 12px);  /* адаптивный внутренний отступ */
  display:flex; align-items:center; justify-content:center;
  border:1px solid #ececec;          /* тонкая граница */
  border-radius:10px;                 /* мягкий радиус */
  background:#fff;
  overflow:hidden;                    /* ничего не вылезает */
}
/* логотип вписан по центру */
.brand-logo img{
  max-width:80%;
  max-height:70%;
  width:auto; height:auto;
  object-fit:contain;
  display:block;
}

/* подпись бренда */
.brand-name{
  text-align:center; font-size:13px; line-height:1.2;
  padding:0 4px; min-height:2.4em; overflow:hidden;
  display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
}

/* без «прыгающих» эффектов — чтобы плитки не налезали при ховере */
@media (hover:hover){
  .brand-item:hover .brand-logo, .brand-item:focus-visible .brand-logo{
    border-color:#e5e7eb; box-shadow:0 6px 14px rgba(0,0,0,.05);
  }
}

/* адаптив брендов */
@media (max-width:991px){
  .brands-catalog{ padding:14px 0; }
  .brands-title{ font-size:20px; padding-left:4px; }
  .brands-grid{ gap:8px; grid-template-columns:repeat(auto-fill, minmax(96px, 1fr)); }
  .brand-name{ font-size:11px; min-height:2.2em; }
}
@media (max-width:359px){
  .brands-grid{ grid-template-columns:repeat(auto-fill, minmax(84px, 1fr)); }
}
	
/* --- FIX #1: мобилка — сетка брендов строго 5 в ряд, как в первой версии --- */
@media (max-width: 991px){
  .brands-grid{
    grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
    gap: 8px !important;
  }
  .brand-logo{
    min-height: 44px !important;
    padding: 4px !important;
    border-radius: 8px !important;
    aspect-ratio: auto !important; /* убираем фиксированное соотношение, чтобы «дышало» */
  }
  .brand-logo img,
  .no-logo{
    max-width: 28px !important;
    max-height: 28px !important;
    width: 28px !important;
    height: 28px !important;
  }
  .brand-name{
    font-size: 11px !important;
    min-height: 2.2em !important;
    padding: 0 2px !important;
  }
}

/* --- FIX #2: мобилка — все пункты услуг по ЛЕВОМУ краю (и для кнопок, и для ссылок) --- */
@media (max-width: 991px){
  .service-item,
  .service-item--link{
    text-align: left !important;
    justify-items: start !important;   /* сетка не центрирует содержимое */
  }
  .service-item__img{ margin: 0 !important; }
  .service-item__title{ justify-self: start !important; }
}	
</style>



<script>
(function(){
  const nav   = document.querySelector('.services-nav');
  const tabs  = nav ? nav.querySelectorAll('.js-switch') : [];
  const line  = nav ? nav.querySelector('.tabs-underline') : null;
  const panelsWrap = document.getElementById('services-panels');
  const panels = panelsWrap ? panelsWrap.querySelectorAll('.brands-catalog') : [];

  if(!nav || !tabs.length || !panels.length) return;

  const mqDesktop = window.matchMedia('(min-width: 992px)');

  function hideAllPanels(){
    panels.forEach(p => p.hidden = true);
    tabs.forEach(t => t.setAttribute('aria-selected','false'));
  }

  function showPanelByTag(tag){
    const panel = panelsWrap.querySelector('[data-panel="'+tag+'"]');
    if(!panel) return;
    panel.hidden = false;
    nav.querySelector('[data-target="'+tag+'"]').setAttribute('aria-selected','true');
  }

  function updateUnderline(){
    if(!line || !mqDesktop.matches) return;
    const active = nav.querySelector('.js-switch[aria-selected="true"]');
    if(!active){ line.style.width='0'; return; }
    const rect = active.getBoundingClientRect();
    const parentRect = nav.getBoundingClientRect();
    const w = Math.max(80, rect.width - 20);
    line.style.width = w + 'px';
    line.style.transform = 'translateX(' + (rect.left - parentRect.left + 10) + 'px)';
  }

  // Инициализация
  function init(){
    hideAllPanels();

    if(mqDesktop.matches){
      // Десктоп: сразу открыть первый таб
      const first = tabs[0];
      if(first){
        const tag = first.dataset.target;
        showPanelByTag(tag);
        requestAnimationFrame(updateUnderline);
      }
    } else {
      // Мобилка: всё закрыто
      updateUnderline();
    }
  }

  tabs.forEach(btn=>{
    btn.addEventListener('click', function(){
      const tag = this.dataset.target;

      // Мобилка: аккордеон — если клик по активному, просто закрываем
      if(!mqDesktop.matches && this.getAttribute('aria-selected') === 'true'){
        this.setAttribute('aria-selected','false');
        panelsWrap.querySelector('[data-panel="'+tag+'"]').hidden = true;
        return;
      }

      hideAllPanels();
      showPanelByTag(tag);
      updateUnderline();

      // Скролл к панели на мобиле для видимости
      if(!mqDesktop.matches){
        const panel = panelsWrap.querySelector('[data-panel="'+tag+'"]');
        if(panel){
          panel.scrollIntoView({behavior:'smooth', block:'start'});
        }
      }
    });
  });

  window.addEventListener('resize', updateUnderline);
  init();
})();
</script>
