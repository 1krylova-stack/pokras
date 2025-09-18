<div id="contacts">
    <div class="dt">
        <div class="dtc contacts_info">
            <div class="section_content">
                <p class="block_title">Доверьте кузовной ремонт профессионалам</p>
                <div itemscope itemtype="http://schema.org/Organization">
                    <ul>
                        <li><span itemprop="address"><?php the_field('footer_address', 'options')?></span></li>
                        <li><span itemprop="telephone"><?php the_field('phone', 'options')?></span></li>
                        <li><span itemprop="email"><?php the_field('email', 'options')?></span></li>
                    </ul>
                </div>
                <p>От качества кузовного ремонта напрямую зависит ваша безопасность и внешний вид автомобиля. Наши специалисты выполняют все работы в строгом соответствии с технологией, а опытные мастера смогут вернуть вашей машине ее первозданный вид.</p>
                <p class="have_questions">Остались вопросы?</p>
                <a class="button" href="#question_order">Задайте их мастеру по ремонту прямо сейчас</a>
            </div><!--/.section_content-->
        </div><!--/.dtc-->
        <div class="dtc contacts_map">
            <div id="map">
                <?php the_field('yandex_map', 'options')?>
            </div>
        </div>
    </div><!--/.dt-->
</div><!--/#contacts-->

<footer id="footer">
    <div class="center_wrap">
        <div class="dt">
            <div class="dtc vat footer_logo">
                <a href="/"><p>Покраска <span>Авто</span> СПб</p><span>Честный кузовной ремонт<br>с гарантией 1 год.</span></a>
                <p class="copyright">Copyright © 2016-<?php echo date('Y')?> ООО «Покрас Авто» <br>Все права защищены</p>
                <a class="conf" href="#conf">Политика конфиденциальности</a>
            </div><!--/.footer_logo-->
            <div class="dtc vat">
                <ul>
                    <?php wp_nav_menu(array('menu' => 'Нижнее меню. Столбец 1', 'container' => '','items_wrap' => '%3$s')); ?>
                </ul>
            </div>
            <div class="dtc vat">
                <ul>
                    <?php wp_nav_menu(array('menu' => 'Нижнее меню. Столбец 2', 'container' => '','items_wrap' => '%3$s')); ?>
                </ul>
            </div>
        </div><!--/.dt-->
    </div><!--/.center_wrap-->
</footer><!--/#footer-->

<div class="hidden">
    <div id="call_order" class="popup">
        <p class="popup_title">Получите лучшую цену</p>
        <?php echo do_shortcode('[contact-form-7 id="190" title="Заказ звонка"]')?>
    </div>

    <div id="question_order" class="popup">
        <p class="popup_title">Задайте вопрос мастеру</p>
        <?php echo do_shortcode('[contact-form-7 id="191" title="Задать вопрос"]')?>
    </div>

	<div id="thanks" class="popup">
  <p class="popup_title">
    <span>СПАСИБО!</span><br>Заявка отправлена
  </p>
  <p>Мы свяжемся с вами в ближайшее время.</p>
</div>
	
    <!-- Видео во всплывашке: создаём iframe только по клику -->
    <div id="video" class="popup">
        <div class="youtube-facade" data-src="<?php echo esc_attr( get_field('head_video', 'options') ); ?>">
            <button type="button" class="play-btn">▶ Смотреть</button>
        </div>
    </div>

    <div id="big_calc" class="popup">
        <p class="popup_title">Получите лучшую цену</p>
        <?php echo do_shortcode('[contact-form-7 id="194" title="Большой калькулятор"]')?>
    </div>

    <div id="get_consult" class="popup">
        <p class="popup_title">Получить консультацию</p>
        <?php echo do_shortcode('[contact-form-7 id="201" title="Получить консультацию"]')?>
    </div>

    <div id="conf" class="popup">
        <p class="popup_title">Политика конфиденциальности</p>
        <div class="conf_wrap">
            <?php the_field('conf_content', 'options')?>
        </div>
    </div>
</div>

<!-- jQuery CDN + безопасный локальный фолбэк БЕЗ document.write -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" defer></script>
<script>
(function(w,d){
  if(!w.jQuery){
    var s=d.createElement('script');
    s.src='<?php bloginfo('template_url')?>/js/vendor/jquery-1.11.2.min.js';
    s.defer=true;
    d.head.appendChild(s);
  }
})(window,document);
</script>


<!-- Ленивая инициализация YouTube в попапе -->
<script defer>
document.addEventListener('click', function(e){
  var btn = e.target.closest('#video .play-btn'); if(!btn) return;
  var wrap = btn.closest('.youtube-facade'); if(!wrap) return;
  var src = wrap.getAttribute('data-src');
  var ifr = document.createElement('iframe');
  ifr.src = src; ifr.width=800; ifr.height=450;
  ifr.allow='accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture';
  ifr.allowFullscreen = true;
  wrap.replaceWith(ifr);
});
</script>

<!-- LeadBack (ленивый запуск) -->
<script>
(function () {
  function loadLeadBack() {
    window._emv = window._emv || [];
    _emv['campaign'] = '4251c47fdf0b437fa77b6685'; // <-- ваш ID кампании, оставил прежний
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.setAttribute('data-cfasync','false'); // на случай Cloudflare Rocket Loader
    s.src = (location.protocol === 'https:' ? 'https://' : 'http://') + 'leadback.ru/js/leadback.js';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
  }
  // грузим, когда браузер свободен (не блокируем первый рендер)
  if ('requestIdleCallback' in window) { requestIdleCallback(loadLeadBack); }
  else { setTimeout(loadLeadBack, 0); }
})();
</script>


<?php wp_footer();?>
<?php the_field('yandex_metrika', 'options')?>
<?php the_field('google_analitics', 'options')?>
</body>
</html>
