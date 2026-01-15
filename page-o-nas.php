<?php
get_header();
?>

<main class="page-about">
  <?php
  // Зона — О нас
  ?>
  <section class="section about">
    <div class="container">
      <div class="row">
        <div class="col-6">
          <h2 class="about__title">О нас</h2>

          <p class="about__text">Мы - образовательный центр для детей и подростков, где обучение строится вокруг практики, интереса и понятного результата. Наши курсы помогают развивать мышление, логику, внимание и уверенность в себе через современные направления - от программирования и робототехники до творчества и математики.</p>

          <p class="about__text">Мы работаем с детьми разного возраста и уровня подготовки, помогая сделать первые шаги или углубить уже существующие интересы. Ребёнок не просто посещает занятия - он пробует, создаёт и видит свой прогресс.</p>

          <div class="row about__facts">
            <div class="col-6">
              <div class="about__fact">10+ курсов для детей и подростков</div>
            </div>
            <div class="col-6">
              <div class="about__fact">5-18 лет - обучение по возрастам</div>
            </div>
            <div class="col-6">
              <div class="about__fact">1–2 раза в неделю - без перегрузки</div>
            </div>
            <div class="col-6">
              <div class="about__fact">Бесплатный пробный урок</div>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="about__media">
            <img class="about__image" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/about-bg.jpg'); ?>" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  // Зона — Для кого наши курсы
  ?>
  <section class="section about-for-whom">
    <div class="container">
      <h2 class="about-for-whom__title">Для кого подойдут наши курсы</h2>

      <div class="row about-for-whom__cards">
        <div class="col-4">
          <article class="about-for-whom__card">
            <img class="about-for-whom__icon" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/for-who-icon-01.svg'); ?>" alt="">
            <h3 class="about-for-whom__card-title">Для детей, которым интересно разбираться, как всё устроено</h3>
            <div class="about-for-whom__card-text">Конструкторы, техника, компьютеры, логические задачи — превращаем интерес в полезные навыки.</div>
          </article>
        </div>

        <div class="col-4">
          <article class="about-for-whom__card">
            <img class="about-for-whom__icon" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/for-who-icon-02.svg'); ?>" alt="">
            <h3 class="about-for-whom__card-title">Для тех, кто любит создавать и фантазировать</h3>
            <div class="about-for-whom__card-text">Игры, мультфильмы, дизайн, визуальные проекты — учим выражать идеи через творчество и технологии.</div>
          </article>
        </div>

        <div class="col-4">
          <article class="about-for-whom__card">
            <img class="about-for-whom__icon" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/for-who-icon-03.svg'); ?>" alt="">
            <h3 class="about-for-whom__card-title">Для школьников, которым важно развитие мышления</h3>
            <div class="about-for-whom__card-text">Логика, внимание, усидчивость и умение решать задачи — навыки, которые помогают в учёбе.</div>
          </article>
        </div>
      </div>

      <div class="row about-for-whom__bottom">
        <div class="col-8">
          <article class="about-for-whom__wide">
            <h3 class="about-for-whom__wide-title">Для подростков, которые задумываются о будущем</h3>
            <div class="about-for-whom__wide-text">Помогаем попробовать разные направления и понять, что действительно интересно.</div>
          </article>
        </div>

        <div class="col-4">
          <article class="about-for-whom__side">
            <img class="about-for-whom__icon" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/for-who-icon-04.svg'); ?>" alt="">
            <h3 class="about-for-whom__card-title">Для родителей, которые хотят осознанный выбор</h3>
            <div class="about-for-whom__card-text">Без давления и навязывания — сначала пробный урок, потом решение.</div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <?php
  // Зона — Плюсы нашего центра (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'center-advantages'); ?>

  <?php
  // Зона — Отзывы (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'reviews'); ?>

  <?php
  // Зона — Контакты (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'contacts'); ?>
</main>

<?php
get_footer();
?>


