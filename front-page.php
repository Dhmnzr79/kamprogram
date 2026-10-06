<?php
get_header();
?>

<section class="hero hero--with-header-bg hero--unified hero--home">
  <div class="container">
    <div class="hero__wrapper">
      <div class="hero__content">
        <div class="hero__intro">
          <div class="hero__header">
            <h1 class="home-hero__title">Курсы для детей<br>и подростков<span class="home-hero__location">в Петропавловске-Камчатском</span></h1>
            <div class="hero__kid-photo--mobile">
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-bg.png'); ?>" alt="">
            </div>
          </div>
          <div class="hero__text">IT, робототехника, творчество и развитие мышления. Помогаем детям не просто учиться, а понимать, создавать и думать.</div>
        </div>
        <div class="hero__kid-photo hero__kid-photo--desktop">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-bg.png'); ?>" alt="">
          <img class="hero__decor-figure-03" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-03.svg'); ?>" alt="" aria-hidden="true">
        </div>
        <div class="hero__indexes hero__indexes--unified">
          <div class="hero-facts__heading"><span>Ваш следующий шаг</span><h2>Учимся с интересом</h2></div>
          <div class="hero__indexes-decor">
            <img class="hero__decor-figure-05 hero__decor-figure-05--top" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-05.svg'); ?>" alt="" aria-hidden="true">
            <img class="hero__decor-figure-06 hero__decor-figure-06--bottom" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-06.svg'); ?>" alt="" aria-hidden="true">
          </div>
          <div class="hero__index">
          <img
            src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>"
            alt=""
          >
            <div class="hero__index-text">Курсы для детей от 5 до 18 лет</div>
          </div>

          <div class="hero__index">
          <img
            src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>"
            alt=""
          >
            <div class="hero__index-text">Практика и проекты на каждом занятии</div>
          </div>

          <div class="hero__index">
          <img
            src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>"
            alt=""
          >
            <div class="hero__index-text">Небольшие группы и живое общение</div>
          </div>
          <button class="hero-facts__link" type="button" data-modal="signup">Начнём с бесплатного урока <span aria-hidden="true">↗&#xfe0e;</span></button>
        </div>
        <img class="hero__decor-figure-04" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/figure-04.svg'); ?>" alt="" aria-hidden="true">
        <button class="btn btn--secondary hero__cta" type="button" data-modal="signup">
          Записаться на бесплатный урок
          <svg class="btn__icon" width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.28846 0.75L14.75 7.21154L8.28846 13.6731M13.8526 7.21154L0.749999 7.21154" stroke="#FC573B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="hero__price"></div>
        </div>
      </div>
    </div>
</section>

<main class="page-home">
  <?php get_template_part('template-parts/section', 'course-promo'); ?>
  <div class="container"></div>

  <?php
  // Зона — Карточки курсов
  ?>
  <section class="section home-courses-cards">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="home-courses-cards__title">Наши курсы для детей и подростков</h2>
        </div>
      </div>

      <div class="row home-courses-cards__list">
        <?php
        $courses_query = new WP_Query([
          'post_type' => 'course',
          'post_status' => 'publish',
          'posts_per_page' => -1,
        ]);

        while ($courses_query->have_posts()) {
          $courses_query->the_post();
          $course_id = get_the_ID();

          $course_short = get_post_meta($course_id, '_kp_course_short', true);
          $course_age = get_post_meta($course_id, '_kp_course_age', true);
          ?>

          <div class="col-6">
            <article class="home-courses-cards__card">
              <a class="home-courses-cards__card-link"
                href="<?php the_permalink(); ?>"
                aria-label="Перейти к курсу"></a>

              <div class="home-courses-cards__card-inner">

                <div class="home-courses-cards__card-main">

                  <div class="home-courses-cards__card-photo-wrap">
                    <?php if (has_post_thumbnail($course_id)) : ?>
                      <div class="home-courses-cards__card-photo">
                        <?php echo get_the_post_thumbnail($course_id, 'medium'); ?>
                      </div>
                    <?php endif; ?>
                  </div>

                  <h3 class="home-courses-cards__card-title">
                    <?php the_title(); ?>
                  </h3>

                </div>

                <div class="home-courses-cards__card-body">

                  <div class="home-courses-cards__card-meta">
                    <?php if ($course_short) : ?>
                      <div class="home-courses-cards__card-short">
                        <?php echo esc_html($course_short); ?>
                      </div>
                    <?php endif; ?>

                    <?php if ($course_age) : ?>
                      <div class="home-courses-cards__card-age">
                        <?php echo esc_html($course_age); ?>
                      </div>
                    <?php endif; ?>
                  </div>

                  <button
                    class="btn btn--primary home-courses-cards__card-cta"
                    type="button"
                    data-modal="signup">
                    Записаться
                    <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>

                </div>
              </div>

            </article>
          </div>


          <?php
        }

        wp_reset_postdata();
        ?>
      </div>
    </div>
  </section>

  <?php
  // Зона — Опросник
  ?>
  <section class="section home-quiz">
    <div class="container">
      <div class="home-quiz__content home-quiz__content--selector">
        <div class="row">
          <div class="col-6">
            <div class="home-quiz__eyebrow">Найдём то, что увлечёт</div>
            <h2 class="home-quiz__title"><span>Не знаете,</span><br>какой курс подойдёт вашему ребёнку?</h2>

            <ul class="home-quiz__directions" aria-label="Направления обучения">
              <li><?php echo kamprogram_icon('code', 'feature-icon--on-surface'); ?><span>Программирование</span></li>
              <li><?php echo kamprogram_icon('blocks', 'feature-icon--on-surface'); ?><span>Робототехника</span></li>
              <li><?php echo kamprogram_icon('brush', 'feature-icon--on-surface'); ?><span>Творчество</span></li>
            </ul>
          </div>

          <div class="col-6">
            <div class="home-quiz__body">
              <div class="home-quiz__info">
                <h3 class="home-quiz__heading"><span class="home-quiz__prompt">Ответьте всего на</span> <span class="home-quiz__number">4</span> <span class="home-quiz__questions">коротких вопроса</span></h3>
                <div class="home-quiz__description">и мы подскажем направления, которые лучше всего подойдут по возрасту и интересам.</div>

                <div class="home-quiz__facts">
                  <div class="home-quiz__fact">
                    <?php echo kamprogram_icon('clock', 'home-quiz__fact-icon'); ?>
                    Займёт не больше 2 минут
                  </div>
                  <div class="home-quiz__fact">
                    <?php echo kamprogram_icon('gift', 'home-quiz__fact-icon'); ?>
                    Первый урок бесплатно
                  </div>
                </div>
              </div>

              <button class="btn btn--primary home-quiz__cta" type="button" data-modal="quiz">
                Пройти тест
                <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  // Зона — Плюсы нашего центра
  ?>
  <?php get_template_part('template-parts/section', 'center-advantages'); ?>

  <?php
  // Зона — Отзывы
  ?>
  <?php get_template_part('template-parts/section', 'reviews'); ?>

  <?php
  // Зона — Контакты
  ?>
  <?php get_template_part('template-parts/section', 'contacts'); ?>
</main>

<?php
get_footer();
?>
