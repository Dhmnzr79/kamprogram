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
            <div class="site-header__tagline">Центр профессий будущего<br><span>на Камчатке</span></div>
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
            <div class="site-header__address">Петропавловск-Камчатский<br><span>ул. Максутова, д. 34</span></div>
            <a class="site-header__phone" href="tel:+79248941600">+7 924 894-16-00</a>
          </div>

          <div class="site-header__mobile-buttons">
            <a class="btn-call" href="tel:+79248941600" aria-label="Позвонить">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m7 3 3 5-2 2c1 3 3 5 6 6l2-2 5 3c0 3-2 4-4 4C9 20 4 15 3 7c0-2 1-4 4-4Z" stroke-linejoin="round"/></svg>
            </a>
            <button class="btn-menu" type="button" aria-haspopup="dialog" aria-controls="mobileNav" aria-expanded="false" data-header-burger>
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/menu-icon.svg'); ?>" alt="">
              <span class="sr-only">Открыть меню</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <nav class="site-header__drawer" id="mobileNav" aria-label="Меню" data-header-drawer hidden>
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
        <a class="site-header__campaign" href="<?php $campaign_page = get_page_by_path('1c-besplatno'); echo esc_url($campaign_page ? get_permalink($campaign_page) : home_url('/1c-besplatno/')); ?>">
          <strong>Проект «Код будущего» <span aria-hidden="true">↗&#xfe0e;</span></strong>
          <span>Бесплатно · запись до 10 октября 2026</span>
        </a>
      </div>
    </nav>
  </header>
