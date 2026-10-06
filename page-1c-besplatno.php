<?php
get_header();
$asset_uri = get_stylesheet_directory_uri();
$arrow = '<svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M1 8h14M8 1l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<main class="free-course">
  <section class="hero hero--with-header-bg hero--unified free-course-hero">
    <div class="container">
      <div class="hero__wrapper">
        <div class="hero__content">
          <div class="hero__intro">
            <div class="free-course-hero__eyebrow">Проект «Код будущего»</div>
            <div class="hero__header"><h1>Стань востребованным<br>программистом 1С<br><span class="free-course-hero__accent">бесплатно!</span></h1><div class="hero__kid-photo--mobile"><img src="<?php echo esc_url($asset_uri . '/assets/img/hero-bg.png'); ?>" alt=""></div></div>
            <div class="hero__text">В Петропавловске-Камчатском.<br>Стартуй в IT-профессии с 7 класса.</div>
          </div>
          <div class="hero__kid-photo hero__kid-photo--desktop">
            <img src="<?php echo esc_url($asset_uri . '/assets/img/hero-bg.png'); ?>" alt="" fetchpriority="high">
            <img class="hero__decor-figure-03" src="<?php echo esc_url($asset_uri . '/assets/svg/figure-03.svg'); ?>" alt="" aria-hidden="true">
          </div>
          <div class="hero__indexes hero__indexes--unified">
            <div class="hero-facts__heading"><span>Бесплатный курс</span><h2>Код будущего</h2></div>
            <div class="hero__indexes-decor"><img class="hero__decor-figure-05 hero__decor-figure-05--top" src="<?php echo esc_url($asset_uri . '/assets/svg/figure-05.svg'); ?>" alt=""><img class="hero__decor-figure-06 hero__decor-figure-06--bottom" src="<?php echo esc_url($asset_uri . '/assets/svg/figure-06.svg'); ?>" alt=""></div>
            <?php foreach (['Только 100 бесплатных мест', 'Очные курсы в центре города', 'Для школьников 7–11 классов'] as $benefit) : ?>
              <div class="hero__index"><img src="<?php echo esc_url($asset_uri . '/assets/svg/chk-white.svg'); ?>" alt=""><div class="hero__index-text"><?php echo esc_html($benefit); ?></div></div>
            <?php endforeach; ?>
            <a class="hero-facts__link" href="#course-signup">Записаться на курс <span aria-hidden="true">↗&#xfe0e;</span></a>
          </div>
          <div class="hero__price free-course-hero__deadline"><span class="feature-icon feature-icon--on-surface free-course-hero__alarm" aria-hidden="true"><svg width="34" height="34" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="18" r="10"/><path d="M16 12v6l4 2M8 4 3 9m21-5 5 5M9 27l-2 3m16-3 2 3M13 4h6M16 4v4"/></svg></span><span>Успей записаться<br><strong>до 10 октября 2026 года</strong></span></div>
          <div class="hero__cta free-course-hero__action"><a class="btn btn--secondary" href="#course-signup">Стать программистом бесплатно <?php echo $arrow; ?></a><p class="free-course-hero__note">Начни своё будущее в IT бесплатно прямо сейчас</p></div>
          <img class="hero__decor-figure-04" src="<?php echo esc_url($asset_uri . '/assets/svg/figure-04.svg'); ?>" alt="" aria-hidden="true">
        </div>
      </div>
    </div>
  </section>

  <section class="section free-course-benefits">
    <div class="container">
      <div class="free-course__heading" data-course-reveal><span class="free-course__eyebrow">Больше, чем просто занятия</span><h2>Большое будущее<br>начинается с первого шага</h2></div>
      <div class="row">
        <?php
        $benefits = [
          ['01', 'code', 'Старт в IT с 7 класса', 'Начни строить карьеру уже в школе. Курсы адаптированы под возраст.'],
          ['02', 'certificate', 'Официальный сертификат 1С', 'Получи документ государственного образца, который котируется по всей России.'],
          ['03', 'pin', 'Очное обучение в центре города', 'Удобное расположение — город Петропавловск-Камчатский, ул. Максутова, д. 34.'],
          ['04', 'mentor', 'Преподаватели-эксперты с юмором', 'Учимся у сертифицированных специалистов, которые горят своим делом и делают занятия интересными.'],
        ];
        foreach ($benefits as [$number, $icon, $title, $text]) : ?>
          <div class="col-3" data-course-reveal><article class="free-course-benefits__card"><div class="free-course-benefits__top"><?php echo kamprogram_icon($icon, 'free-course-benefits__icon feature-icon--on-surface'); ?><span class="free-course-benefits__number"><?php echo esc_html($number); ?></span></div><h3><?php echo esc_html($title); ?></h3><p><?php echo esc_html($text); ?></p></article></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section free-course-program">
    <div class="container">
      <div class="free-course__heading" data-course-reveal><span class="free-course__eyebrow">От интереса — к практике</span><h2>Программа, которая<br>подойдёт именно тебе</h2></div>
      <div class="row">
        <div class="col-6" data-course-reveal><article class="free-course-program__card"><div class="free-course-program__top"><span class="free-course-program__tag">Первый шаг в программирование</span><span class="free-course-program__symbol" aria-hidden="true">{ }</span></div><h3>7–8 классы</h3><ul class="free-course__list"><li>Основы программирования в 1С</li><li>Погружение в платформу</li><li>72 часа увлекательных занятий</li></ul><a class="free-course-program__link" href="#course-signup">Начать с основ <?php echo $arrow; ?></a></article></div>
        <div class="col-6" data-course-reveal><article class="free-course-program__card free-course-program__card--advanced"><div class="free-course-program__top"><span class="free-course-program__tag">Погружение в профессию</span><span class="free-course-program__symbol" aria-hidden="true">&lt;/&gt;</span></div><h3>9–11 классы</h3><ul class="free-course__list"><li>Углублённое изучение 1С:Предприятие 8</li><li>Решение реальных бизнес-задач</li><li>72 часа интенсивной практики</li></ul><a class="free-course-program__link" href="#course-signup">Перейти на следующий уровень <?php echo $arrow; ?></a></article></div>
      </div>
      <div class="free-course-program__facts" data-course-reveal>
        <div class="free-course-program__fact"><strong>100<span>%</span></strong><div><b>Бесплатно</b><p>Обучение финансирует 1С</p></div></div>
        <div class="free-course-program__fact"><strong>7–11</strong><div><b>Классы</b><p>Двухлетний курс</p></div></div>
        <div class="free-course-program__fact"><strong>100<span>%</span></strong><div><b>Очно</b><p>Без дистанционных технологий</p></div></div>
      </div>
    </div>
  </section>

  <section class="section free-course-place">
    <div class="container"><div class="row free-course-place__row">
      <div class="col-6" data-course-reveal><div class="free-course-place__media"><img class="free-course-place__image" src="<?php echo esc_url($asset_uri . '/assets/img/about-bg.jpg'); ?>" alt="Занятия в классе" loading="lazy"><div class="free-course-place__address"><?php echo kamprogram_icon('pin', 'free-course-place__pin'); ?><div>Петропавловск-Камчатский<strong>ул. Максутова, д. 34</strong></div></div></div></div>
      <div class="col-6 free-course-place__content" data-course-reveal><span class="free-course__eyebrow">Живое общение. Настоящая практика.</span><h2>Учимся очно.<br>Здесь, на Камчатке.</h2><p>Бесплатное очное обучение пройдёт в Петропавловске-Камчатском. Очные занятия позволят вашему ребёнку:</p><ul class="free-course__list"><li>Лучше усвоить материал</li><li>Сразу задать вопрос учителю</li><li>Обрести новые знакомства</li><li>Лучше подготовиться к профильному ЕГЭ</li></ul><a class="btn btn--primary" href="#course-signup">Оставить заявку <?php echo $arrow; ?></a></div>
    </div></div>
  </section>

  <section class="section free-course-steps">
    <div class="container">
      <div class="free-course__heading" data-course-reveal><span class="free-course__eyebrow">Твой маршрут в IT</span><h2>От заявки до сертификата —<br>всего 4 шага</h2></div>
      <ol class="free-course-steps__list">
        <li class="free-course-steps__item" data-course-reveal><span class="free-course-steps__number">01</span><h3>Оставляешь заявку</h3><p>Успей записаться на бесплатное обучение до 10 октября 2026 года!</p></li>
        <li class="free-course-steps__item" data-course-reveal><span class="free-course-steps__number">02</span><h3>Проходишь бесплатное тестирование</h3><p>Проверим твою логику.</p></li>
        <li class="free-course-steps__item" data-course-reveal><span class="free-course-steps__number">03</span><h3>Занимаешься очно</h3><p>Учишься в удобной группе: будни или выходные.</p></li>
        <li class="free-course-steps__item" data-course-reveal><span class="free-course-steps__number">04</span><h3>Сдаёшь итоговый тест и получаешь сертификат!</h3></li>
      </ol>
      <a class="btn btn--primary" href="#course-signup">Сделать первый шаг <?php echo $arrow; ?></a>
    </div>
  </section>

  <section class="section free-course-mentor">
    <div class="container"><div class="free-course-mentor__panel" data-course-reveal>
      <div class="free-course-mentor__art" aria-hidden="true"><span class="free-course-mentor__bracket">{</span><span class="free-course-mentor__smile">:)</span><span class="free-course-mentor__bracket">}</span><span class="free-course-mentor__caption">Сложное становится понятным</span></div>
      <div class="free-course-mentor__content"><span class="free-course__eyebrow">Поддержка на каждом шаге</span><h2>Ваш проводник<br>в мир 1С</h2><p>Наши преподаватели объясняют сложные вещи на простом языке. Наша цель — не просто научить коду, а зажечь интерес к профессии.</p><p class="free-course-mentor__quote">Убеждены: с юмором любая задача решается быстрее!</p></div>
    </div></div>
  </section>

  <?php get_template_part('template-parts/section', 'reviews'); ?>

  <section class="section free-course-signup" id="course-signup" aria-labelledby="course-signup-title">
    <div class="container">
      <div class="free-course-signup__intro" data-course-reveal><span class="free-course__eyebrow">Набор открыт до 10 октября 2026 года</span><h2 id="course-signup-title">Хватит откладывать<br>своё будущее!</h2><p>Группы до 12 человек. Выбирай удобное расписание: утренние, дневные или группы выходного дня. Места ограничены!</p></div>
      <div class="row free-course-signup__row">
        <div class="col-6" data-course-reveal><div class="free-course-signup__offer"><span class="free-course-signup__places">100<span>бесплатных мест</span></span><h3>Твой шанс стартовать в IT</h3><p>100 мест уже разбирают! Бесплатно пройди тестирование и гарантируй себе место в группе.</p><a class="free-course-signup__anchor" href="#course-form">Забронировать место на курс <?php echo $arrow; ?></a><img class="free-course-signup__decor" src="<?php echo esc_url($asset_uri . '/assets/svg/figure-04.svg'); ?>" alt="" loading="lazy"></div></div>
        <div class="col-6"><div class="free-course-form" id="course-form"><h3>Записаться на курс</h3><p class="free-course-form__intro">Заполните заявку — начните путь к профессии программиста 1С.</p>
          <?php
          $form_id = (int) get_option('kamprogram_free_course_form_id');
          if ($form_id && function_exists('wpcf7_contact_form') && wpcf7_contact_form($form_id)) {
            echo do_shortcode('[contact-form-7 id="' . $form_id . '"]');
          } else {
            echo '<p>Для записи на курс позвоните <a href="tel:+79248941600">+7 924 894-16-00</a>.</p>';
          }
          ?>
        </div></div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'contacts', ['signup_url' => '#course-signup']); ?>
</main>
<?php get_footer(); ?>
