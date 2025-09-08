<?php
// Отключаем Гутенберг
add_filter('use_block_editor_for_post', '__return_false');

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);

// Перенос скриптов в футер (как у вас было)
function footer_enqueue_scripts(){
	remove_action('wp_head','wp_print_scripts');
	remove_action('wp_head','wp_print_head_scripts',9);
	remove_action('wp_head','wp_enqueue_scripts',1);
	add_action('wp_footer','wp_print_scripts',5);
	add_action('wp_footer','wp_enqueue_scripts',5);
	add_action('wp_footer','wp_print_head_scripts',5);
}
add_action('after_setup_theme','footer_enqueue_scripts');

// Убираем авто-p в excerpt
remove_filter('the_excerpt', 'wpautop');

// Миниатюры
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150 );
}
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'content-thumb', 104, 63, true );
	add_image_size( 'article-thumb', 315, 230, true );
}

// Меню
register_nav_menus( array(
	'header_menu' => 'Меню в шапке',
	'footer_menu' => 'Меню в подвале'
) );

// Пункт «Меню» в админке
add_action('admin_menu', 'register_custom_menu_page');
function register_custom_menu_page() {
	add_menu_page('Меню', 'Меню', 'read', 'nav-menus.php');
}

// === Кастомный тип «Новости» ===
add_action('init', 'codex_custom_init3');
function codex_custom_init3() {
	$labels = array(
		'name'               => _x('Новости',''),
		'singular_name'      => _x('Новости',''),
		'add_new'            => _x('Добавить новую', 'news'),
		'add_new_item'       => __('Добавить новую'),
		'edit_item'          => __('Редактировать'),
		'new_item'           => __('Новая'),
		'all_items'          => __('Все Новости'),
		'view_item'          => __('Просмотреть'),
		'search_items'       => __('Поиск'),
		'not_found'          => __('Не найдено'),
		'not_found_in_trash' => __('Нет новостей в корзине'),
		'menu_name'          => 'Новости'
	);
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
	);
	register_post_type('news',$args);
}

// Логин: ссылка на главную и пустой title
add_filter('login_headerurl', function(){ return home_url('/'); });
if (function_exists('__return_empty_string')) {
	add_filter('login_headertitle', '__return_empty_string');
	add_filter('login_headertext', '__return_empty_string');
}

// Скрываем авто-обновления ядра для неадминов
if ( !current_user_can( 'edit_users' ) ) {
	add_action( 'init', function () {
		remove_action( 'init', 'wp_version_check' );
	}, 2 );
	add_filter( 'pre_option_update_core', function () { return null; } );
}

// Прячем админ-бар на фронте
add_filter( 'show_admin_bar', '__return_false' );

// Добавляем атрибут title для изображений галерей
function my_image_titles($atts,$img) {
	$atts['title'] = trim(strip_tags( $img->post_content ));
	return $atts;
}
add_filter('wp_get_attachment_image_attributes','my_image_titles',10,2);

// Шорткод карты
function display_map($attr) {
	return "<div class='map_block'>".get_field('yandex_map', 21)."</div>";
}
add_shortcode('map', 'display_map');

// ACF options
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

// Шорткод слайдера страницы
function show_slide($atts) {
	global $post;
	$num = isset($atts['num']) ? (int)$atts['num'] - 1 : 0;
	$sliders = get_field('sliders', $post->ID);
	$slider = isset($sliders[$num]['slider']) ? $sliders[$num]['slider'] : array();
	$slider_html = '<div class="slider_wrap"><div class="content_slider owl-carousel">';
	foreach($slider as $slide){
		$img  = !empty($slide["img"]) ? esc_url($slide["img"]) : '';
		$text = !empty($slide["text"]) ? $slide["text"] : '';
		$slider_html .= '<div class="item">
			<div class="slide_block">
				<img src="'.$img.'" alt=""/>
				<p>'.$text.'</p>
			</div>
		</div>';
	}
	$slider_html .= '</div></div>';
	return $slider_html;
}
add_shortcode( 'slider', 'show_slide' );

// Шорткод «Акция»
function show_akciya_block() {
	$month = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	$now = time();
	$finish_date = $now + 3*24*60*60;
	$finish_date_month = $month[date('n', $finish_date) - 1];
	$finish_date = date('d', $finish_date).' '.$finish_date_month;
	$akciya_title = get_field('akciya_title','options');
	$akciya_title = str_replace('[date]', '<span class="akciya_date">'.$finish_date.'</span>', $akciya_title);
	$akciya_html =
	'</div><!--/.center_wrap-->
		<div class="акция akciya">
			<div class="center_wrap">
				<p class="akciya_title">'.$akciya_title.'</p>
				<p class="block_title">'.get_field('akciya_undertitle', 'options').'</p>'.
				do_shortcode('[contact-form-7 id="182" title="Акция"]').'
				<p>По этому телефону мы свяжемся с Вами для уточнения стоимости ремонта</p>
				<p>Заявка вас ни к чему НЕ обязывает. Отремонтироваться Вы сможете там, где посчитаете нужным.</p>
			</div><!--/.center_wrap-->
		</div><!--/.акция-->
	<div class="center_wrap">
	';
	return $akciya_html;
}
add_shortcode( 'akciya', 'show_akciya_block' );

// Шорткод онлайн-калькулятора
function display_online_calc($attr) {
	$online_calc_html = '</div><!--/.center_wrap-->';
	$online_calc_html .= '<div class="content_online_calc">';
	ob_start();
	get_template_part('templateparts/big_calc').'<div class="center_wrap">';
	$output = ob_get_contents();
	ob_end_clean();
	$online_calc_html .= $output;
	$online_calc_html .= '</div><!--/.content_online_calc-->';
	$online_calc_html .= '<div class="center_wrap">';
	return $online_calc_html;
}
add_shortcode('online_calc', 'display_online_calc');

// Yoast: отключить изображения в sitemap
add_filter( 'wpseo_xml_sitemap_img', '__return_false' );

// Шорткод формы «Оценка стоимости»
function show_ocenka_form($atts) {
	$html = '<div class="content_form_wrap ocenka_form_wrap" style="margin-bottom: 40px;">'.do_shortcode('[contact-form-7 id="4" title="Главная форма"]').'<p>По этому телефону мастер свяжется с вами для уточнения деталей и сориентирует по стоимости работ</p></div>';
	return $html;
}
add_shortcode( 'ocenka_form', 'show_ocenka_form' );

// Метки для страниц
function add_tags_to_pages() {
	register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'add_tags_to_pages');

// Редирект метки на /kuzовnoj-remont/
add_action('template_redirect', function() {
	if (is_tag('kuzovnoj-remont')) {
		wp_redirect(home_url('/kuzovnoj-remont/'), 301);
		exit;
	}
});

// noindex для страницы метки
add_action('wp_head', function() {
	if (is_tag('kuzovnoj-remont')) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}
});

// [brands_catalog]
function brands_catalog_shortcode() {
	ob_start();
	get_template_part('templateparts/brands-catalog');
	return ob_get_clean();
}
add_shortcode('brands_catalog', 'brands_catalog_shortcode');

// [diagnostika_block]
function show_ocenka_diagnostika_block() {
	ob_start();
	get_template_part( 'templateparts/diagnostika_block' );
	return ob_get_clean();
}
add_shortcode( 'diagnostika_block', 'show_ocenka_diagnostika_block' );

// [reviews_map]
function show_reviews_map_block() {
	ob_start();
	get_template_part( 'templateparts/reviews_map' );
	return ob_get_clean();
}
add_shortcode( 'reviews_map', 'show_reviews_map_block' );

// [pricelist]
function show_pricelist_block() {
	ob_start();
	get_template_part( 'templateparts/pricelist' );
	return ob_get_clean();
}
add_shortcode( 'pricelist', 'show_pricelist_block' );

// [repair_services]
function repair_services_shortcode() {
	ob_start();
	get_template_part('templateparts/repair_services');
	return ob_get_clean();
}
add_shortcode('repair_services', 'repair_services_shortcode');

// [marki]
add_shortcode('marki', function($atts){
	ob_start();
	get_template_part('templateparts/marki');
	return ob_get_clean();
});


/* ================== PAGESPEED: порядок, правка тегов, ленивая 3rd-party ================== */

/* jQuery из ядра WP — РАНО в <head> (агрегатор /s/*.js тогда не тянет CDN-версию) */
add_action('wp_enqueue_scripts', function () {
	if (is_admin()) return;
	wp_deregister_script('jquery');
	wp_register_script('jquery', includes_url('js/jquery/jquery.min.js'), [], null, false); // false => head
	wp_enqueue_script('jquery');
}, 1);

/* Всем скриптам — defer, reCAPTCHA — async+defer */
add_filter('script_loader_tag', function ($tag, $handle, $src) {
	if (is_admin()) return $tag;
	if (strpos($src, 'recaptcha/api.js') !== false) {
		return '<script src="' . esc_url($src) . '" async defer></script>';
	}
	return '<script src="' . esc_url($src) . '" defer></script>';
}, 10, 3);

/* /s/*.css => preload + noscript (не блокирует отрисовку) */
add_filter('style_loader_tag', function ($html, $handle, $href) {
	if (is_admin()) return $html;
	if (strpos($href, '/s/') !== false && preg_match('~\.css(\?|$)~i', $href)) {
		$pre = "<link rel='preload' as='style' href='" . esc_url($href) . "' onload=\"this.rel='stylesheet'\">";
		return $pre . "<noscript><link rel='stylesheet' href='" . esc_url($href) . "'></noscript>";
	}
	return $html;
}, 10, 3);

/* FORCED HTML POST-PROCESSING:
   — удаляем jQuery с ajax.googleapis.com,
   — добавляем defer к /s/*.js,
   — делаем preload для /s/*.css,
   — reCAPTCHA => async+defer  */
add_action('template_redirect', function () {
	if (is_admin() || is_feed() || is_preview()) return;
	ob_start(function ($html) {
		// Удалить CDN jQuery
		$html = preg_replace(
			'#<script[^>]+src=("|\')[^"\']*ajax\.googleapis\.com[^"\']*jquery[^"\']*\.js[^"\']*\1[^>]*>\s*</script>\s*#i',
			'',
			$html
		);

		// reCAPTCHA => async+defer
		$html = preg_replace_callback(
			'#<script([^>]*)\bsrc=("|\')([^"\']*recaptcha/api\.js[^"\']*)\2([^>]*)>\s*</script>#i',
			function($m){ return '<script'.$m[1].' src="'.$m[3].'" async defer'.$m[4].'></script>'; },
			$html
		);

		// /s/*.js => defer
		$html = preg_replace_callback(
			'#<script([^>]*)\bsrc=("|\')([^"\']*/s/[^"\']+?\.js[^"\']*)\2([^>]*)>\s*</script>#i',
			function($m){ return (stripos($m[0],'defer')!==false) ? $m[0] : '<script'.$m[1].' src="'.$m[3].'" defer'.$m[4].'></script>'; },
			$html
		);

		// /s/*.css => preload (любой порядок атрибутов)
		$html = preg_replace_callback(
			'#<link([^>]*?)\bhref=("|\')([^"\']*/s/[^"\']+?\.css[^"\']*)\2([^>]*?)\brel=("|\')stylesheet\5([^>]*)>#i',
			function($m){
				$href = $m[3];
				$pre  = "<link rel='preload' as='style' href='".esc_url($href)."' onload=\"this.rel='stylesheet'\">";
				$nos  = "<noscript><link rel='stylesheet' href='".esc_url($href)."'></noscript>";
				return $pre.$nos;
			},
			$html
		);

		return $html;
	});
});

/* (2) reCAPTCHA «лениво»: оставляем плагин, но форсим загрузку на idle/первое действие (безопасно) */
add_action('wp_footer', function(){ ?>
<script>
(function(w,d){
  // если API уже на странице — ничего не делаем
  if ([].some.call(d.scripts, s => /recaptcha\/api\.js/.test(s.src))) return;

  var loaded=false;
  function loadRecaptcha(){
    if(loaded) return; loaded=true;
    var s=d.createElement('script');
    // Плагин CF7 обычно сам подставляет ключ через свой тег; этот скрипт — запасной вариант
    s.src='https://www.google.com/recaptcha/api.js';
    s.async=true; s.defer=true;
    d.head.appendChild(s);
  }
  w.addEventListener('load', function(){ if('requestIdleCallback'in w){ requestIdleCallback(loadRecaptcha,{timeout:5000}); } setTimeout(loadRecaptcha,4000); });
  d.addEventListener('focusin', function(e){ if(e.target && e.target.tagName==='INPUT'){ loadRecaptcha(); } }, {passive:true});
})(window, document);
</script>
<?php }, 99);

/* (4) Ленивая подгрузка Fancybox и Masonry по факту наличия элементов (чтобы не грузить везде) */
add_action('wp_footer', function(){
	$theme_uri = esc_url( get_template_directory_uri() );
	?>
<script>
(function(w,d){
  function loadJS(u){ var s=d.createElement('script'); s.src=u; s.defer=true; d.body.appendChild(s); }
  function loadCSS(u){ var l=d.createElement('link'); l.rel='preload'; l.as='style'; l.href=u; l.onload=function(){this.rel='stylesheet'}; d.head.appendChild(l); }

  w.addEventListener('load', function(){

    // Fancybox: если есть галерея (ссылки с классом .fancybox_gallery или атрибут [data-fancybox])
    if (d.querySelector('.fancybox_gallery, [data-fancybox]')) {
      loadCSS('<?php echo $theme_uri; ?>/js/fancybox/jquery.fancybox.css');
      loadJS ('<?php echo $theme_uri; ?>/js/fancybox/jquery.fancybox.pack.js');
    }

    // Masonry: если есть сетка
    if (d.querySelector('.masonry, .masonry-grid, .grid')) {
      loadJS('<?php echo $theme_uri; ?>/js/masonry.js');
    }

  }, {once:true});
})(window, document);
</script>
	<?php
}, 100);

/* ================== /PAGESPEED ================== */

// Закрывающий тег! Не убирать!
?>
