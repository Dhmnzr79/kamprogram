<?php
/*
 * Template Name: Интенсивы
 */
get_header();
?>

<section class="hero hero--with-header-bg hero--unified">
  <div class="container">
    <div class="hero__wrapper">
      <div class="hero__content">
        <div class="hero__intro">
          <div class="hero__header">
            <h1>Летние компьютерные интенсивы для школьников</h1>
            <div class="hero__kid-photo--mobile">
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-bg.png'); ?>" alt="">
            </div>
          </div>
          <div class="hero__text">Ваш ребёнок без вашей помощи легко создаёт презентации, уверенно работает в Word и Excel и осваивает графический дизайн — вместо бесцельного скроллинга соцсетей.</div>
        </div>

        <div class="hero__kid-photo hero__kid-photo--desktop">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-bg.png'); ?>" alt="">
          <img class="hero__decor-figure-03" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-03.svg'); ?>" alt="" aria-hidden="true">
        </div>

        <div class="hero__indexes hero__indexes--unified">
          <div class="hero-facts__heading"><span>Ваш следующий шаг</span><h2>Интенсив в деталях</h2></div>
          <div class="hero__indexes-decor">
            <img class="hero__decor-figure-05 hero__decor-figure-05--top" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-05.svg'); ?>" alt="" aria-hidden="true">
            <img class="hero__decor-figure-06 hero__decor-figure-06--bottom" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-06.svg'); ?>" alt="" aria-hidden="true">
          </div>

          <div class="hero__index">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
            <div class="hero__index-text">Практика с первого занятия</div>
          </div>

          <div class="hero__index">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
            <div class="hero__index-text">3 недели · 12 занятий</div>
          </div>

          <div class="hero__index">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
            <div class="hero__index-text">Группы по возрасту</div>
          </div>
          <button class="hero-facts__link" type="button" data-modal="signup">Записаться на интенсив <span aria-hidden="true">↗&#xfe0e;</span></button>
        </div>

        <img class="hero__decor-figure-04" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-04.svg'); ?>" alt="" aria-hidden="true">

        <div class="hero__price">
          <div class="hero__badge">
            <span class="hero__badge-item"><?php echo kamprogram_icon('calendar', 'feature-icon--on-surface'); ?> Старт 2 июня</span>
            <span class="hero__badge-item">15 000 ₽</span>
          </div>
        </div>

        <button class="btn btn--secondary hero__cta" type="button" data-modal="signup">
          Записаться на интенсив
          <svg class="btn__icon" width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.28846 0.75L14.75 7.21154L8.28846 13.6731M13.8526 7.21154L0.749999 7.21154" stroke="#FC573B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>

<main class="page-intensivy">
  <div class="container"></div>

  <section class="section intensivy-directions">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="intensivy-directions__title">Три направления — выберите своё</h2>
          <div class="intensivy-directions__subtitle">3 недели · 12 занятий · группы по возрасту · старт 2 июня</div>
        </div>
      </div>

      <div class="row intensivy-directions__grid">

        <div class="col-4">
          <div class="intensivy-directions__card">
            <?php echo kamprogram_icon('monitor', 'intensivy-directions__card-icon feature-icon--on-surface'); ?>
            <h3 class="intensivy-directions__card-title">Компьютерная грамотность</h3>
            <div class="intensivy-directions__card-text">Word, Excel, презентации и безопасная работа в интернете — всё, что нужно школьнику каждый день и что пригодится на всю жизнь.</div>
            <div class="intensivy-directions__card-price">15 000 ₽</div>
            <button class="btn btn--primary intensivy-directions__card-cta" type="button" data-modal="signup">
              Записаться
              <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="col-4">
          <div class="intensivy-directions__card">
            <?php echo kamprogram_icon('brush', 'intensivy-directions__card-icon feature-icon--on-surface'); ?>
            <h3 class="intensivy-directions__card-title">Компьютерная графика</h3>
            <div class="intensivy-directions__card-text">Фотообработка, дизайн, работа с изображениями в профессиональных программах — вместо бесцельного скроллинга ребёнок начнёт создавать сам.</div>
            <div class="intensivy-directions__card-price">15 000 ₽</div>
            <button class="btn btn--primary intensivy-directions__card-cta" type="button" data-modal="signup">
              Записаться
              <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="col-4">
          <div class="intensivy-directions__card">
            <?php echo kamprogram_icon('code', 'intensivy-directions__card-icon feature-icon--on-surface'); ?>
            <h3 class="intensivy-directions__card-title">Основы программирования</h3>
            <div class="intensivy-directions__card-text">Первые шаги в коде, развитие логического мышления, создание собственных программ и игр. Навык, который становится всё ценнее с каждым годом.</div>
            <div class="intensivy-directions__card-price">15 000 ₽</div>
            <button class="btn btn--primary intensivy-directions__card-cta" type="button" data-modal="signup">
              Записаться
              <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'center-advantages'); ?>
  <?php get_template_part('template-parts/section', 'reviews'); ?>
  <?php get_template_part('template-parts/section', 'contacts'); ?>
</main>

<?php get_footer(); ?>
