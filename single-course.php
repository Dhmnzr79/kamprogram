<?php
get_header();

while (have_posts()) {
  the_post();

  $post_id = get_the_ID();

  $price = get_post_meta($post_id, '_kp_course_price', true);
  $age = get_post_meta($post_id, '_kp_course_age', true);
  $schedule = get_post_meta($post_id, '_kp_course_schedule', true);
  $duration = get_post_meta($post_id, '_kp_course_duration', true);

  $hero_h1 = get_post_meta($post_id, '_kp_hero_h1', true);
  $hero_text = get_post_meta($post_id, '_kp_hero_text', true);
  $hero_kid_photo_id = (int) get_post_meta($post_id, '_kp_hero_kid_photo_id', true);

  $for_title = get_post_meta($post_id, '_kp_for_title', true);
  $for_subtitle = get_post_meta($post_id, '_kp_for_subtitle', true);
  $for_items = (array) get_post_meta($post_id, '_kp_for_items', true);

  $why_title = get_post_meta($post_id, '_kp_why_title', true);
  $why_text = get_post_meta($post_id, '_kp_why_text', true);
  $why_btn = get_post_meta($post_id, '_kp_why_btn', true);
  $why_photo_id = (int) get_post_meta($post_id, '_kp_why_photo_id', true);

  $less_title = get_post_meta($post_id, '_kp_less_title', true);
  $less_text = get_post_meta($post_id, '_kp_less_text', true);
  $less_items = (array) get_post_meta($post_id, '_kp_less_items', true);
  $less_extra = get_post_meta($post_id, '_kp_less_extra', true);

  $res_cards = (array) get_post_meta($post_id, '_kp_res_cards', true);

  $cta_title = get_post_meta($post_id, '_kp_cta_title', true);
  $cta_text = get_post_meta($post_id, '_kp_cta_text', true);
  ?>

  <main class="page-course">
    <section class="hero hero--with-header-bg">
      <div class="container">
        <div class="hero__wrapper">
          <div class="hero__content">
            <div class="hero__heading">
              <h1><?php echo esc_html($hero_h1 ?: get_the_title()); ?></h1>

              <?php if ($hero_text) : ?>
                <div class="hero__text"><?php echo esc_html($hero_text); ?></div>
              <?php endif; ?>
            </div>

            <?php if ($hero_kid_photo_id) : ?>
              <div class="hero__kid-photo">
                <?php echo wp_get_attachment_image($hero_kid_photo_id, 'full'); ?>
              </div>
            <?php endif; ?>

            <?php if ($price) : ?>
              <div class="hero__price">
                <div class="hero__price-label">Стоимость:</div>
                <div class="hero__price-value"><?php echo esc_html($price); ?></div>
              </div>
            <?php endif; ?>

            <button class="hero__cta" type="button">Записаться на бесплатный урок</button>

            <div class="hero__indexes">
              <div class="hero__index">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
                <div class="hero__index-label">Возраст:</div>
                <div class="hero__index-value"><?php echo esc_html($age); ?></div>
              </div>

              <div class="hero__index">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
                <div class="hero__index-label">График:</div>
                <div class="hero__index-value"><?php echo esc_html($schedule); ?></div>
              </div>

              <div class="hero__index">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/chk-white.svg'); ?>" alt="">
                <div class="hero__index-label">Длительность:</div>
                <div class="hero__index-value"><?php echo esc_html($duration); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section course-for-whom">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <?php if ($for_title) : ?><h2 class="course-for-whom__title"><?php echo esc_html($for_title); ?></h2><?php endif; ?>
          </div>

          <div class="col-6">
            <?php if ($for_subtitle) : ?><div class="course-for-whom__subtitle"><?php echo esc_html($for_subtitle); ?></div><?php endif; ?>
            <?php if (!empty(array_filter($for_items))) : ?>
              <ul class="course-for-whom__list">
                <?php foreach ($for_items as $item) : ?>
                  <?php if (!$item) { continue; } ?>
                  <li class="course-for-whom__list-item"><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="section course-why">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <?php if ($why_title) : ?><h2 class="course-why__title"><?php echo esc_html($why_title); ?></h2><?php endif; ?>
            <?php if ($why_text) : ?><div class="course-why__subtitle"><?php echo esc_html($why_text); ?></div><?php endif; ?>
          </div>

          <div class="col-6">
            <?php if ($why_photo_id) : ?>
              <div class="course-why__media"><?php echo wp_get_attachment_image($why_photo_id, 'large'); ?></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="section course-lessons">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <?php if ($less_title) : ?><h2 class="course-lessons__title"><?php echo esc_html($less_title); ?></h2><?php endif; ?>
            <?php if ($less_text) : ?><div class="course-lessons__subtitle"><?php echo esc_html($less_text); ?></div><?php endif; ?>
          </div>

          <div class="col-6">
            <?php if (!empty($less_items)) : ?>
              <div class="course-lessons__items">
                <?php foreach ($less_items as $row) :
                  $row = is_array($row) ? $row : [];
                  $t = $row['title'] ?? '';
                  $d = $row['text'] ?? '';
                  if (!$t && !$d) { continue; }
                  ?>
                  <div class="course-lessons__item">
                    <?php if ($t) : ?><h3 class="course-lessons__item-title"><?php echo esc_html($t); ?></h3><?php endif; ?>
                    <?php if ($d) : ?><div class="course-lessons__item-text"><?php echo esc_html($d); ?></div><?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="section course-results">
      <div class="container">
        <h2 class="course-results__title">Результат обучения</h2>
        <?php if (!empty($res_cards)) : ?>
          <div class="row course-results__grid">
            <?php foreach ($res_cards as $card) :
              $card = is_array($card) ? $card : [];
              $icon_id = (int) ($card['icon_id'] ?? 0);
              $icon_url = $card['icon'] ?? '';
              $t = $card['title'] ?? '';
              $d = $card['text'] ?? '';
              if (!$icon_id && !$icon_url && !$t && !$d) { continue; }
              ?>
              <div class="col-4">
                <div class="course-results__card">
                  <?php if ($icon_id) : ?>
                    <?php $src = wp_get_attachment_url($icon_id); ?>
                    <?php if ($src) : ?><img class="course-results__icon" src="<?php echo esc_url($src); ?>" alt=""><?php endif; ?>
                  <?php elseif ($icon_url) : ?>
                    <img class="course-results__icon" src="<?php echo esc_url($icon_url); ?>" alt="">
                  <?php endif; ?>
                  <?php if ($t) : ?><h3 class="course-results__card-title"><?php echo esc_html($t); ?></h3><?php endif; ?>
                  <?php if ($d) : ?><div class="course-results__card-text"><?php echo esc_html($d); ?></div><?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <section class="section course-cta">
      <div class="container">
        <?php if ($cta_title) : ?><h2 class="course-cta__title"><?php echo esc_html($cta_title); ?></h2><?php endif; ?>
        <?php if ($cta_text) : ?><div class="course-cta__text"><?php echo esc_html($cta_text); ?></div><?php endif; ?>

        <div class="course-cta__form">
          <?php echo do_shortcode('[contact-form-7 id="6c52f0a" title="Основная форма"]'); ?>
        </div>
      </div>
    </section>

    <?php get_template_part('template-parts/section', 'center-advantages'); ?>
    <?php get_template_part('template-parts/section', 'reviews'); ?>
    <?php get_template_part('template-parts/section', 'contacts'); ?>
  </main>

  <?php
}

get_footer();
?>


