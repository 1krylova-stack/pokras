<div id="pricelist">
	<div class="center_wrap">
		<h2 class="block_title">ПРАЙС-ЛИСТ НА УСЛУГИ НАШЕГО СЕРВИСА</h2>
		<div class="pricelist_wrap">
			<div class="dt pricelist_head">
				<div class="dtc">Услуга</div>
				<div class="dtc">Стоимость</div>
			</div>
			<div class="pricelist_body">
				<?php
					if(get_field('pricelist')):
						$pricelist = get_field('pricelist');
					else:
						$pricelist = get_field('pricelist', 7);
					endif;
					$count = 1;
					foreach($pricelist as $row):
				?>
					<div class="pricelist_block <?php if(1==$count) echo "opened"?>">
						<div class="dt price_list_block_head">
							<div class="dtc"><?php echo $row['title']?></div>
							<div class="dtc"><?php echo $row['summ']?></div>
						</div>
						<div class="price_list_block_body">
							<?php echo $row['content']?>
						</div>
					</div>
				<?php $count++; endforeach?>
			</div>
		</div>
		<a class="button" href="#get_consult">Оценить стоимость ремонта</a>
	</div><!--/.center_wrap-->
</div><!--/#pricelist-->