<?php if (!defined('ABSPATH')) exit; ?>

<div id="contacts">
    <div class="dt">
        <div class="dtc contacts_info">
            <div class="section_content">
                <p class="block_title">Доверьте кузовной ремонт профессионалам</p>
                <div itemscope itemtype="http://schema.org/Organization">
                    <ul>
                        <li><span itemprop="address"><?php the_field('footer_address', 'options'); ?></span></li>
                        <li><span itemprop="telephone"><?php the_field('phone', 'options'); ?></span></li>
                        <li><span itemprop="email"><?php the_field('email', 'options'); ?></span></li>
                    </ul>
                </div>
                <p>От качества кузовного ремонта напрямую зависит внешний вид автомобиля, поэтому только опытные мастера смогут вернуть вашей машине ее первозданный вид.</p>
                <p class="have_questions">Остались вопросы?</p>
                <a class="button" href="#question_order">Задайте их мастеру по ремонту прямо сейчас</a>
            </div><!--/.section_content-->
        </div><!--/.contacts_info-->
        <div class="dtc contacts_map">
            <?php the_field('yandex_map', 'options'); ?>
        </div>
    </div><!--/.dt-->
</div><!--/#contacts-->

<footer id="footer">
    <div class="center_wrap">
        <div class="dt">
            <div class="dtc vat footer_logo">
                <a href="/"><p>Покраска <span>Авто</span></p><span>Честный кузовной ремонт<br>с гарантией 1 год.</span></a>
                <p class="copyright">Copyright © 2016-<?php echo date('Y'); ?> ООО «Покрас Авто» <br>Все права защищены</p>
                <a class="conf" href="#conf">Политика конфиденциальности</a>
            </div><!--/.footer_logo-->
            <div class="dtc vat">
                <ul><?php wp_nav_menu(['menu' => 'Нижнее меню. Столбец 1', 'container' => '', 'items_wrap' => '%3$s']); ?></ul>
            </div>
            <div class="dtc vat">
                <ul><?php wp_nav_menu(['menu' => 'Нижнее меню. Столбец 2', 'container' => '', 'items_wrap' => '%3$s']); ?></ul>
            </div>
        </div><!--/.dt-->
    </div><!--/.center_wrap-->
</footer><!--/#footer-->

<div class="hidden">
    <div id="call_order" class="popup">
        <p class="popup_title">Получите лучшую цену</p>
        <?php echo do_shortcode('[contact-form-7 id="190" title="Заказ звонка"]'); ?>
    </div>
    <div id="zayavka_order" class="popup">
        <p class="popup_title">Предварительная запись</p>
        <?php echo do_shortcode('[contact-form-7 id="193" title="Предварительная запись"]'); ?>
    </div>
    <a href="#thanks" class="thank thank_link">Спасибо</a>
    <div id="thanks" class="popup">
        <p class="popup_title"><span>Спасибо!</span> Мастер скоро вам перезвонит</p>
    </div>
    <div id="question_order" class="popup">
        <p class="popup_title">Задайте вопрос мастеру по ремонту</p>
        <?php echo do_shortcode('[contact-form-7 id="191" title="Задать вопрос"]'); ?>
    </div>
    <div id="video" class="popup">
        <div class="youtube_wrap">
            <?php the_field('head_video', 'options'); ?>
        </div>
    </div>
    <div id="big_calc" class="popup">
        <p class="popup_title">Получите лучшую цену</p>
        <?php echo do_shortcode('[contact-form-7 id="194" title="Большой калькулятор"]'); ?>
    </div>
    <div id="get_consult" class="popup">
        <p class="popup_title">Получить консультацию</p>
        <?php echo do_shortcode('[contact-form-7 id="201" title="Получить консультацию"]'); ?>
    </div>
    <div id="conf" class="popup">
        <p class="popup_title">Политика конфиденциальности</p>
        <div class="conf_wrap">
            <?php the_field('conf_content', 'options'); ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

<!-- Ленивая загрузка сторонних счётчиков (после взаимодействия/idle) -->
<script>
(function(w,d){
  var fired=false;
  function run3p(){
    if(fired) return; fired=true;

    // LeadBack
    (function(){
      var _emv = w._emv = w._emv || [];
      _emv['campaign'] = '4251c47fdf0b437fa77b6685';
      var s=d.createElement('script');
      s.async=true;
      s.src=(location.protocol==='https:'?'https://':'http://')+'leadback.ru/js/leadback.js';
      d.head.appendChild(s);
    })();

    // VK pixel
    (function(){
      var vk=d.createElement('script');
      vk.async=true; vk.src='https://vk.com/js/api/openapi.js?162';
      vk.onload=function(){ try{ VK.Retargeting.Init('VK-RTRG-434995-hfA2Q'); VK.Retargeting.Hit(); }catch(e){} };
      d.head.appendChild(vk);
    })();

    // Mail.ru
    (function(){
      var ts=d.createElement('script');
      ts.async=true; ts.id='topmailru-code';
      ts.src=(location.protocol==='https:'?'https:':'http:')+'//top-fwz1.mail.ru/js/code.js';
      d.body.appendChild(ts);
    })();
  }

  function arm(){
    var once=function(){
      run3p();
      w.removeEventListener('scroll',once,{passive:true});
      w.removeEventListener('touchstart',once,{passive:true});
      w.removeEventListener('mousemove',once,{passive:true});
      w.removeEventListener('keydown',once);
    };
    w.addEventListener('scroll',once,{passive:true});
    w.addEventListener('touchstart',once,{passive:true});
    w.addEventListener('mousemove',once,{passive:true});
    w.addEventListener('keydown',once);
    w.addEventListener('load',function(){
      if('requestIdleCallback' in w){ requestIdleCallback(run3p,{timeout:5000}); }
      setTimeout(run3p,3500); // страховка
    });
  }
  arm();
})(window, document);
</script>

<!-- noscript-пиксели оставляем -->
<noscript><img src="https://vk.com/rtrg?p=VK-RTRG-434995-hfA2Q" style="position:fixed;left:-999px;" alt=""/></noscript>
<noscript><div><img src="//top-fwz1.mail.ru/counter?id=2944089;js=na" style="border:0;position:absolute;left:-9999px;" alt=""/></div></noscript>

<!-- Скрипты темы (после wp_footer и с defer) -->
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel/owl.carousel.min.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/masked.input.js" defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js" defer></script>

<?php the_field('yandex_metrika', 'options'); ?>
<?php the_field('google_analitics', 'options'); ?>

</body>
</html>
