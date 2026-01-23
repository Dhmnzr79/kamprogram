<?php
get_header();
?>

<main class="page-thanks">
  <div class="page-thanks__container">
    <div class="page-thanks__content">
      <h1 class="page-thanks__title">Спасибо за заявку!</h1>
      <p class="page-thanks__text">Мы свяжемся с вами в ближайшее время</p>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary page-thanks__button">
        Вернуться на главную
        <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
</main>

<?php
get_footer();
?>
