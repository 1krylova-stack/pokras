<?php
add_filter('use_block_editor_for_post', '__return_false');
// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

remove_action( 'wp_head', 'rsd_link' ); 
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );

function footer_enqueue_scripts(){
	remove_action('wp_head','wp_print_scripts');
	remove_action('wp_head','wp_print_head_scripts',9);
	remove_action('wp_head','wp_enqueue_scripts',1);
	add_action('wp_footer','wp_print_scripts',5);
	add_action('wp_footer','wp_enqueue_scripts',5);
	add_action('wp_footer','wp_print_head_scripts',5);
}
add_action('after_setup_theme','footer_enqueue_scripts');
remove_filter('the_excerpt', 'wpautop');
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 );   
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'content-thumb', 104, 63, true );
	add_image_size( 'article-thumb', 315, 230, true );
}

register_nav_menus( array(  
    'header_menu' => 'Меню в шапке',  
    'footer_menu' => 'Меню в подвале'	
) );

add_action('admin_menu', 'register_custom_menu_page');

function register_custom_menu_page() {
   add_menu_page('Меню', 'Меню', '8', 'nav-menus.php');
 
}

//Новости

	add_action('init', 'codex_custom_init3');
	function codex_custom_init3() 
	{
	  $labels = array(
		'name' => _x('Новости',''),
		'singular_name' => _x('Новости',''),
		'add_new' => _x('Добавить новую', 'news'),
		'add_new_item' => __('Добавить новую'),
		'edit_item' => __('Редактировать'),
		'new_item' => __('Новая'),
		'all_items' => __('Все Новости'),
		'view_item' => __('Просмотреть'),
		'search_items' => __('Поиск'),
		'not_found' =>  __('Не найдено'),
		'not_found_in_trash' => __('Нет новостей в корзине'), 
		'parent_item_colon' => '',
		'menu_name' => 'Новости'

	  );
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 6,
		'supports' => array('title','editor','author','thumbnail','excerpt','comments')
	  ); 
	  register_post_type('news',$args);
	}

add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );
add_filter( 'login_headertitle', create_function('', 'return false;') );

if ( !current_user_can( 'edit_users' ) ) {
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}


add_filter( 'show_admin_bar', '__return_false' );


//Добавляем атрибут title для изображений галерей(атрибут убран начиная с WP 3.5)
function my_image_titles($atts,$img) {
	$atts['title'] = trim(strip_tags( $img->post_content ));
	return $atts;
}
add_filter('wp_get_attachment_image_attributes','my_image_titles',10,2); 

function display_map($attr) {
  return "<div class='map_block'>".get_field('yandex_map', 21)."</div>";
}
add_shortcode('map', 'display_map');


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();	
}
//Page slider shortcode
	function show_slide($atts) {
		$num = (int)$atts['num'] - 1;
		$sliders = get_field('sliders', $post->ID);
		$slider = $sliders[$num];
		$slider = $slider['slider'];
		$slider_html = '<div class="slider_wrap"><div class="content_slider owl-carousel">';
			foreach($slider as $slide):
				$slider_html .= '<div class="item">
									<div class="slide_block">
										<img src="'.$slide["img"].'" alt=""/>
										<p>'.$slide["text"].'</p>
									</div>
								</div>';
			endforeach;
		$slider_html .= '</div></div>';
		return $slider_html;
	}
	add_shortcode( 'slider', 'show_slide');

//Akciya shortcode
	function show_akciya_block() {
		$month = array(
			'января',
			'февраля',
			'марта',
			'апреля',
			'мая',
			'июня',
			'июля',
			'августа',
			'сентября',
			'октября',
			'ноября',
			'декабря'
		);
		$now = time();
		$finish_date = $now + 3*24*60*60;
		$finish_date_month = $month[date('n', $finish_date) - 1];
		$finish_date = date('d', $finish_date).' '.$finish_date_month;
		$akciya_title = get_field('akciya_title','options');
		$akciya_title = str_replace('[date]', '<span class="akciya_date">'.$finish_date.'</span>', $akciya_title);
		$akciya_html = 
		'</div><!--/.center_wrap-->
			<div class="akciya">
				<div class="center_wrap">
					<p class="akciya_title">'.$akciya_title.'</p>
					<p class="block_title">'.get_field('akciya_undertitle', 'options').'</p>'.
					do_shortcode('[contact-form-7 id="182" title="Акция"]').
					'<p>По этому телефону мы свяжемся с Вами для уточнения стоимости ремонта</p>
					<p>Заявка вас ни к чему НЕ обязывает. Отремонтироваться Вы сможете там, где посчитаете нужным.</p>
				</div><!--/.center_wrap-->
			</div><!--/.akciya-->
		<div class="center_wrap">
		';
		return $akciya_html;
	}
	add_shortcode( 'akciya', 'show_akciya_block');
	
//Online calculator shortcode
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

add_filter( 'wpseo_xml_sitemap_img', '__return_false' );


//Ocenka stoimosti form shortcode
	function show_ocenka_form($atts) {
		$html = '<div class="content_form_wrap ocenka_form_wrap" style="margin-bottom: 40px;">'.do_shortcode('[contact-form-7 id="4" title="Главная форма"]').'<p>По этому телефону мастер свяжется с вами для уточнения деталей и сориентирует по стоимости работ</p></div>';
		return $html;
	}
	add_shortcode( 'ocenka_form', 'show_ocenka_form');

// // Добавление функционала метки
function add_tags_to_pages() {
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'add_tags_to_pages');

// Редирект страницы метки на /kuzovnoj-remont/
add_action('template_redirect', function() {
  if (is_tag('kuzovnoj-remont')) {
    wp_redirect(home_url('/kuzovnoj-remont/'), 301);
    exit;
  }
});

// Добавление noindex для страницы метки
add_action('wp_head', function() {
  if (is_tag('kuzovnoj-remont')) {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
  }
});

// Шорткод [brands_catalog] вывод моделей на внутренних страницах
function brands_catalog_shortcode() {
	ob_start();
	get_template_part('templateparts/brands-catalog');
	return ob_get_clean();
}
add_shortcode('brands_catalog', 'brands_catalog_shortcode');

// Шорткод [brands_blok] вывод марок в разделах кузовной ремонт,покраска,ремонт порогов

// Шорткод [diagnostika_block] вывод марок
function show_ocenka_diagnostika_block() {
	ob_start();

	get_template_part( 'templateparts/diagnostika_block' );

	return ob_get_clean();
}
add_shortcode( 'diagnostika_block', 'show_ocenka_diagnostika_block' );


// Шорткод [reviews_map] блок из яндекс отзывов
function show_reviews_map_block() {
	ob_start();

	get_template_part( 'templateparts/reviews_map' );

	return ob_get_clean();
}
add_shortcode( 'reviews_map', 'show_reviews_map_block' );


// Шорткод [pricelist] прайслист аккордеон
function show_pricelist_block() {
	ob_start();
	get_template_part( 'templateparts/pricelist' );

	return ob_get_clean();
}
add_shortcode( 'pricelist', 'show_pricelist_block' );



// Шорткод для блока "услуги ремонта"
function repair_services_shortcode() {
    ob_start(); // начинаем буферизацию вывода
    get_template_part('templateparts/repair_services');
    return ob_get_clean(); // возвращаем html из файла
}
add_shortcode('repair_services', 'repair_services_shortcode');

// Шорткод для блока марки на страницах услуг [marki]
add_shortcode('marki', function($atts){
    ob_start();
    // подключаем твой шаблон
    get_template_part('templateparts/marki');
    return ob_get_clean();
});


//Закрывающий тег! Не убирать!
?>
