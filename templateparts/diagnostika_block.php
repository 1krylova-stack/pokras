<section class="diagnostika-block" style="background-color: #f5f5f5; padding: 40px 20px; margin: 40px 0;">
<div class="diagnostika-container" style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; gap:30px;">
  
  <!-- Левая колонка -->
  <div class="diagnostika-text" style="flex:1 1 500px; min-width:300px;">
    <h2 style="font-size:28px; color:#333; margin-bottom:15px;">Запишись на бесплатную диагностику</h2>
    <p style="font-size:18px; color:#666; margin-bottom:20px;">Используем современное оборудование: толщиномеры, УФ-лампы, визуальные методы осмотра.</p>

    <ul style="list-style:none; padding:0; margin:0 0 20px 0;">
      <li style="display:flex; align-items:center; margin-bottom:10px;">
        <img src="/wp-content/uploads/2025/07/clock.png" alt="" style="width:24px; height:24px; margin-right:10px;">
        <span style="font-size:16px; color:#333;">Занимает не более 30 минут</span>
      </li>
      <li style="display:flex; align-items:center; margin-bottom:10px;">
        <img src="/wp-content/uploads/2025/07/check.png" alt="" style="width:24px; height:24px; margin-right:10px;">
        <span style="font-size:16px; color:#333;">Консультация бесплатная и ни к чему не обязывает</span>
      </li>
    </ul>

    <p style="font-size:16px; color:#333; margin-bottom:20px;">
      Написать в  
      <a href="https://wa.clck.bar/79673444222?text=%D0%94%D0%BE%D0%B1%D1%80%D1%8B%D0%B9%20%D0%B4%D0%B5%D0%BD%D1%8C!%20%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%B5%D1%81%D1%83%D0%B5%D1%82%20%D1%81%D1%82%D0%BE%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D1%8C%20%D1%80%D0%B5%D0%BC%D0%BE%D0%BD%D1%82%D0%B0" target="_blank" style="color:#e30613; text-decoration:none;">
        <img src="/wp-content/themes/shablon/img/head_soc_icon_1.png" alt="WhatsApp" style="width:20px; vertical-align:middle; margin-right:5px;"> WhatsApp</a>;<br> 
      позвоните по номеру 
      <a href="tel:+79673444222" style="color:#e30613; text-decoration:none;">+7 (967) 344-42-22</a> 
      или оставьте заявку в форме:
    </p>

    <!-- Форма -->
    <div class="diagnostika-form">
      <?php echo do_shortcode('[contact-form-7 id="4" title="Главная форма"]'); ?>
      <p style="font-size:14px; color:#999; margin-top:10px;">
        Мастер запишет вас на удобное время и сразу может сориентировать по стоимости работ
      </p>
    </div>

  </div>

  <!-- Правая колонка -->
  <div class="diagnostika-image" style="flex:1 1 250px; min-width:250px; text-align:center;">
    <img src="/wp-content/uploads/2025/07/zamer.png" alt="Диагностика кузова" style="max-width:100%; height:auto; border-radius:30px;" loading="lazy">
  </div>

</div>
</section>

<style>
.diagnostika-form .dt {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  align-items: stretch; /* поле и кнопка будут одной высоты */
}

.diagnostika-form .dtc {
  flex: 1 1 auto;
  display: flex;
  align-items: stretch; /* тянем по высоте */
}

.diagnostika-form .dtc:first-child {
  max-width: 250px;
}

.diagnostika-form .wpcf7-form-control.wpcf7-text {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  line-height: 1.4;
  box-sizing: border-box;
  min-height: 44px;
  height: 44px; /* одинаковая высота */
  border: 1px solid #ccc;
}

.diagnostika-form .wpcf7-submit {
  background-color: #e30613;
  color: #fff;
  padding: 0 20px;
  border: none;
  font-size: 16px;
  cursor: pointer;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  text-align: center;
  min-height: 44px;
  height: 44px; /* фиксируем */
  line-height: normal;
  box-sizing: border-box;
  white-space: nowrap;
}

.diagnostika-form .wpcf7-submit:hover {
  background-color: #c3000f;
}

@media (max-width: 768px) {
  .diagnostika-form .dt {
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
  }

  .diagnostika-form .dtc {
    width: 100%;
  }

  .diagnostika-form .dtc:first-child {
    max-width: 100%;
  }

  .diagnostika-form .wpcf7-submit {
    width: 100%;
  }
}


</style>
