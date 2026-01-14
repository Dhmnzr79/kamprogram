<?php
get_header();
?>

<main class="page-contacts">
  <div class="container">
    <?php
    while (have_posts()) {
      the_post();
      the_title('<h1>', '</h1>');
    }
    ?>
  </div>

  <?php
  // Зона — Контакты (уникальные)
  ?>
  <section class="section contacts-unique">
    <h2>Контакты</h2>
  </section>
</main>

<?php
get_footer();
?>


