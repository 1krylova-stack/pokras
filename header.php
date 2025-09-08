<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
		<?php wp_head(); ?>
		<?php 
			if(is_category()): 
		?>
			<title><?php if(get_field('seo_title', 'category_'.$cat)): the_field('seo_title', 'category_'.$cat); else: single_cat_title(); endif;?></title>
			<meta name="description" content="<?php the_field('seo_description', 'category_'.$cat)?>">
			<meta name="keywords" content="<?php the_field('seo_keywords', 'category_'.$cat)?>">
		<?php else:?>
			<?php if(get_field('seo_title')):?>
				<title><?php the_field('seo_title')?></title>
			<?php else:?>
				<title><?php wp_title('');?></title>
			<?php endif;?>
			<?php if(get_field('seo_description')):?>
				<meta name="description" content="<?php the_field('seo_description')?>">
			<?php else:?>
				<meta name="description" content="<?php bloginfo('description')?>">
			<?php endif;?>
			<?php if(get_field('seo_keywords')):?>
				<meta name="keywords" content="<?php the_field('seo_keywords')?>">
			<?php endif;?>
		<?php endif;?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="https://pokrasautospb.ru/favicon.png">
  		<link rel="icon" href="https://pokrasautospb.ru/favicon.png">
		<link rel="stylesheet" href="<?php bloginfo('template_url')?>/css/main.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/js/owl.carousel/assets/owl.carousel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/js/fancybox/jquery.fancybox.css">
		<!--<script src="<?php bloginfo('template_url')?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>-->
		<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '342195700031564');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=342195700031564&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
		
    </head>
    <?php
	$page_classes = '';
	if(!is_front_page()) $page_classes = 'inner_page'; 
	?>
	<body <?php body_class($page_classes)?>>
        <!--[if lt IE 8]>
            <p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="http://browsehappy.com/">обновите браузер</a> для полноценной работы сайта.</p>
        <![endif]-->
        <div class="mobile_menu_wrap">
            <span class="mobile_menu_opener"></span>
            <div class="mobile_menu_block">
                <ul>
                    <?php wp_nav_menu(array('menu' => 'Главное меню', 'container' => '','items_wrap' => '%3$s')); ?>
                    <li><a href="#call_order">Позвонить бесплатно</a></li>
                </ul>
				<div class="dtc vat search_wrap">
					<form method="get" name="searchform" id="searchform"  action="<?php bloginfo('siteurl')?>">
						<input type="text" name="s" id="s" value="" placeholder="Поиск по сайту"/>
						<input id="btnSearch" type="submit" name="submit" value="Поиск" />
					</form>
				</div>
				<div class="dtc vat head_address" itemscope="" itemtype="http://schema.org/Organization">
					<p><span itemprop="address"><?php the_field('head_address', 'options')?></span></p>
				</div>
            </div><!--/.mobile_menu_block-->
        </div>
		<div class="mobile_fixed_phone_wrap">
			
<div class="mobile_fixed_phone_wrap"> <div class="dtc vat head_phone" itemscope="" itemtype="http://schema.org/Organization"> <?php $phone = get_field('phone', 'options'); $phone = str_replace(' ','',$phone)?> <p><a href="tel:<?php echo $phone?>"><span itemprop="telephone"><?php the_field('phone', 'options')?></span></a></p> <span><?php the_field('rezhim', 'options')?></span> </div><!--/.head_phone-->


</div>

		</div>
        <header id="header">
            <div id="top">
                <div class="center_wrap">
                    <div class="dt">
                        <div class="dtc vat head_logo">
                            <a href="/"><p>Покраска <span>Авто</span></p><span>Честный кузовной ремонт<br>с гарантией 1 год.</span></a>
                        </div>
                        <div class="dtc vat search_wrap">
                            <form method="get" name="searchform" id="searchform"  action="<?php bloginfo('siteurl')?>">
                                <input type="text" name="s" id="s" value="" placeholder="Поиск по сайту"/>
                                <input id="btnSearch" type="submit" name="submit" value="Поиск" />
                            </form>
                        </div>
						<div class="dtc vat ss_icon_link">
                            <a href="whatsapp://send?phone=79673444222"><img src="/wp-content/themes/shablon/img/footer_whatsapp_icon.png"></a>
							<a href="https://vk.com/pokrasautospb"><img src="/wp-content/themes/shablon/img/footer_vk_icon.png"></a>
							<a href="https://www.instagram.com/pokrasautospb.ru/"><img src="/wp-content/themes/shablon/img/footer_instagram_icon.png"></a>
                        </div>
                        <div class="dtc vat head_address" itemscope="" itemtype="http://schema.org/Organization">
                            <p><span itemprop="address"><?php the_field('head_address', 'options')?></span></p>
                        </div>
                        <div class="dtc vat head_phone" itemscope="" itemtype="http://schema.org/Organization">
                            <?php $phone = get_field('phone', 'options'); $phone = str_replace(' ','',$phone)?>
							<p><a href="tel:<?php echo $phone?>"><span itemprop="telephone"><?php the_field('phone', 'options')?></span></a></p>
                            <span><?php the_field('rezhim', 'options')?></span>
                            <a class="call_order" href="/otsenka-kuzovnogo-remonta-po-foto/">Оценка по фото</a>
                        </div><!--/.head_phone-->
                    </div><!--/.dt-->
                </div><!--/.center_wrap-->
            </div><!--/#top-->
            <nav id="main_nav">
                <div class="center_wrap">
                    <ul class="main_menu">
                        <?php wp_nav_menu(array('menu' => 'Главное меню', 'container' => '','items_wrap' => '%3$s')); ?>
                        <!--<li><a href="#call_order">Позвонить бесплатно</a></li>-->
                    </ul>
                </div><!--/.center_wrap-->
            </nav><!--/#main_nav-->
            <?php if(!is_page_template('template-technical.php') and !is_404() and !is_category('6')):?>
			<div id="head_content">
                <div class="center_wrap">
                    <div class="dt head_content">
                        <div class="dtc vab head_content_info">
                            <p class="main_title">
                                <?php if(get_field('main_title')):?>
									<?php the_field('main_title')?>
								<?php else:?>
									<?php the_field('main_title', 7)?>
								<?php endif;?>
							</p>
                            <div class="head_content_benefits">
                                <?php
									if( have_rows('head_benefits') ):
										while ( have_rows('head_benefits') ) : the_row(); ?>
											<p>
												<span class="dt">
													<span class="dtc"><img src="<?php the_sub_field('icon');?>" alt=""></span>
													<span class="dtc"><?php the_sub_field('text');?></span>
												</span>
											</p>
								<?php	endwhile;
									else: 
										while ( have_rows('head_benefits', 7) ) : the_row(); ?>
											<p>
												<span class="dt">
													<span class="dtc"><img src="<?php the_sub_field('icon');?>" alt=""></span>
													<span class="dtc"><?php the_sub_field('text');?></span>
												</span>
											</p>
								<?php	endwhile;	
									endif;
								?>
							</div>
                        </div><!--/.head_content_info-->
                        <div class="dtc vab head_content_video">
                            <!--<a class="head_video_button" href="#video">Посмотрите видео<br>нашей работы</a>-->
                        </div>
                    </div><!--/.head_content-->
                    <div class="head_order">
                        <div class="dt">
                            <div class="dtc vab head_order_block">
                                <p class="head_order_block_title">Оставьте телефон для уточнения стоимости</p>
                                <?php echo do_shortcode('[contact-form-7 id="4" title="Главная форма"]')?>
								<p>Мастер свяжется с вами для уточнения деталей и сориентирует по стоимости работ</p>
                            </div><!--/.head_order_block-->
                            <div class="dtc vab head_order_social">
                                <p>или отправьте <br>фото повреждений</p>
                                <p class="head_order_social_icons">
                                    <a href="https://wa.me/79673444222"><span class="tooltip tooltip-effect-1">
										<img src="<?php bloginfo('template_url')?>/img/head_soc_icon_1.png" alt=""/>
										<span class="tooltip-content clearfix">
											<span class="tooltip-text">
												<?php the_field('whatsapp_notice', 'options')?>
											</span>
										</span>
									</span></a>
									<!-- <span class="tooltip tooltip-effect-1">
										<img src="<?php bloginfo('template_url')?>/img/head_soc_icon_2.png" alt=""/>
										<span class="tooltip-content clearfix">
											<span class="tooltip-text">
												<?php the_field('telegram_notice', 'options')?>
											</span>
										</span>
									</span> -->
								</p>
                            </div>
                        </div><!--/.dt-->
                        <p>Заявка вас ни к чему НЕ обязывает. Отремонтироваться Вы сможете там, где посчитаете нужным.</p>
                    </div><!--/.head_order-->
                </div><!--/.center_wrap-->
            </div><!--/#head_content-->
			<?php endif;?>
			
        </header>