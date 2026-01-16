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
    <div class="container site-header__bar">
      <div class="row">
        <div class="col-12 site-header__inner">
          <div class="site-header__brand">
            <a class="site-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
              <img
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/logo.svg'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
              >
            </a>
            <div class="site-header__tagline">Центр профессий будущего на Камчатке</div>
          </div>

          <div class="site-header__desktop-nav" data-header-desktop-nav>
            <?php
            wp_nav_menu([
              'theme_location' => 'primary',
              'container' => false,
              'menu_class' => 'site-nav__list',
              'fallback_cb' => false,
            ]);
            ?>
          </div>

          <div class="site-header__contacts" data-header-contacts>
            <div class="site-header__address">г. Петропавловск-Камчатский, ул. Максутова, д.34</div>
            <div class="site-header__phone">+7 924 894-16-00</div>
          </div>

          <a class="site-header__call" href="tel:+79248941600" aria-label="Позвонить">Позвонить</a>
          <button class="site-header__burger" type="button" aria-label="Открыть меню" aria-expanded="false" data-header-burger>Меню</button>
        </div>
      </div>
    </div>

    <nav class="site-header__drawer" aria-label="Меню" data-header-drawer hidden>
      <div class="site-header__drawer-header">
        <button class="site-header__close" type="button" aria-label="Закрыть меню" data-header-close>Закрыть</button>
      </div>

      <div class="site-header__drawer-body">
        <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'site-nav__list site-nav__list--drawer',
          'fallback_cb' => false,
        ]);
        ?>
      </div>
    </nav>
  </header>


