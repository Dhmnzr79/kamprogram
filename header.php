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
            <?php
            wp_nav_menu([
              'theme_location' => 'primary',
              'container' => false,
              'fallback_cb' => false,
            ]);
            ?>
          </div>

          <div class="site-header__contacts">
            <div class="site-header__address">Адрес</div>
            <div class="site-header__phone">Телефон</div>
          </div>
        </div>
      </div>
    </div>
  </header>


