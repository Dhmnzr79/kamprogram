  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-3">
          <div class="site-footer__brand">
            <a class="site-footer__logo" href="<?php echo esc_url(home_url('/')); ?>">
              <img
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/svg/logo.svg'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
              >
            </a>
            <div class="site-footer__tagline">Центр профессий будущего на Камчатке</div>
          </div>
        </div>

        <div class="col-6">
          <div class="site-footer__courses">
            <h3 class="site-footer__courses-title">Наши курсы</h3>

            <div class="row site-footer__courses-grid">
              <div class="col-6">
                <nav class="site-footer__courses-list">
                  <a class="site-footer__courses-link" href="#">Робототехника LEGO</a>
                  <a class="site-footer__courses-link" href="#">Мастерская Scratch</a>
                  <a class="site-footer__courses-link" href="#">Программирование на Python</a>
                  <a class="site-footer__courses-link" href="#">Системное администрирование</a>
                  <a class="site-footer__courses-link" href="#">Компьютерная графика</a>
                </nav>
              </div>

              <div class="col-6">
                <nav class="site-footer__courses-list">
                  <a class="site-footer__courses-link" href="#">Мультипликация</a>
                  <a class="site-footer__courses-link" href="#">HTML и JavaScript</a>
                  <a class="site-footer__courses-link" href="#">Олимпиадная математика</a>
                  <a class="site-footer__courses-link" href="#">Каллиграфия и красивый почерк</a>
                  <a class="site-footer__courses-link" href="#">Черчение</a>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <div class="col-3">
          <div class="site-footer__contacts">
            <div class="site-footer__address">г. Петропавловск-Камчатский, ул. Максутова, д.34</div>
            <a class="site-footer__phone" href="tel:+79248941600">+7 924 894-16-00</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>


