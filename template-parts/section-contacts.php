<section class="section contacts">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <h2 class="contacts__title">Контакты</h2>
        <div class="contacts__info">
          <div class="contacts__address contacts__item"><?php echo kamprogram_icon('pin'); ?><span>г. Петропавловск-Камчатский,<br>ул. Максутова, д.34</span></div>
          <a class="contacts__email contacts__item" href="mailto:info@kamprogram.ru"><?php echo kamprogram_icon('mail'); ?><span>info@kamprogram.ru</span></a>
          <a class="contacts__phone contacts__item" href="tel:+79248941600"><?php echo kamprogram_icon('phone'); ?><span>+7 924 894-16-00</span></a>
        </div>
        <?php if (!empty($args['signup_url'])) : ?>
          <a class="btn btn--primary contacts__cta" href="<?php echo esc_url($args['signup_url']); ?>">
          Записаться на курс
        <?php else : ?>
          <button class="btn btn--primary contacts__cta" type="button" data-modal="signup">
          Заказать обратный звонок
        <?php endif; ?>
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        <?php if (!empty($args['signup_url'])) : ?>
          </a>
        <?php else : ?>
          </button>
        <?php endif; ?>
      </div>

      <div class="col-6">
        <div class="contacts__map">
          <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A39e1e4a37db6c8620c08a28ca6df7df2b5be9e8b139ce5bbb9cf4e7ec4e83745&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=false"></script>
        </div>
      </div>
    </div>
  </div>
</section>
