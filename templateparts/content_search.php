<div id="content_section" class="content_search">
	<div class="center_wrap">
		<?php if ( have_posts() ) : ?>
			<h1 class="page_title"><?php printf( __( 'Результаты поиска по сайту: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<ol>
				<?php while (have_posts()) : the_post(); ?>
				<li>
				<p class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php $title = get_the_title(); $keys = explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title); echo $title; ?>
				</a></p>
				<?php $excerpt = get_the_excerpt(); $keys = explode(" ",$s); $excerpt = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $excerpt); echo $excerpt; ?>
				</li>
				<?php endwhile; ?>
			</ol>	
		<?php else : ?>
			<h2>По данному запросу ничего не найдено</h2>
		<?php endif; ?>
	</div><!--/.center_wrap-->
</div><!--/#content_section-->