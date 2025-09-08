<?php
// Защита
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<style>
/* Основные стили */
.reviews-map {
	margin: 40px 0;
	font-family: Arial, sans-serif;
}
.reviews-map h2 {
	font-size: 24px;
	margin-bottom: 20px;
}
.rating-block {
	display: flex;
	align-items: center;
	gap: 8px;
	font-size: 14px;
	color: #444;
}
.Label {
	display: inline-flex;
	align-items: center;
}
.Label_size_3xs {
	height: 18px;
	padding: 0 4px;
	font: 500 12px/18px Arial, sans-serif;
	border-radius: 6px;
}
.LabelRating_value_good {
	background: #32ba43;
	color: #fff;
	font-weight: 700;
}
.reviews-map__tags {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 30px;
}
.reviews-map__tag {
	background: #f1f1f1;
	padding: 10px 15px;
	border-radius: 5px;
	font-size: 14px;
	display: flex;
	align-items: center;
	gap: 8px;
}
.reviews-map__slider {
	position: relative;
	background: #fff;
	padding: 20px;
	box-shadow: 0 2px 10px rgba(0,0,0,0.1);
	border-radius: 5px;
	overflow: hidden;
}
.reviews-map__slider-items {
	display: flex;
	gap: 20px;
	overflow-x: auto;
	scroll-snap-type: x mandatory;
	padding-bottom: 10px;
	scroll-behavior: smooth;
}
.reviews-map__slide {
	flex: 0 0 30%;
	min-width: 300px;
	background: #fafafa;
	padding: 15px;
	border-radius: 5px;
	box-shadow: 0 1px 5px rgba(0,0,0,0.05);
	scroll-snap-align: start;
	display: flex;
	flex-direction: column;
	position: relative;
	height: auto;
}
.reviews-map__slide::before {
	content: '';
	position: absolute;
	top: 10px;
	right: 10px;
	display: flex;
	gap: 2px;
}

.reviews-map__stars {
  width: 80px;
  height: 16px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffd633' viewBox='0 0 24 24'%3E%3Cpath d='M12 17.27L18.18 21 16.54 14 22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z'/%3E%3C/svg%3E");
  background-repeat: repeat-x;
  background-size: 16px 16px;
}	
.reviews-map__author {
	display: flex;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
}
.reviews-map__author img {
	width: 32px;
	height: 32px;
	border-radius: 50%;
	object-fit: cover;
}
.reviews-map__author-name {
	font-weight: 700;
	font-size: 14px;
	color: #222;
}
.reviews-map__text {
	font-size: 14px;
	color: #555;
	line-height: 1.4;
	margin-top: 0;
	margin-bottom: 10px;
	align-self: flex-start;
}
.reviews-map__photos {
	display: flex;
	gap: 10px;
	margin-top: 0px;
	flex-wrap: wrap;
	align-items: flex-start;
}
.reviews-map__photos img {
	width: 70px;
	height: 70px;
	object-fit: cover;
	border-radius: 4px;
	cursor: pointer;
	transition: 0.2s;
}
.reviews-map__photos img:hover {
	transform: scale(1.05);
}
.reviews-map__nav {
	position: absolute;
	top: 50%;
	left: 0;
	right: 0;
	transform: translateY(-50%);
	display: flex;
	justify-content: space-between;
	pointer-events: none;
	padding: 0 10px; /* немного отступа от краёв */
	box-sizing: border-box;
}

.reviews-map__arrow {
	pointer-events: auto;
	width: 40px;
	height: 40px;
	background: rgba(0,0,0,0.4);
	border: none;
	color: #fff;
	font-size: 24px;
	cursor: pointer;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: background 0.3s;
}

.reviews-map__arrow:hover {
	background: rgba(0,0,0,0.6);
}

@media(max-width: 1024px) {
	.reviews-map__slide {
		flex: 0 0 45%;
	}
}
@media(max-width: 768px) {
	.reviews-map__slide {
		flex: 0 0 90%;
	}
}
@media (max-width: 768px) {
	.reviews-map__arrow {
		width: 32px;
		height: 32px;
		font-size: 18px;
		background: rgba(0, 0, 0, 0.3);
	}

	.reviews-map__nav {
		padding: 0 5px;
	}
}
/* Попап */
#photo-popup {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.8);
	display: none;
	justify-content: center;
	align-items: center;
	z-index: 1000;
}
#photo-popup img {
	max-width: 90%;
	max-height: 90%;
	border-radius: 8px;
}	
	
</style>

<div class="reviews-map">
	<h2>Отзывы на картах</h2>
	<div class="rating-block">
	  <div class="Label LabelRating LabelRating_value_good Label_size_3xs OrgHeader-Rating">
		<span class="A11yHidden">Рейтинг 4,4 </span>
	  </div>
	  <div>22 отзыва</div>
	</div>
	<div class="reviews-map__tags">
		<div class="reviews-map__tag">
			<img src="/wp-content/uploads/2025/07/LikeOutline.png" alt="ремонт" width="16" height="16">
			<span>Ремонт — 12 отзывов</span>
		</div>
		<div class="reviews-map__tag">
			<img src="/wp-content/uploads/2025/07/LikeOutline.png" alt="ожидание" width="16" height="16">
			<span>Время ожидания — 100%, 11 отзывов</span>
		</div>
	</div>
	<div class="reviews-map__slider">
		<div class="reviews-map__slider-items" id="slider-track">
			<!-- Отзывы -->
			
			<!-- 1. Ирина К. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/20706/enc-e45735a5e1003ede498233ad7d6d484eb5ea54e02f6c3a7c74a9b4320776e95a/islands-middle" alt="Аватар Ирина К.">
					<div class="reviews-map__author-name">Ирина К.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Потрясающие ребята! Я в восторге от их подхода к работе. Давно такого не видела среди мастеров. Привезла на покраску бампер, был треснутый с обеих сторон, краска сколота, грустное зрелище. <span class="reviews-map__toggle">... Читать далее</span> Забрала через четыре дня новый и сверкающий. В подарок мне еще лючок сделали, крыло подмазали и наполировали машинку. Цены дешевле, чем по городу. Ничего сверху оговоренного не взяли. Была в приятном удивлении. Однозначно рекомендую. И, как оказалось, ребята делают не только покраску, а любой ремонт.
				</div>
				<div class="reviews-map__photos">
					<img src="https://avatars.mds.yandex.net/get-altay/15288852/2a00000197321c96d5efafe2d9365a0ce1f4/L" alt="Фото из отзыва Ирины 1">
					<img src="https://avatars.mds.yandex.net/get-altay/15461420/2a00000197321c95dcfe8a63bb481efe8409/L" alt="Фото из отзыва Ирины 2">
					<img src="https://avatars.mds.yandex.net/get-altay/15467240/2a00000197321c960a6a909e904f708bb3b5/L" alt="Фото из отзыва Ирины 3">
					<img src="https://avatars.mds.yandex.net/get-altay/16417401/2a00000197321c96413c00c0dfdd25cfada0/L" alt="Фото из отзыва Ирины 4">
				</div>
			</div>

			<!-- 2. Александра С. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/35885/1EunklgM9d6jajJo2rKSr89gbA-1/islands-middle" alt="Аватар Александра С.">
					<div class="reviews-map__author-name">Александра С.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Прекрасно вытянули и покрасили крышку багажника, быстро и качественно.
				</div>
				<div class="reviews-map__photos">
					<img src="https://avatars.mds.yandex.net/get-altay/10768168/2a000001915be5caa102985c9c1993cfd1a8/L" alt="Фото из отзыва Александры 1">
					<img src="https://avatars.mds.yandex.net/get-altay/11419181/2a000001915be5d0bb5a2902415438ecf733/L" alt="Фото из отзыва Александры 2">
					<img src="https://avatars.mds.yandex.net/get-altay/14093322/2a000001915be5c54c0ed7a7e8dcd15eb696/L" alt="Фото из отзыва Александры 3">
					<img src="https://avatars.mds.yandex.net/get-altay/9830591/2a000001915be5d62c2204e2a1ac6f0f0a96/L" alt="Фото из отзыва Александры 4">
				</div>
			</div>

			<!-- 3. Егор К. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/59871/ZBs9soi2Nfi2vdl9yeAVlK0A-1/islands-middle" alt="Аватар Егор К.">
					<div class="reviews-map__author-name">Егор К.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Люди мастера своего дела, отлично сделали по демократичной цене, буду рекомендовать своим знакомым.
				</div>
				<div class="reviews-map__photos">
					<img src="https://avatars.mds.yandex.net/get-altay/13206104/2a00000195766fbd17067e126d3cbabbdc46/L" alt="Фото из отзыва Егора 1">
					<img src="https://avatars.mds.yandex.net/get-altay/14763372/2a00000195766eff97daf961400ca18b2e4b/L" alt="Фото из отзыва Егора 2">
					<img src="https://avatars.mds.yandex.net/get-altay/14922087/2a000001957670a3a98ff8c4aa77c383b2a1/L" alt="Фото из отзыва Егора 3">
					<img src="https://avatars.mds.yandex.net/get-altay/15232272/2a00000195766f9c47ecf6c03ad2a7d7bf7d/L" alt="Фото из отзыва Егора 4">
				</div>
			</div>

			
			<!-- 4. Анастасия Зеброва -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/59871/0o-7/islands-middle" alt="Аватар Анастасия Зеброва">
					<div class="reviews-map__author-name">Анастасия Зеброва</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Обращалась с вмятиной и царапиной - работу выполнили за 2 дня, идеально подобрали цвет (на секундочку, цвет красный с шиммером - в другой мастерской мне даже не смогли подобрать пигмент). Цены демократичные, владелец ответственный и приятный человек. До сих пор в восторге! Перед обращением, лучше позвонить по телефону.
				</div>
			</div>

			<!-- 5. Юрий Б. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/0/0-0/islands-middle" alt="Аватар Юрий Б.">
					<div class="reviews-map__author-name">Юрий Б.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Ремонтировался на Новомалиновской 15. Устранял глубокую вмятину на двери багажника. Выправили и покрасили отлично, следов ремонта не видно, как будто ничего и не было. Стоимость - самая низкая в городе. До этого отправлял фото в десяток сервисов, разброс цен - в три с лишним раза! Причем, там где цена ниже, запись на две недели вперед. Сюда же можно приехать в тот же день.
				</div>
			</div>

			<!-- 6. Николай Г. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/45131/0y-4/islands-middle" alt="Аватар Николай Г.">
					<div class="reviews-map__author-name">Николай Г.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Место не очень презентабельное, но подобрали цвет краски и выполнили работы отлично. Все исполнили в оговоренные сроки и по согласованной цене. Могу рекомендовать.
				</div>
			</div>

			<!-- 7. Anastasia P. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/49368/LTxnNt9jt5T4ZAQffq7MbFAshc-1/islands-middle" alt="Аватар Anastasia P.">
					<div class="reviews-map__author-name">Anastasia P.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Меняла и красила бампер, работой довольна. Все в срок, и как договаривались.
				</div>
			</div>

			
			<!-- 8. Китаева Наталья -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/39727/VSZXOAB8K3tVL1qKF83PnZu2E-1/islands-middle" alt="Аватар Китаева Наталья">
					<div class="reviews-map__author-name">Китаева Наталья</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					Ремонтировала бампер, сделали все качественно, точное попадание в цвет, как новый. Цена очень доступная!
				</div>
			</div>

			
			<!-- 9. Евгений Смола -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/48449/zIXMdMW2tfsnmZo1QIg5B5iEw-1/islands-middle" alt="Аватар Евгений Смола">
					<div class="reviews-map__author-name">Евгений Смола</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Остался доволен работой. Удалили глубокую вмятину на задней двери и крыле, заодно покрасил бампер и переднее крыло со сколом. Сделали качественно, точно в срок и по цене, которая меня вполне устроила. Рекомендую этот сервис."
				</div>
			</div>

			<!-- 10. Майкл Джордан -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/36777/y0ICwe543ULgLJg6JxcBmQWzc-1/islands-middle" alt="Аватар Майкл Джордан">
					<div class="reviews-map__author-name">Майкл Джордан</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Работают граждане ближнего зарубежья, качество через раз бывает очень даже неплохо, а бывает могло быть и лучше. Рядом есть достойные альтернативы, цены умеренные."
				</div>
			</div>

			<!-- 11. Саша Л. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/24700/enc-8031e2250dc1c2f1b4695bdcf28d99c3/islands-middle" alt="Аватар Саша Л.">
					<div class="reviews-map__author-name">Саша Л.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Ремонтировали авто после аварии (с жопой была жопа)), результат супер за небольшие деньги и за короткое время, рекомендую!"
				</div>
			</div>

			<!-- 12. Андрей Т. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/21377/enc-ca4a13930ad1082883e7b6987e34ed3a75e174156018245c4cfe7b34b4e2e489/islands-middle" alt="Аватар Андрей Т.">
					<div class="reviews-map__author-name">Андрей Т.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Покрасили бампер, заварили мелкую трещину. 2,5 рабочих дня, бампер как новый. Ценик средний."
				</div>
			</div>

			<!-- 13. Никита Тертичный -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/45848/7LMFsY94c6iZB1UxWtkcPotVcjE-1/islands-middle" alt="Аватар Никита Тертичный">
					<div class="reviews-map__author-name">Никита Тертичный</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Отличное место, отдельно порадовали цены и скорость работ. У других намного дороже."
				</div>
			</div>

			<!-- 14. александр п. -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/36689/0u-7/islands-middle" alt="Аватар александр п.">
					<div class="reviews-map__author-name">александр п.</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Потрясающе! С виду такая невзрачная контора, но работают настоящие мастера! Сдал в ремонт свою "ласточку" с разбитой жопой- получил идеально отремонтированную, даже следов ремонта не найти! Мастера! Спасибо!"
				</div>
			</div>

			<!-- 15. Евгений Клапов -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/50595/htsdVRoFnuoIRra70CT7W5jGmw-1/islands-middle" alt="Аватар Евгений Клапов">
					<div class="reviews-map__author-name">Евгений Клапов</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Веселые ребята. Дорога к ним, хорошая проверка вашей подвески."
				</div>
			</div>

			<!-- 16. Арам Грайрович -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/53031/0r-7/islands-middle" alt="Аватар Арам Грайрович">
					<div class="reviews-map__author-name">Арам Грайрович</div>
				</div>
				<div class="reviews-map__text">
					"Золотые руки просто."
				</div>
				<div class="reviews-map__photos">
					<img src="https://avatars.mds.yandex.net/get-altay/11393517/2a0000018dc249c720d1b2be2835ee26445e/L" alt="Фото из отзыва Арама 1">
					<img src="https://avatars.mds.yandex.net/get-altay/367090/2a0000018dc249822904261bc64ea9a3564d/L" alt="Фото из отзыва Арама 2">
				</div>
			</div>

			<!-- 17. Дмитрий -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/37154/0k-8/islands-middle" alt="Аватар Дмитрий">
					<div class="reviews-map__author-name">Дмитрий</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Быстро, не слишком дорого. Качество на уровне."
				</div>
			</div>

			<!-- 18. Инкогнито 9367 -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/47747/0h-2/islands-middle" alt="Аватар Инкогнито 9367">
					<div class="reviews-map__author-name">Инкогнито 9367</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Хороший 👍мастера."
				</div>
				<div class="reviews-map__photos">
					<img src="https://avatars.mds.yandex.net/get-altay/14110197/2a000001918ea61f7beb94b0a7708f782d63/L" alt="Фото из отзыва Инкогнито">
				</div>
			</div>

			<!-- 19. Muxriddin Ergashev -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/54535/0h-6/islands-middle" alt="Аватар Muxriddin Ergashev">
					<div class="reviews-map__author-name">Muxriddin Ergashev</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Хорошее место."
				</div>
			</div>

			<!-- 20. Арам Саргсян -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/0/0-0/islands-middle" alt="Аватар Арам Саргсян">
					<div class="reviews-map__author-name">Арам Саргсян</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Очень давольно красили отлично."
				</div>
			</div>

			<!-- 21. Хусаинов Усмон -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/27232/lRvVJ0IgPeE961dSPDDeuehto8-1/islands-middle" alt="Аватар Хусаинов Усмон">
					<div class="reviews-map__author-name">Хусаинов Усмон</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Очень хороший сервис рекомендую 👍."
				</div>
			</div>

			<!-- 22. Вячеслав Спиридонов -->
			<div class="reviews-map__slide">
				<div class="reviews-map__author">
					<img src="https://avatars.mds.yandex.net/get-yapic/62162/enc-56622f92851a8c4651ba34a1c302ec926149fa8ab3f8a924000dc7a1e9ba2f39/islands-middle" alt="Аватар Вячеслав Спиридонов">
					<div class="reviews-map__author-name">Вячеслав Спиридонов</div>
					<div class="reviews-map__stars"></div>
				</div>
				<div class="reviews-map__text">
					"Супер."
				</div>
			</div>

		</div>
		<div class="reviews-map__nav">
			<button class="reviews-map__arrow" id="prev-btn">&#10094;</button>
			<button class="reviews-map__arrow" id="next-btn">&#10095;</button>
		</div>
	</div>
</div>

<div id="photo-popup" onclick="this.style.display='none'">
	<img src="" alt="Фото отзыва" id="popup-img">
</div>

<script>
document.querySelectorAll('.reviews-map__photos img').forEach(img => {
	img.addEventListener('click', () => {
		const popup = document.getElementById('photo-popup');
		const popupImg = document.getElementById('popup-img');
		popupImg.src = img.src;
		popup.style.display = 'flex';
	});
});

const slider = document.getElementById('slider-track');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const slideWidth = 320; // примерно ширина слайда + gap

prevBtn.addEventListener('click', () => {
	slider.scrollBy({ left: -slideWidth, behavior: 'smooth' });
});

nextBtn.addEventListener('click', () => {
	slider.scrollBy({ left: slideWidth, behavior: 'smooth' });
});
	

	
</script>