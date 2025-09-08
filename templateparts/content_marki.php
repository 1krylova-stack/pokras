<?php
// Получаем дочерние страницы
$args = array(
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
	'post_type'      => 'page',
	'post_parent'    => $post->ID,
	'post_status'    => 'publish',
);
$models = get_posts($args);

// Выводим блок только если есть дочерние страницы
if (!empty($models)):
?>
<div id="content_marki">
	<div class="center_wrap">

		<?php get_template_part('templateparts/breadcrumbs'); ?>

		<div class="models_block">

			<div class="models_title" style="font-size: 24px; font-weight: 700; margin-bottom: 20px;">
				Выберите модель автомобиля
			</div>

			<!-- Буллиты в одну строку -->
			<div class="bullets_row" style="display: flex; flex-wrap: wrap; gap: 40px; margin-bottom: 30px; font-size: 14px">
				<div class="bullet_item" style="display: flex; align-items: center; gap: 10px;">
					<img src="<?php bloginfo('template_url'); ?>/img/content_icon_1.png" alt="" />
					<span><strong>Подбор оригинальных запчастей или аналогов на выбор</strong></span>
				</div>
				<div class="bullet_item" style="display: flex; align-items: center; gap: 10px; font-size: 14px">
					<img src="<?php bloginfo('template_url'); ?>/img/content_icon_2.png" alt="" />
					<span><strong>Фотоотчет и согласование каждого этапа</strong></span>
				</div>
			</div>

			<!-- Модели автомобилей -->
			<div class="models_grid" style="display: flex; flex-wrap: wrap; gap: 20px;">
				<?php foreach ($models as $model): ?>
					<?php
						$thumb_id = get_post_thumbnail_id($model->ID);
						$thumb_url = $thumb_id
							? wp_get_attachment_image_src($thumb_id, 'medium')[0]
							: get_template_directory_uri() . '/img/default_car.png';
					?>
					<a href="<?php echo get_permalink($model->ID); ?>" class="model_item" style="width: 150px; text-align: center; text-decoration: none; color: #000;">
						<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($model->post_title); ?>" style="max-width: 100%; height: auto;">
						<span style="display: block; margin-top: 10px;"><?php echo esc_html($model->post_title); ?></span>
					</a>
				<?php endforeach; ?>
			</div>

		</div><!-- /.models_block -->

	</div><!-- /.center_wrap -->
</div><!-- /#content_marki -->
<?php endif; ?>