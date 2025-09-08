<div id="blog_section">
	<div class="center_wrap">
		<div class="article_blocks">
			<?php 
				if(is_category(3)):
					$post_num = -1;
				else:
					$post_num = 6;
				endif;
			?>
			<?php query_posts('cat=3&posts_per_page='.$post_num.'&orderby=date&order=DESC'); ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="article_block_wrap">
					<div class="article_block">
						<div class="article_block_img">
							<a href="<?php the_permalink();?>"><?php the_post_thumbnail('article-thumb')?></a>
						</div>
						<div class="article_block_info">
							<p class="article_block_title"><a href="<?php the_permalink();?>"><?php the_title();?></a></p>
							<p class="article_block_text"><?php echo the_excerpt();?></p>
							<a href="<?php the_permalink();?>" class="article_more">Подробнее</a>
						</div>
					</div><!--/.article_block-->
				</div><!--/.article_block_wrap-->
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</div><!--/.article_blocks-->
	</div><!--/.center_wrap-->
</div><!--/#blog_section-->