<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="site-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="site-header__brand">
            <a class="site-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
              <img
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/logo.svg'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
              >
            </a>
            <div class="site-header__tagline">Центр профессий будущего на Камчатке</div>
          </div>

          <div class="site-header__menu">
            <nav class="site-nav" aria-label="Главное меню">
              <ul class="site-nav__list">
                <li class="site-nav__item">
                  <a class="site-nav__link" href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
                </li>

                <li class="site-nav__item">
                  <?php $about_page = get_page_by_path('o-nas'); ?>
                  <?php if ($about_page) : ?>
                    <a class="site-nav__link" href="<?php echo esc_url(get_permalink($about_page)); ?>">О нас</a>
                  <?php endif; ?>
                </li>

                <li class="site-nav__item site-nav__courses">
                  <button class="site-nav__toggle" type="button" aria-expanded="false" data-courses-toggle>Наши курсы</button>
                  <ul class="site-nav__submenu" hidden data-courses-menu>
                    <?php
                    $courses_query = new WP_Query([
                      'post_type' => 'course',
                      'post_status' => 'publish',
                      'posts_per_page' => -1,
                    ]);

                    while ($courses_query->have_posts()) {
                      $courses_query->the_post();
                      ?>
                      <li class="site-nav__submenu-item">
                        <a class="site-nav__submenu-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                      </li>
                      <?php
                    }
                    wp_reset_postdata();
                    ?>
                  </ul>
                </li>

                <li class="site-nav__item">
                  <?php $contacts_page = get_page_by_path('kontakty'); ?>
                  <?php if ($contacts_page) : ?>
                    <a class="site-nav__link" href="<?php echo esc_url(get_permalink($contacts_page)); ?>">Контакты</a>
                  <?php endif; ?>
                </li>
              </ul>
            </nav>
          </div>

          <div class="site-header__contacts">
            <div class="site-header__address">Адрес</div>
            <div class="site-header__phone">Телефон</div>
          </div>
        </div>
      </div>
    </div>
  </header>


