<?php

add_action('wp_enqueue_scripts', function () {
  $theme_uri = get_stylesheet_directory_uri();

  wp_enqueue_style('kamprogram-base', $theme_uri . '/base.css', [], null);
  wp_enqueue_style('kamprogram-layout', $theme_uri . '/layout.css', ['kamprogram-base'], null);
  wp_enqueue_style('kamprogram-components', $theme_uri . '/components.css', ['kamprogram-layout'], null);
  wp_enqueue_style('kamprogram-utilities', $theme_uri . '/utilities.css', ['kamprogram-components'], null);
  wp_enqueue_style('kamprogram-page-course', $theme_uri . '/pages/course.css', ['kamprogram-utilities'], null);
});


