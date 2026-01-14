<?php

add_action('wp_enqueue_scripts', function () {
  $theme_uri = get_stylesheet_directory_uri();

  wp_enqueue_style('kamprogram-base', $theme_uri . '/assets/css/base.css', [], null);
  wp_enqueue_style('kamprogram-layout', $theme_uri . '/assets/css/layout.css', ['kamprogram-base'], null);
  wp_enqueue_style('kamprogram-components', $theme_uri . '/assets/css/components.css', ['kamprogram-layout'], null);
  wp_enqueue_style('kamprogram-utilities', $theme_uri . '/assets/css/utilities.css', ['kamprogram-components'], null);
  wp_enqueue_style('kamprogram-page-course', $theme_uri . '/assets/css/pages/course.css', ['kamprogram-utilities'], null);
});


