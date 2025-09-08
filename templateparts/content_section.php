<div id="content_section">
	<div class="center_wrap">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php the_content(''); ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<div class="button_to_center">
			<a class="button" href="#call_order">Получить лучшую цену</a>
		</div>
	</div><!--/.center_wrap-->
</div><!--/#content_section-->