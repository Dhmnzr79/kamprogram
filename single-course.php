<?php
get_header();

while (have_posts()) {
  the_post();

  $post_id = get_the_ID();

  $short = get_post_meta($post_id, '_kp_course_short', true);
  $price = get_post_meta($post_id, '_kp_course_price', true);
  $age = get_post_meta($post_id, '_kp_course_age', true);
  $schedule = get_post_meta($post_id, '_kp_course_schedule', true);
  $duration = get_post_meta($post_id, '_kp_course_duration', true);

  $hero_h1 = get_post_meta($post_id, '_kp_hero_h1', true);
  $hero_text = get_post_meta($post_id, '_kp_hero_text', true);

  $for_title = get_post_meta($post_id, '_kp_for_title', true);
  $for_subtitle = get_post_meta($post_id, '_kp_for_subtitle', true);
  $for_items = (array) get_post_meta($post_id, '_kp_for_items', true);

  $why_title = get_post_meta($post_id, '_kp_why_title', true);
  $why_text = get_post_meta($post_id, '_kp_why_text', true);
  $why_btn = get_post_meta($post_id, '_kp_why_btn', true);

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
        <h1><?php echo esc_html($hero_h1 ?: get_the_title()); ?></h1>
        <?php if ($hero_text) : ?>
          <div><?php echo esc_html($hero_text); ?></div>
        <?php endif; ?>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <h2>Общие</h2>
        <?php if (has_post_thumbnail($post_id)) : ?>
          <div><?php echo get_the_post_thumbnail($post_id, 'large'); ?></div>
        <?php endif; ?>
        <?php if ($short) : ?><p><?php echo esc_html($short); ?></p><?php endif; ?>
        <?php if ($price) : ?><p>Стоимость: <?php echo esc_html($price); ?></p><?php endif; ?>
        <?php if ($age) : ?><p>Возраст: <?php echo esc_html($age); ?></p><?php endif; ?>
        <?php if ($schedule) : ?><p>График: <?php echo esc_html($schedule); ?></p><?php endif; ?>
        <?php if ($duration) : ?><p>Длительность: <?php echo esc_html($duration); ?></p><?php endif; ?>
      </div>
    </section>

    <section class="section course-for-whom">
      <div class="container">
        <?php if ($for_title) : ?><h2><?php echo esc_html($for_title); ?></h2><?php endif; ?>
        <?php if ($for_subtitle) : ?><div><?php echo esc_html($for_subtitle); ?></div><?php endif; ?>
        <?php if (!empty(array_filter($for_items))) : ?>
          <ul>
            <?php foreach ($for_items as $item) : ?>
              <?php if (!$item) { continue; } ?>
              <li><?php echo esc_html($item); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </section>

    <section class="section course-why">
      <div class="container">
        <?php if ($why_title) : ?><h2><?php echo esc_html($why_title); ?></h2><?php endif; ?>
        <?php if ($why_text) : ?><div><?php echo esc_html($why_text); ?></div><?php endif; ?>
        <?php if ($why_btn) : ?><a href="#"><?php echo esc_html($why_btn); ?></a><?php endif; ?>
      </div>
    </section>

    <section class="section course-lessons">
      <div class="container">
        <?php if ($less_title) : ?><h2><?php echo esc_html($less_title); ?></h2><?php endif; ?>
        <?php if ($less_text) : ?><div><?php echo esc_html($less_text); ?></div><?php endif; ?>

        <?php if (!empty($less_items)) : ?>
          <div>
            <?php foreach ($less_items as $row) :
              $row = is_array($row) ? $row : [];
              $t = $row['title'] ?? '';
              $d = $row['text'] ?? '';
              if (!$t && !$d) { continue; }
              ?>
              <div>
                <?php if ($t) : ?><h3><?php echo esc_html($t); ?></h3><?php endif; ?>
                <?php if ($d) : ?><div><?php echo esc_html($d); ?></div><?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ($less_extra) : ?><div><?php echo esc_html($less_extra); ?></div><?php endif; ?>
      </div>
    </section>

    <section class="section course-results">
      <div class="container">
        <h2>Результат обучения</h2>
        <?php if (!empty($res_cards)) : ?>
          <div>
            <?php foreach ($res_cards as $card) :
              $card = is_array($card) ? $card : [];
              $icon = $card['icon'] ?? '';
              $t = $card['title'] ?? '';
              $d = $card['text'] ?? '';
              if (!$icon && !$t && !$d) { continue; }
              ?>
              <div>
                <?php if ($icon) : ?><img src="<?php echo esc_url($icon); ?>" alt=""><?php endif; ?>
                <?php if ($t) : ?><h3><?php echo esc_html($t); ?></h3><?php endif; ?>
                <?php if ($d) : ?><div><?php echo esc_html($d); ?></div><?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <section class="section course-cta">
      <div class="container">
        <?php if ($cta_title) : ?><h2><?php echo esc_html($cta_title); ?></h2><?php endif; ?>
        <?php if ($cta_text) : ?><div><?php echo esc_html($cta_text); ?></div><?php endif; ?>
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


