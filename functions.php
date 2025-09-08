<?php
/* ======================================================================
   БАЗА: отключения, меню, CPT, шорткоды
   ====================================================================== */

add_filter('use_block_editor_for_post', '__return_false'); // без Гутенберга

// Чистим <head>
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);

// excerpt без <p>
remove_filter('the_excerpt', 'wpautop');

// Миниатюры
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(150,150);
}
if (function_exists('add_image_size')) {
	add_image_size('content-thumb', 104, 63, true);
	add_image_size('article-thumb', 315, 230, true);
}

// Меню
register_nav_menus(array(
	'header_menu' => 'Меню в шапке',
	'footer_menu' => 'Меню в подвале'
));

// Пункт «Меню» в админке
add_action('admin_menu', function(){ add_menu_page('Меню','Меню','read','nav-menus.php'); });

// CPT Новости
add_action('init', function(){
	$labels = array(
		'name'=>_x('Новости',''),'singular_name'=>_x('Новости',''),
		'add_new'=>_x('Добавить новую','news'),'add_new_item'=>__('Добавить новую'),
		'edit_item'=>__('Редактировать'),'new_item'=>__('Новая'),
		'all_items'=>__('Все Новости'),'view_item'=>__('Просмотреть'),
		'search_items'=>__('Поиск'),'not_found'=>__('Не найдено'),
		'not_found_in_trash'=>__('Нет новостей в корзине'),'menu_name'=>'Новости'
	);
	$args = array(
		'labels'=>$labels,'public'=>true,'publicly_queryable'=>true,
		'show_ui'=>true,'show_in_menu'=>true,'query_var'=>true,
		'rewrite'=>true,'capability_type'=>'post','has_archive'=>true,
		'hierarchical'=>false,'menu_position'=>6,
		'supports'=>array('title','editor','author','thumbnail','excerpt','comments')
	);
	register_post_type('news',$args);
});

// Логин
add_filter('login_headerurl', function(){ return home_url('/'); });
if (function_exists('__return_empty_string')) {
	add_filter('login_headertitle','__return_empty_string');
	add_filter('login_headertext','__return_empty_string');
}

// Автообновления ядра скрыть для не-админов
if (!current_user_can('edit_users')) {
	add_action('init', function(){ remove_action('init','wp_version_check'); }, 2);
	add_filter('pre_option_update_core', function(){ return null; });
}

// Без админ-бара на фронте
add_filter('show_admin_bar','__return_false');

// title у картинок галерей
add_filter('wp_get_attachment_image_attributes', function($atts,$img){
	$atts['title'] = trim(strip_tags($img->post_content)); return $atts;
},10,2);

// ACF options
if (function_exists('acf_add_options_page')) { acf_add_options_page(); }

/* === Шорткоды (сократил до ваших рабочих) === */
function display_map($a){ return "<div class='map_block'>".get_field('yandex_map',21)."</div>"; }
add_shortcode('map','display_map');

function show_slide($atts){
	global $post;
	$num = isset($atts['num']) ? (int)$atts['num']-1 : 0;
	$sliders = get_field('sliders',$post->ID);
	$slider  = isset($sliders[$num]['slider']) ? $sliders[$num]['slider'] : array();
	$html = '<div class="slider_wrap"><div class="content_slider owl-carousel">';
	foreach($slider as $s){
		$img = !empty($s['img']) ? esc_url($s['img']) : '';
		$txt = !empty($s['text'])? $s['text'] : '';
		$html .= '<div class="item"><div class="slide_block"><img src="'.$img.'" alt=""/><p>'.$txt.'</p></div></div>';
	}
	return $html.'</div></div>';
}
add_shortcode('slider','show_slide');

function show_akciya_block(){
	$m = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	$finish = time()+3*24*60*60; $dt = date('d',$finish).' '.$m[date('n',$finish)-1];
	$title = get_field('akciya_title','options');
	$title = str_replace('[date]','<span class="akciya_date">'.$dt.'</span>',$title);
	return '</div><div class="akciya"><div class="center_wrap">'
		.'<p class="akciya_title">'.$title.'</p>'
		.'<p class="block_title">'.get_field('akciya_undertitle','options').'</p>'
		.do_shortcode('[contact-form-7 id="182" title="Акция"]').'
		<p>По этому телефону мы свяжемся с Вами для уточнения стоимости ремонта</p>
		<p>Заявка вас ни к чему НЕ обязывает. Отремонтироваться Вы сможете там, где посчитаете нужным.</p>
	</div></div><div class="center_wrap">';
}
add_shortcode('akciya','show_akciya_block');

function display_online_calc(){
	$h='</div><div class="content_online_calc">'; ob_start();
	get_template_part('templateparts/big_calc').'<div class="center_wrap">'; $o=ob_get_contents(); ob_end_clean();
	return $h.$o.'</div><div class="center_wrap">';
}
add_shortcode('online_calc','display_online_calc');

add_filter('wpseo_xml_sitemap_img','__return_false');

function show_ocenka_form(){
	return '<div class="content_form_wrap ocenka_form_wrap" style="margin-bottom:40px;">'
		. do_shortcode('[contact-form-7 id="4" title="Главная форма"]')
		. '<p>По этому телефону мастер свяжется с вами для уточнения деталей и сориентирует по стоимости работ</p></div>';
}
add_shortcode('ocenka_form','show_ocenka_form');

add_action('init', function(){ register_taxonomy_for_object_type('post_tag','page'); });
add_action('template_redirect', function(){ if (is_tag('kuzovnoj-remont')) { wp_redirect(home_url('/kuzovnoj-remont/'),301); exit; }});
add_action('wp_head', function(){ if (is_tag('kuzovnoj-remont')) echo '<meta name="robots" content="noindex, nofollow">'."\n"; });

function brands_catalog_shortcode(){ ob_start(); get_template_part('templateparts/brands-catalog'); return ob_get_clean(); }
add_shortcode('brands_catalog','brands_catalog_shortcode');

function show_ocenka_diagnostika_block(){ ob_start(); get_template_part('templateparts/diagnostika_block'); return ob_get_clean(); }
add_shortcode('diagnostika_block','show_ocenka_diagnostika_block');

function show_reviews_map_block(){ ob_start(); get_template_part('templateparts/reviews_map'); return ob_get_clean(); }
add_shortcode('reviews_map','show_reviews_map_block');

function show_pricelist_block(){ ob_start(); get_template_part('templateparts/pricelist'); return ob_get_clean(); }
add_shortcode('pricelist','show_pricelist_block');

function repair_services_shortcode(){ ob_start(); get_template_part('templateparts/repair_services'); return ob_get_clean(); }
add_shortcode('repair_services','repair_services_shortcode');

add_shortcode('marki', function(){ ob_start(); get_template_part('templateparts/marki'); return ob_get_clean(); });


/* ======================================================================
   ПРОИЗВОДИТЕЛЬНОСТЬ И ПОРЯДОК (CF7/Fancybox/Masonry + Autoptimize)
   ====================================================================== */

/* 0) Мини-стаб wp.i18n, чтобы инлайны плагинов не падали раньше пакетов */
add_action('wp_head', function(){ ?>
<script>
window.wp=window.wp||{};window.wp.i18n=window.wp.i18n||{__:function(s){return s;},_x:function(s){return s;},_n:function(s){return s;},_nx:function(s){return s;},sprintf:function(){try{return arguments[0]||''}catch(e){return''}}};
</script>
<?php }, 0);

/* 1) jQuery (head) + jquery-migrate */
add_action('wp_enqueue_scripts', function(){
	if (is_admin()) return;
	wp_deregister_script('jquery');
	wp_register_script('jquery', includes_url('js/jquery/jquery.min.js'), array(), null, false); // head
	wp_enqueue_script('jquery');

	if (!wp_script_is('jquery-migrate','registered')) {
		wp_register_script('jquery-migrate', includes_url('js/jquery/jquery-migrate.min.js'), array('jquery'), null, false);
	}
	wp_enqueue_script('jquery-migrate');
}, 1);

/* 2) Пакеты WP, которые создают window.wp.* */
add_action('wp_enqueue_scripts', function(){
	if (is_admin()) return;
	wp_enqueue_script('wp-i18n');
	wp_enqueue_script('wp-hooks');
}, 5);

/* 3) Грузим CSS/JS CF7 всегда (формы в попапах) */
add_filter('wpcf7_load_js','__return_true');
add_filter('wpcf7_load_css','__return_true');

/* 3.1) CF7: не использовать REST (меньше блокировок), no-cache заголовки и безопасный From */
add_filter('wpcf7_use_rest_api','__return_false');
add_action('init', function () {
	$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	if ((strpos($uri,'/wp-json/contact-form-7/')!==false) || (defined('DOING_AJAX') && DOING_AJAX)) {
		nocache_headers();
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Pragma: no-cache');
	}
}, 0);
add_action('wpcf7_before_send_mail', function($cf7){
	$props = $cf7->prop('mail');
	if (empty($props['sender'])) {
		$domain = parse_url(home_url(), PHP_URL_HOST);
		$props['sender'] = 'no-reply@'.$domain;
		$cf7->set_properties(array('mail'=>$props));
	}
},10,1);

/* 3.2) Жёстко гарантируем порядок: любые скрипты CF7/recaptcha зависят от 'wpcf7' */
add_action('wp_default_scripts', function($scripts){
	if (is_admin()) return;
	if (!isset($scripts->registered['wpcf7'])) return;

	foreach ($scripts->registered as $handle=>$obj) {
		if ($handle==='wpcf7') continue;
		$src = isset($obj->src)? $obj->src : '';
		if ($src && (strpos($src,'contact-form-7')!==false || strpos($src,'wpcf7')!==false || strpos($src,'recaptcha')!==false)) {
			$deps = is_array($obj->deps)? $obj->deps : array();
			if (!in_array('wpcf7',$deps,true)) {
				$deps[]='wpcf7';
				$scripts->registered[$handle]->deps = $deps;
			}
		}
	}
}, 100);

/* 4) Ассеты темы в правильном порядке (футер) */
add_action('wp_enqueue_scripts', function(){
	if (is_admin()) return;
	$u = get_template_directory_uri();

	// Fancybox — попапы
	wp_enqueue_style ('fancybox', $u.'/js/fancybox/jquery.fancybox.css', array(), null);
	wp_enqueue_script('fancybox',  $u.'/js/fancybox/jquery.fancybox.pack.js', array('jquery','jquery-migrate'), null, true);

	// Если используются:
	wp_enqueue_script('owl',    $u.'/js/owl.carousel/owl.carousel.min.js', array('jquery','jquery-migrate'), null, true);
	wp_enqueue_script('masked', $u.'/js/masked.input.js', array('jquery'), null, true);

	// Ядро WP: imagesLoaded + Masonry
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('masonry');

	// Главный скрипт темы — после fancybox
	wp_enqueue_script('theme-main', $u.'/js/main.js', array('jquery','jquery-migrate','fancybox'), null, true);
}, 20);

/* 5) Атрибуты: не деферим критичное; остальным — defer; reCAPTCHA — async+defer */
add_filter('script_loader_tag', function($tag,$handle,$src){
	if (is_admin()) return $tag;

	$nodefer = array(
		'jquery','jquery-core','jquery-migrate',
		'wp-i18n','wp-hooks','wp-util','wp-element',
		'contact-form-7','wpcf7','wpcf7-html5-fallback','wpcf7-recaptcha','fancybox'
	);
	$is_cf7 = (strpos($src,'contact-form-7')!==false) || (strpos($src,'wpcf7')!==false);

	if (in_array($handle,$nodefer,true) || $is_cf7) {
		return '<script src="'.esc_url($src).'"></script>';
	}
	if (strpos($src,'recaptcha/api.js')!==false) {
		return '<script src="'.esc_url($src).'" async defer></script>';
	}
	return '<script src="'.esc_url($src).'" defer></script>';
}, 20, 3);

/* 6) CSS из /s/ не блокирует отрисовку */
add_filter('style_loader_tag', function($html,$handle,$href){
	 if (is_admin()) return $tag;
        if ($handle === 'contact-form-7' || $handle === 'wpcf7') return $tag;
        if (strpos($src, 'recaptcha/api.js') !== false) {
                return '<script src="' . esc_url($src) . '" async defer></script>';
        }
        return '<script src="' . esc_url($src) . '" defer></script>';
}, 10, 3);

/* 7) Постобработка HTML: убрать старый CDN jQuery + подстраховка для /s/*.js|.css */
add_action('template_redirect', function(){
	if (is_admin() || is_feed() || is_preview()) return;
	ob_start(function($html){
		$html = preg_replace('#<script[^>]+src=("|\')[^"\']*ajax\.googleapis\.com[^"\']*jquery[^"\']*\.js[^"\']*\1[^>]*>\s*</script>\s*#i','',$html);
		$html = preg_replace_callback('#<script([^>]*)\bsrc=("|\')([^"\']*/s/[^"\']+?\.js[^"\']*)\2([^>]*)>\s*</script>#i',
			function($m){ return (stripos($m[0],'defer')!==false)?$m[0]:'<script'.$m[1].' src="'.$m[3].'" defer'.$m[4].'></script>';}, $html);
		$html = preg_replace_callback('#<link([^>]*?)\bhref=("|\')([^"\']*/s/[^"\']+?\.css[^"\']*)\2([^>]*?)\brel=("|\')stylesheet\5([^>]*)>#i',
			function($m){ $href=$m[3]; return "<link rel='preload' as='style' href='".esc_url($href)."' onload=\"this.rel='stylesheet'\"><noscript><link rel='stylesheet' href='".esc_url($href)."'></noscript>";}, $html);
		return $html;
	});
});

/* 8) Autoptimize: исключить критичное и НЕ агрегировать инлайны */
add_filter('autoptimize_filter_js_exclude', function($list){
	$more = implode(',', array(
		'jquery.js','jquery.min.js','jquery-migrate.min.js',
		'wp-includes/js/jquery/jquery.js',
		'wp-includes/js/jquery/jquery-migrate.min.js',
		'wp-i18n','wp-hooks','wp-util','wp-element',
		'contact-form-7','wpcf7','wpcf7-recaptcha','wpcf7-html5-fallback',
		'recaptcha','grecaptcha','/recaptcha/',
		'jquery.fancybox','jquery.fancybox.pack.js','/js/fancybox/jquery.fancybox.pack.js',
		'masonry.min.js','imagesloaded.min.js','/masonry','/imagesloaded',
		'/js/main.js'
	));
	return $list ? $list.','.$more : $more;
});
add_filter('autoptimize_filter_js_aggregate_inline','__return_false');

/* === CF7: вернуть нормальный JS и убрать #wpcf7-... === */

/* грузим ассеты CF7 всегда (форма в попапе тоже) */
add_filter('wpcf7_load_js',  '__return_true');
add_filter('wpcf7_load_css', '__return_true');

/* если по какой-то причине CF7 не попал в очередь — добавим сами */
add_action('wp_enqueue_scripts', function () {
	if (is_admin()) return;
	if (wp_script_is('contact-form-7', 'registered') && ! wp_script_is('contact-form-7', 'enqueued')) {
		wp_enqueue_script('contact-form-7');
	}
	if (wp_style_is('contact-form-7', 'registered') && ! wp_style_is('contact-form-7', 'enqueued')) {
		wp_enqueue_style('contact-form-7');
	}
}, 6);

/* НЕ трогаем теги <script> у критичных скриптов (сохраняем type="module" и пр.) */
add_filter('script_loader_tag', function ($tag, $handle, $src) {
	if (is_admin()) return $tag;

	$no_touch = [
		'jquery','jquery-core','jquery-migrate',
		'wp-i18n','wp-hooks','wp-util','wp-element',
		'contact-form-7','wpcf7','wpcf7-html5-fallback','wpcf7-recaptcha',
		'fancybox','imagesloaded','masonry'
	];

	// CF7 и прочие критичные — возвращаем исходный тег без изменений
	if (in_array($handle, $no_touch, true) || strpos($src, 'contact-form-7') !== false) {
		return $tag;
	}

	// reCAPTCHA — async+defer, не ломая прочие атрибуты
	if (strpos($src, 'recaptcha/api.js') !== false) {
		return preg_replace('/<script\b(.*?)src=/', '<script$1 async defer src=', $tag);
	}

	// всем остальным — добавим defer, если его ещё нет
	if (strpos($tag, ' defer') === false) {
		return preg_replace('/<script\b(.*?)src=/', '<script$1 defer src=', $tag);
	}
	return $tag;
}, 20, 3);

/* если вдруг произошёл не-AJAX submit — уберём якорь из адресной строки */
add_action('wp_footer', function(){ ?>
<script>
(function(){ if(/^#wpcf7-f\d+-o\d+$/.test(location.hash)){
  history.replaceState('', document.title, location.pathname + location.search);
}})();
</script>
<?php }, 999);


/* ====================================================================== */
// Закрывающий тег! Не убирать!
?>
