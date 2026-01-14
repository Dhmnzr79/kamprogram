<?php

add_action('wp_enqueue_scripts', function () {
  $theme_uri = get_stylesheet_directory_uri();

  wp_enqueue_style('kamprogram-base', $theme_uri . '/assets/css/base.css', [], null);
  wp_enqueue_style('kamprogram-layout', $theme_uri . '/assets/css/layout.css', ['kamprogram-base'], null);
  wp_enqueue_style('kamprogram-components', $theme_uri . '/assets/css/components.css', ['kamprogram-layout'], null);
  wp_enqueue_style('kamprogram-utilities', $theme_uri . '/assets/css/utilities.css', ['kamprogram-components'], null);
  wp_enqueue_style('kamprogram-page-course', $theme_uri . '/assets/css/pages/course.css', ['kamprogram-utilities'], null);
});

add_filter('body_class', function (array $classes) {
  $has_hero = is_front_page() || is_page_template('page-templates/template-course.php');
  $classes[] = $has_hero ? 'has-hero' : 'no-hero';

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
    'Курсы' => [
      'slug' => 'kursy',
      'template' => 'page-templates/template-course.php',
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

  if (!empty($page_ids['Курсы'])) {
    update_post_meta($page_ids['Курсы'], '_wp_page_template', 'page-templates/template-course.php');
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

  $for_title = kp_course_meta_get($post->ID, '_kp_for_title', '');
  $for_subtitle = kp_course_meta_get($post->ID, '_kp_for_subtitle', '');
  $for_items = (array) kp_course_meta_get($post->ID, '_kp_for_items', []);

  $why_title = kp_course_meta_get($post->ID, '_kp_why_title', '');
  $why_text = kp_course_meta_get($post->ID, '_kp_why_text', '');
  $why_btn = kp_course_meta_get($post->ID, '_kp_why_btn', '');

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
        $icon = $card['icon'] ?? '';
        $title = $card['title'] ?? '';
        $text = $card['text'] ?? '';
        ?>
        <tr>
          <th scope="row">Карточка <?php echo (int) ($i + 1); ?></th>
          <td>
            <p><label>Иконка (URL)<br><input name="kp_res_cards[<?php echo (int) $i; ?>][icon]" type="text" class="large-text" value="<?php echo esc_attr($icon); ?>"></label></p>
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
        'icon' => is_string($row['icon'] ?? null) ? esc_url_raw($row['icon']) : '',
        'title' => is_string($row['title'] ?? null) ? sanitize_text_field($row['title']) : '',
        'text' => is_string($row['text'] ?? null) ? sanitize_textarea_field($row['text']) : '',
      ];
    }
    update_post_meta($post_id, '_kp_res_cards', $cards);
  }

  $set_text('kp_cta_title', '_kp_cta_title');
  $set_text('kp_cta_text', '_kp_cta_text', true);
});


