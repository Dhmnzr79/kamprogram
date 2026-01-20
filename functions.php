<?php

add_action('wp_enqueue_scripts', function () {
  $theme_uri = get_stylesheet_directory_uri();

  wp_enqueue_style('kamprogram-base', $theme_uri . '/assets/css/base.css', [], null);
  wp_enqueue_style('kamprogram-layout', $theme_uri . '/assets/css/layout.css', ['kamprogram-base'], null);
  wp_enqueue_style('kamprogram-components', $theme_uri . '/assets/css/components.css', ['kamprogram-layout'], null);
  wp_enqueue_style('kamprogram-utilities', $theme_uri . '/assets/css/utilities.css', ['kamprogram-components'], null);
  wp_enqueue_style('kamprogram-page-course', $theme_uri . '/assets/css/pages/course.css', ['kamprogram-utilities'], null);

  wp_enqueue_script('kamprogram-reviews-slider', $theme_uri . '/assets/js/reviews-slider.js', [], null, true);
  wp_enqueue_script('kamprogram-header-menu', $theme_uri . '/assets/js/header-menu.js', [], null, true);
  wp_enqueue_script('kamprogram-phone-mask', $theme_uri . '/assets/js/phone-mask.js', [], null, true);
  wp_enqueue_script('kamprogram-modal', $theme_uri . '/assets/js/modal.js', [], null, true);
  wp_enqueue_script('kamprogram-cf7-button', $theme_uri . '/assets/js/cf7-button.js', [], null, true);
  wp_enqueue_script('kamprogram-course-why-parallax', $theme_uri . '/assets/js/course-why-parallax.js', [], null, true);
  wp_enqueue_script('kamprogram-course-lessons-divider', $theme_uri . '/assets/js/course-lessons-divider.js', [], null, true);
});

add_action('admin_enqueue_scripts', function (string $hook_suffix) {
  if ($hook_suffix !== 'post.php' && $hook_suffix !== 'post-new.php') {
    return;
  }

  $screen = function_exists('get_current_screen') ? get_current_screen() : null;
  if (!$screen || $screen->post_type !== 'course') {
    return;
  }

  wp_enqueue_media();
  wp_enqueue_script(
    'kamprogram-admin-course-media',
    get_stylesheet_directory_uri() . '/assets/js/admin-course-media.js',
    ['jquery'],
    null,
    true
  );
});

add_filter('upload_mimes', function (array $mimes) {
  if (!current_user_can('manage_options')) {
    return $mimes;
  }

  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';

  return $mimes;
});

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
  if (!current_user_can('manage_options')) {
    return $data;
  }

  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  if ($ext !== 'svg' && $ext !== 'svgz') {
    return $data;
  }

  return [
    'ext' => $ext,
    'type' => 'image/svg+xml',
    'proper_filename' => $filename,
  ];
}, 10, 4);

add_filter('wp_nav_menu_objects', function (array $items, $args) {
  if (!is_object($args) || ($args->theme_location ?? '') !== 'primary') {
    return $items;
  }

  // Remove previously injected course items to avoid duplicates.
  $items = array_values(array_filter($items, function ($item) {
    return empty($item->kp_generated);
  }));

  $parent = null;
  $parent_index = null;
  $kursy_page = get_page_by_path('kursy');

  // Prefer matching by linked page (/kursy), fallback to title match.
  foreach ($items as $i => $item) {
    if ($kursy_page && isset($item->object, $item->object_id) && $item->object === 'page' && (int) $item->object_id === (int) $kursy_page->ID) {
      $parent = $item;
      $parent_index = $i;
      break;
    }
  }

  if (!$parent) {
    foreach ($items as $i => $item) {
      $title = isset($item->title) ? (string) $item->title : '';
      $title = str_replace("\xC2\xA0", ' ', $title); // nbsp
      $title = preg_replace('/\s+/u', ' ', trim($title));
      $title_lc = function_exists('mb_strtolower') ? mb_strtolower($title) : strtolower($title);

      if ($title_lc === 'наши курсы' || (strpos($title_lc, 'курсы') !== false && empty($item->menu_item_parent))) {
        $parent = $item;
        $parent_index = $i;
        break;
      }
    }
  }

  if (!$parent) {
    return $items;
  }

  $courses = get_posts([
    'post_type' => 'course',
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ]);

  $order_base = 1000;
  foreach ($courses as $idx => $course) {
    // Clone an existing WP menu item so Walker can safely render it as a submenu entry.
    $obj = clone $parent;
    $obj->ID = -1 * (int) $course->ID;
    $obj->db_id = $obj->ID;
    $obj->menu_item_parent = (string) $parent->ID;
    $obj->object_id = (string) $course->ID;
    $obj->object = 'course';
    $obj->type = 'post_type';
    $obj->type_label = 'Курс';
    $obj->title = get_the_title($course);
    $obj->url = get_permalink($course);
    $obj->classes = ['menu-item', 'menu-item-course'];
    $obj->menu_order = $order_base + $idx;
    $obj->kp_generated = true;

    $items[] = $obj;
  }

  // Ensure parent is treated as having children (for JS/CSS selectors).
  if ($parent_index !== null) {
    $classes = is_array($items[$parent_index]->classes ?? null) ? $items[$parent_index]->classes : [];
    if (!in_array('menu-item-has-children', $classes, true)) {
      $classes[] = 'menu-item-has-children';
    }
    $items[$parent_index]->classes = $classes;

    // Prevent navigation on click; this item is a dropdown trigger.
    $items[$parent_index]->url = '#';
  }

  return $items;
}, 10, 2);

add_filter('body_class', function (array $classes) {
  $has_hero = is_front_page() || is_page_template('page-templates/template-course.php') || is_singular('course');
  $classes[] = $has_hero ? 'has-hero' : 'no-hero';

  $about_page = get_page_by_path('o-nas');
  $contacts_page = get_page_by_path('kontakty');
  
  if ($about_page && is_page($about_page->ID)) {
    $classes[] = 'page-is-about';
  }
  
  if ($contacts_page && is_page($contacts_page->ID)) {
    $classes[] = 'page-is-contacts';
  }

  return $classes;
});

add_action('after_setup_theme', function () {
  register_nav_menus([
    'primary' => 'Primary menu',
  ]);

  add_theme_support('post-thumbnails', ['course']);
});

add_action('after_switch_theme', function () {
  $pages = [
    'Главная' => [
      'slug' => 'glavnaya',
      'template' => 'default',
    ],
    'О нас' => [
      'slug' => 'o-nas',
      'template' => 'default',
    ],
    'Контакты' => [
      'slug' => 'kontakty',
      'template' => 'default',
    ],
  ];

  $page_ids = [];

  foreach ($pages as $title => $data) {
    $existing_page = get_page_by_path($data['slug']);

    if ($existing_page) {
      $page_ids[$title] = $existing_page->ID;
      continue;
    }

    $new_page_id = wp_insert_post([
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_title' => $title,
      'post_name' => $data['slug'],
    ]);

    if (!is_wp_error($new_page_id) && $new_page_id) {
      $page_ids[$title] = $new_page_id;
    }
  }

  if (empty(get_option('page_on_front')) && !empty($page_ids['Главная'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['Главная']);
  }

  $menu_name = 'Main';
  $menu_obj = wp_get_nav_menu_object($menu_name);

  if (!$menu_obj) {
    $menu_id = wp_create_nav_menu($menu_name);
  } else {
    $menu_id = (int) $menu_obj->term_id;
  }

  foreach ($pages as $title => $data) {
    if (empty($page_ids[$title])) {
      continue;
    }

    wp_update_nav_menu_item($menu_id, 0, [
      'menu-item-title' => $title,
      'menu-item-object' => 'page',
      'menu-item-object-id' => $page_ids[$title],
      'menu-item-type' => 'post_type',
      'menu-item-status' => 'publish',
    ]);
  }

  $locations = get_theme_mod('nav_menu_locations', []);
  $locations['primary'] = $menu_id;
  set_theme_mod('nav_menu_locations', $locations);
});

add_action('init', function () {
  // Hard repair: rebuild broken primary menu items if they became empty (<a></a>).
  // Runs once.
  if (get_option('kamprogram_rebuild_menu_v1')) {
    return;
  }

  $locations = get_theme_mod('nav_menu_locations', []);
  $primary_menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;
  if (!$primary_menu_id) {
    // Fallback to a menu named "Main" if location not set.
    $menu_obj = wp_get_nav_menu_object('Main');
    $primary_menu_id = $menu_obj ? (int) $menu_obj->term_id : 0;
  }

  if (!$primary_menu_id) {
    update_option('kamprogram_rebuild_menu_v1', 1);
    return;
  }

  $items = wp_get_nav_menu_items($primary_menu_id);
  $has_broken = false;
  if (is_array($items)) {
    foreach ($items as $it) {
      if (!empty($it->menu_item_parent)) {
        continue;
      }
      $t = is_string($it->title ?? null) ? trim((string) $it->title) : '';
      $u = is_string($it->url ?? null) ? trim((string) $it->url) : '';
      if ($t === '' || $u === '') {
        $has_broken = true;
        break;
      }
    }
  }

  if (!$has_broken) {
    update_option('kamprogram_rebuild_menu_v1', 1);
    return;
  }

  // Delete all existing items in this menu (top-level and children).
  if (is_array($items)) {
    foreach ($items as $it) {
      wp_delete_post((int) $it->ID, true);
    }
  }

  // Ensure required pages exist.
  $about_page = get_page_by_path('o-nas');
  $contacts_page = get_page_by_path('kontakty');

  // Recreate menu items in required order.
  wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title' => 'Главная',
    'menu-item-type' => 'custom',
    'menu-item-url' => home_url('/'),
    'menu-item-status' => 'publish',
    'menu-item-position' => 1,
  ]);

  $courses_item_id = wp_update_nav_menu_item($primary_menu_id, 0, [
    'menu-item-title' => 'Наши курсы',
    'menu-item-type' => 'custom',
    'menu-item-url' => '#',
    'menu-item-status' => 'publish',
    'menu-item-position' => 2,
  ]);

  if ($about_page) {
    wp_update_nav_menu_item($primary_menu_id, 0, [
      'menu-item-title' => 'О нас',
      'menu-item-object' => 'page',
      'menu-item-object-id' => (int) $about_page->ID,
      'menu-item-type' => 'post_type',
      'menu-item-status' => 'publish',
      'menu-item-position' => 3,
    ]);
  }

  if ($contacts_page) {
    wp_update_nav_menu_item($primary_menu_id, 0, [
      'menu-item-title' => 'Контакты',
      'menu-item-object' => 'page',
      'menu-item-object-id' => (int) $contacts_page->ID,
      'menu-item-type' => 'post_type',
      'menu-item-status' => 'publish',
      'menu-item-position' => 4,
    ]);
  }

  // Assign menu to primary location.
  $locations = get_theme_mod('nav_menu_locations', []);
  $locations['primary'] = $primary_menu_id;
  set_theme_mod('nav_menu_locations', $locations);

  // Stop older menu migrations from re-running.
  update_option('kamprogram_menu_order_v1', 1);
  update_option('kamprogram_menu_order_v2', 1);
  update_option('kamprogram_menu_repair_v1', 1);

  // Keep for clarity (and possible future use).
  if (!empty($courses_item_id)) {
    update_option('kamprogram_menu_courses_parent_id', (int) $courses_item_id);
  }

  update_option('kamprogram_rebuild_menu_v1', 1);
}, 1);

add_action('init', function () {
  if (get_option('kamprogram_deleted_kursy_page_v1')) {
    return;
  }

  $kursy_page = get_page_by_path('kursy');
  if (!$kursy_page) {
    update_option('kamprogram_deleted_kursy_page_v1', 1);
    return;
  }

  $kursy_id = (int) $kursy_page->ID;

  // Convert any menu item pointing to this page into a dropdown trigger.
  $locations = get_theme_mod('nav_menu_locations', []);
  $primary_menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;

  if ($primary_menu_id) {
    $items = wp_get_nav_menu_items($primary_menu_id);
    if (is_array($items)) {
      foreach ($items as $item) {
        $is_kursy_link = ($item->object === 'page' && (int) $item->object_id === $kursy_id)
          || (is_string($item->url) && (strpos($item->url, 'page_id=' . $kursy_id) !== false));

        if (!$is_kursy_link) {
          continue;
        }

        wp_update_nav_menu_item($primary_menu_id, (int) $item->ID, [
          'menu-item-title' => 'Наши курсы',
          'menu-item-type' => 'custom',
          'menu-item-url' => '#',
          'menu-item-status' => 'publish',
        ]);
      }
    }
  }

  // Delete the page permanently.
  wp_delete_post($kursy_id, true);

  update_option('kamprogram_deleted_kursy_page_v1', 1);
});

add_action('init', function () {
  if (get_option('kamprogram_menu_order_v1')) {
    return;
  }

  $locations = get_theme_mod('nav_menu_locations', []);
  $primary_menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;
  if (!$primary_menu_id) {
    update_option('kamprogram_menu_order_v1', 1);
    return;
  }

  $items = wp_get_nav_menu_items($primary_menu_id);
  if (!is_array($items)) {
    update_option('kamprogram_menu_order_v1', 1);
    return;
  }

  $normalize = function ($s) {
    $s = is_string($s) ? $s : '';
    $s = str_replace("\xC2\xA0", ' ', $s); // nbsp
    $s = preg_replace('/\s+/u', ' ', trim($s));
    return function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
  };

  $top = [];
  foreach ($items as $item) {
    if (!empty($item->menu_item_parent)) {
      continue;
    }
    $top[] = $item;
  }

  $find = function (callable $predicate) use ($top) {
    foreach ($top as $item) {
      if ($predicate($item)) {
        return $item;
      }
    }
    return null;
  };

  $home = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'главная';
  });
  $courses = $find(function ($item) use ($normalize) {
    $t = $normalize($item->title ?? '');
    return $t === 'наши курсы' || $t === 'курсы';
  });
  $about = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'о нас';
  });
  $contacts = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'контакты';
  });

  $pos = 1;
  foreach ([$home, $courses, $about, $contacts] as $item) {
    if (!$item) {
      continue;
    }
    // Safe ordering: update post menu_order only (do not rewrite menu item meta).
    wp_update_post([
      'ID' => (int) $item->ID,
      'menu_order' => $pos,
      'post_status' => 'publish',
    ]);
    $pos++;
  }

  update_option('kamprogram_menu_order_v1', 1);
});

add_action('init', function () {
  // Fix for sites where v1 reorder could have broken menu items.
  if (get_option('kamprogram_menu_order_v2')) {
    return;
  }

  $locations = get_theme_mod('nav_menu_locations', []);
  $primary_menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;
  if (!$primary_menu_id) {
    update_option('kamprogram_menu_order_v2', 1);
    return;
  }

  $items = wp_get_nav_menu_items($primary_menu_id);
  if (!is_array($items)) {
    update_option('kamprogram_menu_order_v2', 1);
    return;
  }

  $normalize = function ($s) {
    $s = is_string($s) ? $s : '';
    $s = str_replace("\xC2\xA0", ' ', $s); // nbsp
    $s = preg_replace('/\s+/u', ' ', trim($s));
    return function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
  };

  $top = [];
  foreach ($items as $item) {
    if (!empty($item->menu_item_parent)) {
      continue;
    }
    $top[] = $item;
  }

  $find = function (callable $predicate) use ($top) {
    foreach ($top as $item) {
      if ($predicate($item)) {
        return $item;
      }
    }
    return null;
  };

  $home = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'главная';
  });
  $courses = $find(function ($item) use ($normalize) {
    $t = $normalize($item->title ?? '');
    return $t === 'наши курсы' || $t === 'курсы';
  });
  $about = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'о нас';
  });
  $contacts = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'контакты';
  });

  $ordered = array_values(array_filter([$home, $courses, $about, $contacts]));
  $ordered_ids = array_map(function ($i) { return (int) $i->ID; }, $ordered);

  $pos = 1;
  foreach ($ordered as $item) {
    wp_update_post([
      'ID' => (int) $item->ID,
      'menu_order' => $pos,
      'post_status' => 'publish',
    ]);
    $pos++;
  }

  // Keep any other top-level items after the required ones.
  foreach ($top as $item) {
    if (in_array((int) $item->ID, $ordered_ids, true)) {
      continue;
    }
    wp_update_post([
      'ID' => (int) $item->ID,
      'menu_order' => $pos,
      'post_status' => 'publish',
    ]);
    $pos++;
  }

  update_option('kamprogram_menu_order_v2', 1);
});

add_action('init', function () {
  // Repair menu items if their URLs became empty due to previous migrations.
  if (get_option('kamprogram_menu_repair_v1')) {
    return;
  }

  $locations = get_theme_mod('nav_menu_locations', []);
  $primary_menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;
  if (!$primary_menu_id) {
    update_option('kamprogram_menu_repair_v1', 1);
    return;
  }

  $items = wp_get_nav_menu_items($primary_menu_id);
  if (!is_array($items)) {
    update_option('kamprogram_menu_repair_v1', 1);
    return;
  }

  $normalize = function ($s) {
    $s = is_string($s) ? $s : '';
    $s = str_replace("\xC2\xA0", ' ', $s); // nbsp
    $s = preg_replace('/\s+/u', ' ', trim($s));
    return function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
  };

  $get_top = function () use ($items) {
    $top = [];
    foreach ($items as $it) {
      if (!empty($it->menu_item_parent)) {
        continue;
      }
      $top[] = $it;
    }
    return $top;
  };

  $top = $get_top();

  $find = function (callable $predicate) use ($top) {
    foreach ($top as $item) {
      if ($predicate($item)) {
        return $item;
      }
    }
    return null;
  };

  $home_item = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'главная';
  });
  $courses_item = $find(function ($item) use ($normalize) {
    $t = $normalize($item->title ?? '');
    return $t === 'наши курсы' || $t === 'курсы';
  });
  $about_item = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'о нас';
  });
  $contacts_item = $find(function ($item) use ($normalize) {
    return $normalize($item->title ?? '') === 'контакты';
  });

  $about_page = get_page_by_path('o-nas');
  $contacts_page = get_page_by_path('kontakty');

  if ($home_item && empty($home_item->url)) {
    wp_update_nav_menu_item($primary_menu_id, (int) $home_item->ID, [
      'menu-item-title' => 'Главная',
      'menu-item-type' => 'custom',
      'menu-item-url' => home_url('/'),
      'menu-item-status' => 'publish',
    ]);
  }

  if ($courses_item && empty($courses_item->url)) {
    wp_update_nav_menu_item($primary_menu_id, (int) $courses_item->ID, [
      'menu-item-title' => 'Наши курсы',
      'menu-item-type' => 'custom',
      'menu-item-url' => '#',
      'menu-item-status' => 'publish',
    ]);
  }

  if ($about_item && $about_page && empty($about_item->url)) {
    wp_update_nav_menu_item($primary_menu_id, (int) $about_item->ID, [
      'menu-item-title' => 'О нас',
      'menu-item-object' => 'page',
      'menu-item-object-id' => (int) $about_page->ID,
      'menu-item-type' => 'post_type',
      'menu-item-status' => 'publish',
    ]);
  }

  if ($contacts_item && $contacts_page && empty($contacts_item->url)) {
    wp_update_nav_menu_item($primary_menu_id, (int) $contacts_item->ID, [
      'menu-item-title' => 'Контакты',
      'menu-item-object' => 'page',
      'menu-item-object-id' => (int) $contacts_page->ID,
      'menu-item-type' => 'post_type',
      'menu-item-status' => 'publish',
    ]);
  }

  // Force required order positions as requested.
  $pos = 1;
  foreach ([$home_item, $courses_item, $about_item, $contacts_item] as $it) {
    if (!$it) {
      continue;
    }
    wp_update_post([
      'ID' => (int) $it->ID,
      'menu_order' => $pos,
      'post_status' => 'publish',
    ]);
    $pos++;
  }

  update_option('kamprogram_menu_repair_v1', 1);
});

add_action('init', function () {
  if (get_option('kamprogram_migrated_about_page_v1')) {
    return;
  }

  $old_slug = implode('', ['o', '-', 'sh', 'kole']);
  $old_title = 'О ' . implode('', ['шк', 'оле']);

  $old_page = get_page_by_path($old_slug);
  $new_page = get_page_by_path('o-nas');

  $about_page_id = 0;

  if ($old_page && !$new_page) {
    wp_update_post([
      'ID' => $old_page->ID,
      'post_title' => 'О нас',
      'post_name' => 'o-nas',
    ]);

    $about_page_id = (int) $old_page->ID;
  } elseif ($old_page && $new_page) {
    $unique_slug = wp_unique_post_slug('o-nas-old', $old_page->ID, 'draft', 'page', 0);

    wp_update_post([
      'ID' => $old_page->ID,
      'post_status' => 'draft',
      'post_title' => 'О нас (старое)',
      'post_name' => $unique_slug,
    ]);

    $about_page_id = (int) $new_page->ID;
  } elseif ($new_page) {
    $about_page_id = (int) $new_page->ID;
  }

  $menu_obj = wp_get_nav_menu_object('Main');

  if ($menu_obj && $about_page_id) {
    $items = wp_get_nav_menu_items((int) $menu_obj->term_id);

    if (is_array($items)) {
      foreach ($items as $item) {
        if ($old_page && (int) $item->object_id === (int) $old_page->ID) {
          wp_update_nav_menu_item((int) $menu_obj->term_id, (int) $item->ID, [
            'menu-item-title' => 'О нас',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $about_page_id,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
          ]);
        }

        if ($item->title === $old_title) {
          wp_update_nav_menu_item((int) $menu_obj->term_id, (int) $item->ID, [
            'menu-item-title' => 'О нас',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $about_page_id,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
          ]);
        }
      }
    }
  }

  update_option('kamprogram_migrated_about_page_v1', 1);
});


add_action('init', function () {
  register_post_type('course', [
    'labels' => [
      'name' => 'Курсы',
      'singular_name' => 'Курс',
      'add_new' => 'Добавить курс',
      'add_new_item' => 'Добавить курс',
      'edit_item' => 'Редактировать курс',
      'new_item' => 'Новый курс',
      'view_item' => 'Посмотреть курс',
      'search_items' => 'Найти курс',
      'not_found' => 'Не найдено',
      'not_found_in_trash' => 'В корзине не найдено',
      'all_items' => 'Все курсы',
      'menu_name' => 'Курсы',
      'name_admin_bar' => 'Курс',
    ],
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => false,
    'rewrite' => ['slug' => 'course'],
    'menu_position' => 20,
    'supports' => ['title', 'thumbnail'],
  ]);
});

function kp_course_meta_get(int $post_id, string $key, $default = '') {
  $value = get_post_meta($post_id, $key, true);
  if ($value === '' || $value === null) {
    return $default;
  }
  return $value;
}

add_action('add_meta_boxes', function () {
  remove_meta_box('postimagediv', 'course', 'side');
  add_meta_box(
    'postimagediv',
    'Фото',
    'post_thumbnail_meta_box',
    'course',
    'normal',
    'high'
  );

  add_meta_box(
    'kp_course_general',
    'Курс — Общие поля',
    'kp_course_metabox_general_render',
    'course',
    'normal',
    'high'
  );

  add_meta_box(
    'kp_course_sections',
    'Курс — Секции страницы',
    'kp_course_metabox_sections_render',
    'course',
    'normal',
    'default'
  );
});

function kp_course_metabox_general_render(\WP_Post $post) {
  wp_nonce_field('kp_course_save_meta', 'kp_course_nonce');

  $short = kp_course_meta_get($post->ID, '_kp_course_short', '');
  $price = kp_course_meta_get($post->ID, '_kp_course_price', '');
  $age = kp_course_meta_get($post->ID, '_kp_course_age', '');
  $schedule = kp_course_meta_get($post->ID, '_kp_course_schedule', '');
  $duration = kp_course_meta_get($post->ID, '_kp_course_duration', '');
  ?>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_course_short">Краткое описание</label></th>
        <td>
          <textarea id="kp_course_short" name="kp_course_short" rows="3" class="large-text"><?php echo esc_textarea($short); ?></textarea>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_course_price">Стоимость</label></th>
        <td><input id="kp_course_price" name="kp_course_price" type="text" class="regular-text" value="<?php echo esc_attr($price); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_course_age">Возраст</label></th>
        <td><input id="kp_course_age" name="kp_course_age" type="text" class="regular-text" value="<?php echo esc_attr($age); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_course_schedule">График</label></th>
        <td><input id="kp_course_schedule" name="kp_course_schedule" type="text" class="regular-text" value="<?php echo esc_attr($schedule); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_course_duration">Длительность</label></th>
        <td><input id="kp_course_duration" name="kp_course_duration" type="text" class="regular-text" value="<?php echo esc_attr($duration); ?>"></td>
      </tr>
    </tbody>
  </table>
  <?php
}

function kp_course_metabox_sections_render(\WP_Post $post) {
  wp_nonce_field('kp_course_save_meta', 'kp_course_nonce');

  $hero_h1 = kp_course_meta_get($post->ID, '_kp_hero_h1', '');
  $hero_text = kp_course_meta_get($post->ID, '_kp_hero_text', '');
  $hero_kid_photo_id = (int) kp_course_meta_get($post->ID, '_kp_hero_kid_photo_id', 0);
  $hero_kid_photo_url = $hero_kid_photo_id ? wp_get_attachment_url($hero_kid_photo_id) : '';

  $for_title = kp_course_meta_get($post->ID, '_kp_for_title', '');
  $for_subtitle = kp_course_meta_get($post->ID, '_kp_for_subtitle', '');
  $for_items = (array) kp_course_meta_get($post->ID, '_kp_for_items', []);

  $why_title = kp_course_meta_get($post->ID, '_kp_why_title', '');
  $why_text = kp_course_meta_get($post->ID, '_kp_why_text', '');
  $why_btn = kp_course_meta_get($post->ID, '_kp_why_btn', '');
  $why_photo_id = (int) kp_course_meta_get($post->ID, '_kp_why_photo_id', 0);
  $why_photo_url = $why_photo_id ? wp_get_attachment_url($why_photo_id) : '';

  $less_title = kp_course_meta_get($post->ID, '_kp_less_title', '');
  $less_text = kp_course_meta_get($post->ID, '_kp_less_text', '');
  $less_items = (array) kp_course_meta_get($post->ID, '_kp_less_items', []);
  $less_extra = kp_course_meta_get($post->ID, '_kp_less_extra', '');

  $res_cards = (array) kp_course_meta_get($post->ID, '_kp_res_cards', []);

  $cta_title = kp_course_meta_get($post->ID, '_kp_cta_title', '');
  $cta_text = kp_course_meta_get($post->ID, '_kp_cta_text', '');
  ?>

  <h3>Hero</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_hero_h1">H1</label></th>
        <td><input id="kp_hero_h1" name="kp_hero_h1" type="text" class="large-text" value="<?php echo esc_attr($hero_h1); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_hero_text">Расшифровка</label></th>
        <td><textarea id="kp_hero_text" name="kp_hero_text" rows="3" class="large-text"><?php echo esc_textarea($hero_text); ?></textarea></td>
      </tr>
      <tr>
        <th scope="row">PNG фото ребёнка</th>
        <td>
          <input type="hidden" name="kp_hero_kid_photo_id" value="<?php echo esc_attr((string) $hero_kid_photo_id); ?>" data-kp-hero-kid-photo-input>
          <div data-kp-hero-kid-photo-preview>
            <?php if ($hero_kid_photo_url) : ?>
              <img src="<?php echo esc_url($hero_kid_photo_url); ?>" alt="" style="max-width: 100%; height: auto;">
            <?php endif; ?>
          </div>
          <p>
            <button type="button" class="button" data-kp-hero-kid-photo-open>Загрузить</button>
            <button type="button" class="button" data-kp-hero-kid-photo-remove <?php echo $hero_kid_photo_id ? '' : 'hidden'; ?>>Удалить</button>
          </p>
        </td>
      </tr>
    </tbody>
  </table>

  <hr>

  <h3>Для кого</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_for_title">Заголовок</label></th>
        <td><input id="kp_for_title" name="kp_for_title" type="text" class="large-text" value="<?php echo esc_attr($for_title); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_for_subtitle">Подзаголовок</label></th>
        <td><textarea id="kp_for_subtitle" name="kp_for_subtitle" rows="2" class="large-text"><?php echo esc_textarea($for_subtitle); ?></textarea></td>
      </tr>
      <?php for ($i = 0; $i < 3; $i++) : ?>
        <tr>
          <th scope="row"><label for="kp_for_items_<?php echo (int) $i; ?>">Пункт <?php echo (int) ($i + 1); ?></label></th>
          <td>
            <input
              id="kp_for_items_<?php echo (int) $i; ?>"
              name="kp_for_items[]"
              type="text"
              class="large-text"
              value="<?php echo esc_attr($for_items[$i] ?? ''); ?>"
            >
          </td>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>

  <hr>

  <h3>Почему важен курс</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_why_title">Заголовок</label></th>
        <td><input id="kp_why_title" name="kp_why_title" type="text" class="large-text" value="<?php echo esc_attr($why_title); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_why_text">Расшифровка</label></th>
        <td><textarea id="kp_why_text" name="kp_why_text" rows="3" class="large-text"><?php echo esc_textarea($why_text); ?></textarea></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_why_btn">Название кнопки</label></th>
        <td><input id="kp_why_btn" name="kp_why_btn" type="text" class="regular-text" value="<?php echo esc_attr($why_btn); ?>"></td>
      </tr>
      <tr>
        <th scope="row">Фото</th>
        <td>
          <input type="hidden" name="kp_why_photo_id" value="<?php echo esc_attr((string) $why_photo_id); ?>" data-kp-why-photo-input>
          <div data-kp-why-photo-preview>
            <?php if ($why_photo_url) : ?>
              <img src="<?php echo esc_url($why_photo_url); ?>" alt="" style="max-width: 100%; height: auto;">
            <?php endif; ?>
          </div>
          <p>
            <button type="button" class="button" data-kp-why-photo-open>Загрузить</button>
            <button type="button" class="button" data-kp-why-photo-remove <?php echo $why_photo_id ? '' : 'hidden'; ?>>Удалить</button>
          </p>
        </td>
      </tr>
    </tbody>
  </table>

  <hr>

  <h3>Что будет на занятиях</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_less_title">Заголовок</label></th>
        <td><input id="kp_less_title" name="kp_less_title" type="text" class="large-text" value="<?php echo esc_attr($less_title); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_less_text">Расшифровка</label></th>
        <td><textarea id="kp_less_text" name="kp_less_text" rows="3" class="large-text"><?php echo esc_textarea($less_text); ?></textarea></td>
      </tr>
      <?php for ($i = 0; $i < 4; $i++) :
        $item = is_array($less_items[$i] ?? null) ? $less_items[$i] : [];
        $item_title = $item['title'] ?? '';
        $item_text = $item['text'] ?? '';
        ?>
        <tr>
          <th scope="row">Пункт <?php echo (int) ($i + 1); ?></th>
          <td>
            <p><label>Заголовок<br><input name="kp_less_items[<?php echo (int) $i; ?>][title]" type="text" class="large-text" value="<?php echo esc_attr($item_title); ?>"></label></p>
            <p><label>Текст<br><textarea name="kp_less_items[<?php echo (int) $i; ?>][text]" rows="2" class="large-text"><?php echo esc_textarea($item_text); ?></textarea></label></p>
          </td>
        </tr>
      <?php endfor; ?>
      <tr>
        <th scope="row"><label for="kp_less_extra">Дополнительный текст</label></th>
        <td><textarea id="kp_less_extra" name="kp_less_extra" rows="2" class="large-text"><?php echo esc_textarea($less_extra); ?></textarea></td>
      </tr>
    </tbody>
  </table>

  <hr>

  <h3>Результат обучения</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <?php for ($i = 0; $i < 3; $i++) :
        $card = is_array($res_cards[$i] ?? null) ? $res_cards[$i] : [];
        $icon_id = (int) ($card['icon_id'] ?? 0);
        $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';
        $title = $card['title'] ?? '';
        $text = $card['text'] ?? '';
        ?>
        <tr>
          <th scope="row">Карточка <?php echo (int) ($i + 1); ?></th>
          <td>
            <p>
              <label>Иконка</label><br>
              <input type="hidden" name="kp_res_cards[<?php echo (int) $i; ?>][icon_id]" value="<?php echo esc_attr((string) $icon_id); ?>" data-kp-card-input="<?php echo (int) $i; ?>">
              <span data-kp-card-preview="<?php echo (int) $i; ?>">
                <?php if ($icon_url) : ?>
                  <img src="<?php echo esc_url($icon_url); ?>" alt="" style="max-width: 100px; height: auto;">
                <?php endif; ?>
              </span>
              <br>
              <button type="button" class="button" data-kp-card-open="<?php echo (int) $i; ?>">Загрузить</button>
              <button type="button" class="button" data-kp-card-remove="<?php echo (int) $i; ?>" <?php echo $icon_id ? '' : 'hidden'; ?>>Удалить</button>
            </p>
            <p><label>Заголовок<br><input name="kp_res_cards[<?php echo (int) $i; ?>][title]" type="text" class="large-text" value="<?php echo esc_attr($title); ?>"></label></p>
            <p><label>Текст<br><textarea name="kp_res_cards[<?php echo (int) $i; ?>][text]" rows="2" class="large-text"><?php echo esc_textarea($text); ?></textarea></label></p>
          </td>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>

  <hr>

  <h3>CTA</h3>
  <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="kp_cta_title">Заголовок</label></th>
        <td><input id="kp_cta_title" name="kp_cta_title" type="text" class="large-text" value="<?php echo esc_attr($cta_title); ?>"></td>
      </tr>
      <tr>
        <th scope="row"><label for="kp_cta_text">Расшифровка</label></th>
        <td><textarea id="kp_cta_text" name="kp_cta_text" rows="3" class="large-text"><?php echo esc_textarea($cta_text); ?></textarea></td>
      </tr>
    </tbody>
  </table>
  <?php
}

add_action('save_post_course', function (int $post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!isset($_POST['kp_course_nonce']) || !wp_verify_nonce($_POST['kp_course_nonce'], 'kp_course_save_meta')) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  $set_text = function (string $post_key, string $meta_key, bool $is_textarea = false) use ($post_id) {
    if (!array_key_exists($post_key, $_POST)) {
      return;
    }

    $raw = $_POST[$post_key];
    $value = is_string($raw) ? ($is_textarea ? sanitize_textarea_field($raw) : sanitize_text_field($raw)) : '';
    update_post_meta($post_id, $meta_key, $value);
  };

  $set_text('kp_course_short', '_kp_course_short', true);
  $set_text('kp_course_price', '_kp_course_price');
  $set_text('kp_course_age', '_kp_course_age');
  $set_text('kp_course_schedule', '_kp_course_schedule');
  $set_text('kp_course_duration', '_kp_course_duration');

  $set_text('kp_hero_h1', '_kp_hero_h1');
  $set_text('kp_hero_text', '_kp_hero_text', true);

  if (isset($_POST['kp_hero_kid_photo_id'])) {
    $hero_kid_photo_id = is_string($_POST['kp_hero_kid_photo_id']) ? (int) $_POST['kp_hero_kid_photo_id'] : 0;
    update_post_meta($post_id, '_kp_hero_kid_photo_id', $hero_kid_photo_id > 0 ? $hero_kid_photo_id : 0);
  }

  $set_text('kp_for_title', '_kp_for_title');
  $set_text('kp_for_subtitle', '_kp_for_subtitle', true);

  if (isset($_POST['kp_for_items']) && is_array($_POST['kp_for_items'])) {
    $items = array_slice($_POST['kp_for_items'], 0, 3);
    $items = array_map(function ($v) {
      return is_string($v) ? sanitize_text_field($v) : '';
    }, $items);
    update_post_meta($post_id, '_kp_for_items', $items);
  }

  $set_text('kp_why_title', '_kp_why_title');
  $set_text('kp_why_text', '_kp_why_text', true);
  $set_text('kp_why_btn', '_kp_why_btn');

  if (isset($_POST['kp_why_photo_id'])) {
    $why_photo_id = is_string($_POST['kp_why_photo_id']) ? (int) $_POST['kp_why_photo_id'] : 0;
    update_post_meta($post_id, '_kp_why_photo_id', $why_photo_id > 0 ? $why_photo_id : 0);
  }

  $set_text('kp_less_title', '_kp_less_title');
  $set_text('kp_less_text', '_kp_less_text', true);
  $set_text('kp_less_extra', '_kp_less_extra', true);

  if (isset($_POST['kp_less_items']) && is_array($_POST['kp_less_items'])) {
    $raw_items = array_slice($_POST['kp_less_items'], 0, 4, true);
    $items = [];
    for ($i = 0; $i < 4; $i++) {
      $row = is_array($raw_items[$i] ?? null) ? $raw_items[$i] : [];
      $items[] = [
        'title' => is_string($row['title'] ?? null) ? sanitize_text_field($row['title']) : '',
        'text' => is_string($row['text'] ?? null) ? sanitize_textarea_field($row['text']) : '',
      ];
    }
    update_post_meta($post_id, '_kp_less_items', $items);
  }

  if (isset($_POST['kp_res_cards']) && is_array($_POST['kp_res_cards'])) {
    $raw_cards = array_slice($_POST['kp_res_cards'], 0, 3, true);
    $cards = [];
    for ($i = 0; $i < 3; $i++) {
      $row = is_array($raw_cards[$i] ?? null) ? $raw_cards[$i] : [];
      $cards[] = [
        'icon_id' => isset($row['icon_id']) && (is_string($row['icon_id']) || is_int($row['icon_id']) || is_float($row['icon_id'])) ? max(0, (int) $row['icon_id']) : 0,
        'title' => is_string($row['title'] ?? null) ? sanitize_text_field($row['title']) : '',
        'text' => is_string($row['text'] ?? null) ? sanitize_textarea_field($row['text']) : '',
      ];
    }
    update_post_meta($post_id, '_kp_res_cards', $cards);
  }

  $set_text('kp_cta_title', '_kp_cta_title');
  $set_text('kp_cta_text', '_kp_cta_text', true);
});

// Отключаем автоматическое добавление <br> и <p> в формах CF7
add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('wpcf7_form_elements', function ($content) {
  // Заменяем input[type="submit"] на button с классами и иконкой
  $icon_svg = '<svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  
  // Паттерн для поиска input submit
  $pattern = '/<input\s+([^>]*type=["\']submit["\'][^>]*)>/i';
  
  $content = preg_replace_callback(
    $pattern,
    function ($matches) use ($icon_svg) {
      $attrs_string = $matches[1];
      
      // Парсим атрибуты
      $attrs = [];
      $name = '';
      $id = '';
      $value = 'Отправить заявку';
      
      // Извлекаем name
      if (preg_match('/name=["\']([^"\']+)["\']/i', $attrs_string, $m)) {
        $name = ' name="' . esc_attr($m[1]) . '"';
      }
      
      // Извлекаем id
      if (preg_match('/id=["\']([^"\']+)["\']/i', $attrs_string, $m)) {
        $id = ' id="' . esc_attr($m[1]) . '"';
      }
      
      // Извлекаем value (текст кнопки)
      if (preg_match('/value=["\']([^"\']+)["\']/i', $attrs_string, $m)) {
        $value = esc_html($m[1]);
      }
      
      // Собираем button без пробелов между элементами (чтобы избежать <br>)
      return '<button type="submit" class="btn btn-primary"' . $name . $id . '>' . trim($value) . $icon_svg . '</button>';
    },
    $content
  );
  
  // Удаляем лишние <br> которые могли появиться
  $content = str_replace(['<br />', '<br>', '<br/>'], '', $content);
  
  return $content;
});


