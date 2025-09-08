<?php
/* ======================================================================
   БАЗА: отключения, меню, CPT, шорткоды
   ====================================================================== */

add_filter('use_block_editor_for_post', '__return_false'); // без Гутенберга

// Чистим <head> только на фронте
if ( ! is_admin() ) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
}
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

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
   ПРОИЗВОДИТЕЛЬНОСТЬ И ПОРЯДОК (только фронт!)
   ====================================================================== */

// Всё, что ниже — только фронт
if ( ! is_admin() ) {

	/* 0) Мини-стаб wp.i18n */
	add_action('wp_head', function(){ ?>
	<script>
	window.wp=window.wp||{};window.wp.i18n=window.wp.i18n||{__:function(s){return s;},_x:function(s){return s;},_n:function(s){return s;},_nx:function(s){return s;},sprintf:function(){try{return arguments[0]||''}catch(e){return''}}};
	</script>
	<?php }, 0);

	/* 1) jQuery (head) + migrate */
	add_action('wp_enqueue_scripts', function(){
		wp_deregister_script('jquery');
		wp_register_script('jquery', includes_url('js/jquery/jquery.min.js'), array(), null, false);
		wp_enqueue_script('jquery');
		if (!wp_script_is('jquery-migrate','registered')) {
			wp_register_script('jquery-migrate', includes_url('js/jquery/jquery-migrate.min.js'), array('jquery'), null, false);
		}
		wp_enqueue_script('jquery-migrate');
	}, 1);

	/* 2) Пакеты WP */
	add_action('wp_enqueue_scripts', function(){
		wp_enqueue_script('wp-i18n');
		wp_enqueue_script('wp-hooks');
	}, 5);

	/* 3) CF7 всегда */
	add_filter('wpcf7_load_js','__return_true');
	add_filter('wpcf7_load_css','__return_true');

	/* ... (оставляем ваш CF7 + Autoptimize код как есть, только в блоке !is_admin ) ... */

}

/* ====================================================================== */
// Закрывающий тег! Не убирать!
?>
