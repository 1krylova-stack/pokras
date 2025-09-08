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
            </div>
        </div>
        <div class="dtc contacts_map">
            <?php the_field('yandex_map', 'options'); ?>
        </div>
    </div>
</div>

<footer id="footer">
    <div class="center_wrap">
        <div class="dt">
            <div class="dtc vat footer_logo">
                <a href="/"><p>Покраска <span>Авто</span></p><span>Честный кузовной ремонт<br>с гарантией 1 год.</span></a>
                <p class="copyright">Copyright © 2016-<?php echo date('Y'); ?> ООО «Покрас Авто» <br>Все права защищены</p>
                <a class="conf" href="#conf">Политика конфиденциальности</a>
            </div>
            <div class="dtc vat">
                <ul><?php wp_nav_menu(['menu' => 'Нижнее меню. Столбец 1', 'container' => '', 'items_wrap' => '%3$s']); ?></ul>
            </div>
            <div class="dtc vat">
                <ul><?php wp_nav_menu(['menu' => 'Нижнее меню. Столбец 2', 'container' => '', 'items_wrap' => '%3$s']); ?></ul>
            </div>
        </div>
    </div>
</footer>

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
        <div class="conf_wrap"><?php the_field('conf_content', 'options'); ?></div>
    </div>
</div>

<!-- ваши счетчики/пиксели (они уже async/defer) -->
<!-- Begin LeadBack code -->
<script>
  var _emv=_emv||[]; _emv['campaign']='4251c47fdf0b437fa77b6685';
  (function(){var em=document.createElement('script'); em.type='text/javascript'; em.async=true;
  em.src=(document.location.protocol==='https:'?'https://':'http://')+'leadback.ru/js/leadback.js';
  var s=document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(em, s);})();
</script>
<!-- End LeadBack code -->

<!-- VK pixel -->
<script>
!function(){var t=document.createElement("script");t.type="text/javascript";t.async=!0;t.src="https://vk.com/js/api/openapi.js?162";
t.onload=function(){VK.Retargeting.Init("VK-RTRG-434995-hfA2Q"),VK.Retargeting.Hit()};document.head.appendChild(t)}();
</script>
<noscript><img src="https://vk.com/rtrg?p=VK-RTRG-434995-hfA2Q" style="position:fixed;left:-999px;" alt=""></noscript>

<!-- Rating@Mail.ru counter -->
<script>
var _tmr=window._tmr||(window._tmr=[]);_tmr.push({id:"2944089",type:"pageView",start:(new Date()).getTime()});
(function(d,w,id){if(d.getElementById(id))return;var ts=d.createElement("script");ts.type="text/javascript";ts.async=true;ts.id=id;
ts.src=(d.location.protocol=="https:"?"https:":"http:")+"//top-fwz1.mail.ru/js/code.js";
var f=function(){var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(ts,s);};
if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",f,false);}else{f();}})(document,window,"topmailru-code");
</script>
<noscript><div><img src="//top-fwz1.mail.ru/counter?id=2944089;js=na" style="border:0;position:absolute;left:-9999px;" alt=""></div></noscript>

<?php wp_footer(); ?>
<?php the_field('yandex_metrika', 'options'); ?>
<?php the_field('google_analitics', 'options'); ?>
</body>
</html>
