<section class="repair-services">
  <div class="repair-container">
    <h2>Что входит в кузовной ремонт автомобиля?</h2>
    <div class="repair-grid">

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/8.png" alt="Восстановление геометрии">
            <p>Восстановление геометрии</p>
          </div>
          <div class="card-back">
            <p>Устраняем смещения, перекосы и деформации конструкции на стапеле с заводской точностью.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/9.png" alt="Рихтовка без покраски">
            <p>Рихтовка без покраски</p>
          </div>
          <div class="card-back">
            <p>Удаление вмятин без повреждения ЛКП, включая вакуумное выпрямление в деликатных зонах.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/9.png" alt="Покраска кузова">
            <p>Покраска кузова</p>
          </div>
          <div class="card-back">
            <p>Локальная и общая покраска с подбором цвета и соблюдением технологии.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/10.png" alt="Быстрый ремонт бамперов">
            <p>Быстрый ремонт бамперов</p>
          </div>
          <div class="card-back">
            <p>Срочный ремонт бамперов, молдингов и других элементов без потери качества.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/11.png" alt="Полировка и защита">
            <p>Полировка и защита</p>
          </div>
          <div class="card-back">
            <p>Удаление мелких сколов и царапин, нанесение защитного покрытия, блеск и защита.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/12.png" alt="Замена деталей">
            <p>Замена деталей</p>
          </div>
          <div class="card-back">
            <p>Меняем двери, крылья, капоты и багажники на оригинальные или аналоги.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/13.png" alt="Замена оптики">
            <p>Замена оптики</p>
          </div>
          <div class="card-back">
            <p>Устраняем последствия аварий, восстанавливая оптику и отражатели.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/14.png" alt="Предпродажная подготовка">
            <p>Предпродажная подготовка</p>
          </div>
          <div class="card-back">
            <p>Визуальное обновление авто, маскировка дефектов для повышения стоимости.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/15.png" alt="Слесарные работы">
            <p>Слесарные работы</p>
          </div>
          <div class="card-back">
            <p>Восстановление жёсткости и геометрии элементов сваркой и рихтовкой.</p>
          </div>
        </div>
      </div>

      <div class="repair-card">
        <div class="card-inner">
          <div class="card-front">
            <img src="/wp-content/uploads/2025/07/15.png" alt="Недорогая рихтовка">
            <p>Недорогая рихтовка</p>
          </div>
          <div class="card-back">
            <p>Аккуратное устранение повреждений без замены там, где это возможно.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<style>
.repair-services {
  background: #fff;
  padding: 50px 20px 20px;
  width: 100%;
}

.repair-container {
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}

.repair-container h2 {
  text-align: left;
}

.repair-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 10px;
  margin-top: 30px;
  margin-bottom: 20px;
}

.repair-card {
  perspective: 1000px;
}

.card-inner {
  position: relative;
  width: 100%;
  height: 180px;
  transition: transform 0.6s;
  transform-style: preserve-3d;
}

.repair-card:hover .card-inner {
  transform: rotateY(180deg);
}

.card-front,
.card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  background: #fff; /* фон плашек белый */
  border: 1px solid #ccc; /* тонкая серая граница */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* мягкая тень */
}

.card-front img {
  max-height: 50px;
  margin-bottom: 10px;
}

.card-back {
  transform: rotateY(180deg);
  font-size: 14px;
  text-align: center;
}

@media (max-width: 1024px) {
  .repair-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .repair-card:hover .card-inner {
    transform: none;
  }

  .repair-container h2 {
    text-align: center;
  }
}

.repair-grid,
.repair-card,
.card-inner,
.card-front,
.card-back {
  box-sizing: border-box;
}
</style>
