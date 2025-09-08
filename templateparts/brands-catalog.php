<?php
// templateparts/brands-catalog.php

global $post;
$args = array(
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
	'post_type'      => 'page',
	'post_parent'    => $post->ID,
	'post_status'    => 'publish',
);
$models = get_posts($args);

if (!empty($models)) : ?>

	<style>
		.brands_catalog_grid {
			display: flex;
			flex-wrap: wrap;
			gap: 20px;
			justify-content: flex-start;
		}

		.brands_catalog_item {
			width: calc(20% - 16px); /* 5 в ряд */
			text-align: center;
			text-decoration: none;
			color: #000;
			position: relative;
		}

		.brands_catalog_item .image_wrap {
			position: relative;
			width: 193px;
			height: 157px;
			margin: 0 auto 5px;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #fff;
			overflow: hidden;
		}

		.brands_catalog_item img {
			max-width: 100%;
			max-height: 100%;
			object-fit: contain;
			display: block;
		}

		.brands_catalog_item .hover_circle {
			position: absolute;
			top: 0;
			left: 50%;
			transform: translateX(-50%);
			width: 193px;
			height: 193px;
			border-radius: 50%;
			background-color: rgba(255, 0, 0, 0.2);
			opacity: 0;
			transition: opacity 0.3s ease;
			pointer-events: none;
			z-index: 2;
		}

		.brands_catalog_item:hover .hover_circle {
			opacity: 1;
		}

		.brands_catalog_item span {
			display: block;
			margin-top: 10px;
			margin-bottom: 20px;
			font-size: 14px;
			position: relative;
			z-index: 1;
		}

		@media (max-width: 1024px) {
			.brands_catalog_item {
				width: calc(33.333% - 14px);
			}
		}

		@media (max-width: 768px) {
			.brands_catalog_item {
				width: calc(50% - 10px);
			}
		}

		@media (max-width: 480px) {
			.brands_catalog_item {
				width: 100%;
			}
		}
	</style>

	<div class="brands_catalog_grid">
		<?php foreach ($models as $model): ?>
			<?php
				$thumb_id = get_post_thumbnail_id($model->ID);
				$thumb_url = $thumb_id
					? wp_get_attachment_image_src($thumb_id, 'medium')[0]
					: get_template_directory_uri() . '/img/default_car.png';
			?>
			<a href="<?php echo get_permalink($model->ID); ?>" class="brands_catalog_item">
				<div class="image_wrap">
					<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($model->post_title); ?>">
					<div class="hover_circle"></div>
				</div>
				<span><?php echo esc_html($model->post_title); ?></span>
			</a>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
