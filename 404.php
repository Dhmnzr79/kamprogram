<?php
get_header();
?>

<main>
  <div class="container">
    <div class="section page-404">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/404.svg'); ?>" alt="404" class="page-404__image">
      
      <h1>Страница не найдена</h1>
      <p>К сожалению, запрашиваемая страница не существует. Возможно, она была удалена или перемещена.</p>
      
      <p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
          Вернуться на главную
        </a>
      </p>

      <?php
      $courses = get_posts([
        'post_type' => 'course',
        'post_status' => 'publish',
        'numberposts' => 2,
        'orderby' => 'menu_order',
        'order' => 'ASC',
      ]);

      if (!empty($courses)) :
      ?>
        <div class="page-404__courses">
          <?php foreach ($courses as $course) : ?>
            <a href="<?php echo esc_url(get_permalink($course)); ?>" class="page-404__course-link">
              <?php echo esc_html(get_the_title($course)); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php
get_footer();
?>
