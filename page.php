<?php
get_header();
?>

<main>
  <div class="container">
    <?php
    while (have_posts()) {
      the_post();
      the_title('<h1>', '</h1>');
    }
    ?>
  </div>
</main>

<?php
get_footer();
?>


