<?php
/** Standalone 1C campaign: page and a dedicated Contact Form 7 form. */

add_action('wp_enqueue_scripts', function () {
  $uri = get_stylesheet_directory_uri();
  $dir = get_stylesheet_directory();
  if (is_front_page()) {
    wp_enqueue_style('kamprogram-course-promo', $uri . '/assets/css/course-promo.css', ['kamprogram-utilities'], filemtime($dir . '/assets/css/course-promo.css'));
  }
  if (is_page('1c-besplatno')) {
    wp_enqueue_style('kamprogram-free-course', $uri . '/assets/css/pages/free-course.css', ['kamprogram-utilities'], filemtime($dir . '/assets/css/pages/free-course.css'));
    wp_enqueue_script('kamprogram-free-course', $uri . '/assets/js/free-course.js', [], filemtime($dir . '/assets/js/free-course.js'), true);
  }
}, 20);

add_action('init', function () {
  if (!get_option('kamprogram_free_course_page_created')) {
    $page = get_page_by_path('1c-besplatno');
    $page_id = $page ? $page->ID : wp_insert_post([
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_title' => 'Бесплатные курсы программирования 1С',
      'post_name' => '1c-besplatno',
      'post_content' => '',
    ], true);
    if (!is_wp_error($page_id) && $page_id) {
      update_option('kamprogram_free_course_page_created', (int) $page_id, false);
    }
  }

  // Create once; later edits to this independent form in CF7 are preserved.
  if (!class_exists('WPCF7_ContactForm') || get_option('kamprogram_free_course_form_id')) {
    return;
  }

  $form = WPCF7_ContactForm::get_template(['locale' => 'ru_RU']);
  $form->set_title('Бесплатный курс 1С — запись');
  $properties = $form->get_properties();
  $properties['form'] = <<<'FORM'
<div class="free-course-form__fields">
  <label class="free-course-form__field">ФИО родителя [text* parent-name autocomplete:name class:free-course-form__input placeholder "Иванов Иван Иванович"]</label>
  <label class="free-course-form__field">Телефон [tel* parent-phone autocomplete:tel class:free-course-form__input class:js-phone placeholder "+7 (___) ___-__-__"]</label>
  <label class="free-course-form__field">ФИО ребёнка [text* child-name class:free-course-form__input placeholder "Иванов Алексей Иванович"]</label>
  <label class="free-course-form__field">Класс ребёнка [select* child-grade class:free-course-form__input first_as_label "Выберите класс" "7 класс" "8 класс" "9 класс" "10 класс" "11 класс"]</label>
</div>
<div class="free-course-form__consent">[acceptance course-consent]Я даю согласие на обработку персональных данных и соглашаюсь с условиями <a href="https://kamprogram.ru/privacy.pdf" target="_blank" rel="noopener noreferrer">Политики конфиденциальности и использования файлов Cookie</a>.[/acceptance]</div>
[submit "Отправить заявку"]
FORM;
  $properties['mail']['subject'] = 'Заявка: бесплатный курс 1С — [child-grade]';
  $properties['mail']['body'] = "Бесплатный курс 1С, набор до 10 октября 2026 года.\n\nРодитель: [parent-name]\nТелефон: [parent-phone]\nРебёнок: [child-name]\nКласс: [child-grade]\nСогласие: [course-consent]\n\nСтраница: [_url]";
  $properties['mail']['additional_headers'] = '';
  $properties['mail_2']['active'] = false;
  $properties['messages']['mail_sent_ok'] = 'Спасибо! Ваша заявка отправлена. Мы свяжемся с вами.';
  $properties['messages']['mail_sent_ng'] = 'Не удалось отправить заявку. Попробуйте ещё раз или позвоните +7 924 894-16-00.';
  $properties['messages']['validation_error'] = 'Проверьте, пожалуйста, заполнение полей.';
  $properties['messages']['invalid_required'] = 'Заполните это поле.';
  $properties['messages']['accept_terms'] = 'Подтвердите согласие на обработку данных.';
  $properties['additional_settings'] = 'acceptance_as_validation: on';
  $form->set_properties($properties);
  $form_id = $form->save();
  if ($form_id) {
    update_option('kamprogram_free_course_form_id', (int) $form_id, false);
  }
}, 30);

add_filter('wpcf7_validate_tel*', function ($result, $tag) {
  $form = WPCF7_ContactForm::get_current();
  if (!$form || $form->id() !== (int) get_option('kamprogram_free_course_form_id') || $tag->name !== 'parent-phone') {
    return $result;
  }
  $phone = isset($_POST['parent-phone']) && is_string($_POST['parent-phone']) ? wp_unslash($_POST['parent-phone']) : '';
  if (!preg_match('/^[78][0-9]{10}$/', preg_replace('/\D/', '', $phone))) {
    $result->invalidate($tag, 'Укажите полный номер телефона: +7 и 10 цифр.');
  }
  return $result;
}, 20, 2);
