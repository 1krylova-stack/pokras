<div id="main_page_brands">
	<div class="center_wrap">
		<div class="brands_slider_wrap">
			<div class="brands_slider owl-carousel">
				<?php
					if( have_rows('brands', 7) ):
						while ( have_rows('brands', 7) ) : the_row(); ?>
							<div class="item">
								<div class="brand_block">
									<div class="brand_block_img">
										<a href="<?php the_sub_field('link');?>"><img src="<?php the_sub_field('logo');?>" alt=""/></a>
									</div>
									<p class="brand_block_title"><a href="<?php the_sub_field('link');?>"><?php the_sub_field('title');?></a></p>
								</div>
							</div><!--/.item-->
				<?php	endwhile;
					endif;
				?>
			</div><!--/.brands_slider-->
		</div><!--/.brands_slider_wrap-->
	</div><!--/.center_wrap-->
</div><!--/#main_page_brands-->