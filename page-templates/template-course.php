<?php
/*
Template Name: Курсы
*/

get_header();
?>

<section class="hero hero--with-header-bg">
  <div class="container"></div>
</section>

<main class="page-course">
  <div class="container">
    <?php
    while (have_posts()) {
      the_post();
      the_title('<h1>', '</h1>');
    }
    ?>
  </div>

  <?php
  // Зона — Для кого этот курс
  ?>
  <section class="section course-for-whom">
    <h2>Для кого этот курс</h2>
  </section>

  <?php
  // Зона — Почему важен курс
  ?>
  <section class="section course-why">
    <h2>Почему важен курс</h2>
  </section>

  <?php
  // Зона — Что будет на занятиях
  ?>
  <section class="section course-lessons">
    <h2>Что будет на занятиях</h2>
  </section>

  <?php
  // Зона — Результаты
  ?>
  <section class="section course-results">
    <h2>Результаты</h2>
  </section>

  <?php
  // Зона — CTA
  ?>
  <section class="section course-cta">
    <h2>CTA</h2>
  </section>

  <?php
  // Зона — Плюсы нашего центра (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'center-advantages'); ?>

  <?php
  // Зона — Отзывы (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'reviews'); ?>

  <?php
  // Зона — Контакты (такое же как на главной)
  ?>
  <?php get_template_part('template-parts/section', 'contacts'); ?>
</main>

<?php
get_footer();
?>


