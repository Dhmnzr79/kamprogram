<?php
get_header();
?>

<main class="page-about">
  <div class="container">
    <?php
    while (have_posts()) {
      the_post();
      the_title('<h1>', '</h1>');
    }
    ?>
  </div>

  <?php
  // Зона — О нас
  ?>
  <section class="section about-us">
    <h2>О нас</h2>
  </section>

  <?php
  // Зона — Для кого курсы
  ?>
  <section class="section about-for-whom">
    <h2>Для кого курсы</h2>
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


