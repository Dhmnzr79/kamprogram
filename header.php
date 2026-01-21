<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo esc_html(wp_get_document_title()); ?></title>
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
            <div class="site-header__address">📍 г. Петропавловск-Камчатский, ул. Максутова, д.34</div>
            <a class="site-header__phone" href="tel:+79248941600">📞 +7 924 894-16-00</a>
          </div>

          <div class="site-header__mobile-buttons">
            <a class="btn-call" href="tel:+79248941600" aria-label="Позвонить">
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/phone-icon.svg'); ?>" alt="">
            </a>
            <button class="btn-menu" type="button" aria-haspopup="dialog" aria-controls="mobileNav" aria-expanded="false" data-header-burger>
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/menu-icon.svg'); ?>" alt="">
              <span class="sr-only">Открыть меню</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <nav class="site-header__drawer" aria-label="Меню" data-header-drawer hidden>
      <div class="site-header__drawer-header">
        <button class="site-header__close" type="button" aria-label="Закрыть меню" data-header-close>Закрыть</button>
      </div>

      <div class="site-header__drawer-body">
        <div class="site-header__drawer-brand">
          <a class="site-header__drawer-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <img
              src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/logo.svg'); ?>"
              alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
            >
          </a>
          <div class="site-header__drawer-tagline">Центр профессий будущего на Камчатке</div>
        </div>

        <div class="site-header__drawer-menu">
          <?php
          wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'site-nav__list site-nav__list--drawer',
            'fallback_cb' => false,
          ]);
          ?>
        </div>
      </div>
    </nav>
  </header>


