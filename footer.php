  <footer class="site-footer site-footer--refreshed">
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
          <p class="site-footer__note">Помогаем найти интерес<br>и превратить его в умение.</p>
          <a class="site-footer__about" href="<?php echo esc_url(home_url('/o-nas/')); ?>">О нашем центре <svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 16 16 4M4 4h12v12"/></svg></a>
        </div>

        <div class="col-6">
          <div class="site-footer__courses">
            <h3 class="site-footer__courses-title">Наши курсы</h3>

            <div class="row site-footer__courses-grid">
              <div class="col-6">
                <nav class="site-footer__courses-list">
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/robototekhnika-lego/')); ?>">Робототехника LEGO</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/masterskaya-scratch/')); ?>">Мастерская Scratch</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/programmirovanie-na-python/')); ?>">Программирование на Python</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/sistemnoe-administrirovanie/')); ?>">Системное администрирование</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/kompyuternaya-grafika/')); ?>">Компьютерная графика</a>
                </nav>
              </div>

              <div class="col-6">
                <nav class="site-footer__courses-list">
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/multiplikaciya/')); ?>">Мультипликация</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/html-i-javascript/')); ?>">HTML и JavaScript</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/olimpiadnaya-matematika/')); ?>">Олимпиадная математика</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/kalligrafiya-i-krasivyj-pocherk/')); ?>">Каллиграфия и красивый почерк</a>
                  <a class="site-footer__courses-link" href="<?php echo esc_url(home_url('/course/cherchenie/')); ?>">Черчение</a>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <div class="col-3">
          <div class="site-footer__contacts">
            <h3 class="site-footer__courses-title">Будем на связи</h3>
            <div class="site-footer__address">Петропавловск-Камчатский<br>ул. Максутова, д. 34</div>
            <a class="site-footer__phone" href="tel:+79248941600">+7 924 894-16-00</a>
            <a class="site-footer__email" href="mailto:info@kamprogram.ru">info@kamprogram.ru</a>
          </div>
        </div>
      </div>
    </div>

    <div class="site-footer__bottom">
      <div class="container site-footer__bottom-inner">
        <span class="site-footer__copyright">© <?php echo esc_html(wp_date('Y')); ?> Центр профессий будущего на Камчатке</span>
        <a
          class="site-footer__privacy"
          href="<?php echo esc_url('https://kamprogram.ru/privacy.pdf'); ?>"
          target="_blank"
          rel="noopener noreferrer"
        >Политика конфиденциальности</a>
      </div>
    </div>
  </footer>

  <div class="modal" id="modal-signup" role="dialog" aria-modal="true" aria-labelledby="signup-title" aria-hidden="true">
    <div class="modal__overlay" data-modal-close></div>
    <div class="modal__content signup-dialog" tabindex="-1">
      <button class="modal__close" type="button" data-modal-close aria-label="Закрыть"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
      <aside class="signup-dialog__story">
        <span class="signup-dialog__eyebrow">Начинается с интереса</span>
        <h2>Большое будущее.<br>Первый шаг —<br>сегодня.</h2>
        <div class="signup-dialog__art" aria-hidden="true"><span>{</span><i><svg width="54" height="54" viewBox="0 0 54 54" fill="none"><path d="M13 41 41 13M13 13h28v28" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>}</span></div>
        <p>Поможем выбрать направление и ответим на ваши вопросы.</p>
        <span class="signup-dialog__signature">Центр профессий будущего / Камчатка</span>
      </aside>
      <div class="signup-dialog__form-panel">
        <span class="signup-dialog__eyebrow">Давайте знакомиться</span>
        <h2 class="modal__title" id="signup-title">Оставьте заявку</h2>
        <div class="modal__subtitle">И мы свяжемся с вами в ближайшее время</div>
        <div class="modal__form">
          <?php echo do_shortcode('[contact-form-7 id="6c52f0a" title="Основная форма"]'); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modal-quiz" role="dialog" aria-modal="true" aria-labelledby="quiz-dialog-title" aria-hidden="true">
    <div class="modal__overlay" data-modal-close></div>
    <div class="modal__content modal-quiz" tabindex="-1">
      <button class="modal__close" type="button" data-modal-close aria-label="Закрыть"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
      <div class="quiz-progress"><div class="quiz-progress__caption"><span id="quiz-dialog-title">Найдём свой курс</span><span data-quiz-progress-label>01 / 04</span></div><progress class="quiz-progress__bar" data-quiz-progress max="4" value="1" aria-label="Прогресс подбора курса"></progress></div>
      
      <!-- Шаг 1: Возраст -->
      <div class="quiz-step" data-step="1">
        <h2 class="modal-quiz__title">Сколько лет вашему ребенку?</h2>
        <div class="modal-quiz__subtitle">Это поможет нам сразу отфильтровать подходящие по возрасту варианты.</div>
        <div class="quiz-options">
          <label class="quiz-option">
            <input type="radio" name="age" value="5-7" data-quiz-answer>
            <span class="quiz-option__text">5–7 лет</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="age" value="8-11" data-quiz-answer>
            <span class="quiz-option__text">8–11 лет</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="age" value="12-14" data-quiz-answer>
            <span class="quiz-option__text">12–14 лет</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="age" value="15-18" data-quiz-answer>
            <span class="quiz-option__text">15–18 лет</span>
          </label>
        </div>
        <div class="quiz-actions">
          <button class="btn btn--primary quiz-btn-next" type="button" disabled>Далее</button>
        </div>
      </div>

      <!-- Шаг 2: Интересы -->
      <div class="quiz-step" data-step="2" hidden>
        <h2 class="modal-quiz__title">Что больше всего увлекает вашего ребенка в свободное время?</h2>
        <div class="quiz-options">
          <label class="quiz-option">
            <input type="radio" name="interests" value="constructors" data-quiz-answer>
            <span class="quiz-option__text">Конструкторы, LEGO, механизмы — любит разбирать, собирать, понимать, как все устроено.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="interests" value="tech" data-quiz-answer>
            <span class="quiz-option__text">Компьютерные игры и технологии — интересуется, «как это сделано», может долго сидеть за ПК, любит гаджеты.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="interests" value="creative" data-quiz-answer>
            <span class="quiz-option__text">Рисование, творчество, визуальные образы — рисует, создает истории, обращает внимание на дизайн, любит фото и видео.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="interests" value="logic" data-quiz-answer>
            <span class="quiz-option__text">Логика, головоломки, точные науки — любит математику, шахматы, задачи на мышление, все раскладывает по полочкам.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="interests" value="perfection" data-quiz-answer>
            <span class="quiz-option__text">Аккуратность, красота, детали — стремится к идеалу, любит, когда все красиво оформлено, внимателен к мелочам.</span>
          </label>
        </div>
        <div class="quiz-actions">
          <button class="btn btn--secondary quiz-btn-back" type="button">Назад</button>
          <button class="btn btn--primary quiz-btn-next" type="button" disabled>Далее</button>
        </div>
      </div>

      <!-- Шаг 3: Цель -->
      <div class="quiz-step" data-step="3" hidden>
        <h2 class="modal-quiz__title">Какой главный результат вы ждете от занятий?</h2>
        <div class="quiz-options">
          <label class="quiz-option">
            <input type="radio" name="goal" value="logic" data-quiz-answer>
            <span class="quiz-option__text">Развить логику и техническое мышление — чтобы ребенок учился решать практические задачи и понимать мир технологий.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="goal" value="career" data-quiz-answer>
            <span class="quiz-option__text">Получить реальный навык для будущей профессии — чтобы занятия стали первым шагом в карьере (IT, дизайн, инженерия).</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="goal" value="creative" data-quiz-answer>
            <span class="quiz-option__text">Раскрыть творческий потенциал — чтобы ребенок научился создавать что-то свое: мультфильмы, рисунки, проекты.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="goal" value="performance" data-quiz-answer>
            <span class="quiz-option__text">Улучшить успеваемость и усидчивость — чтобы занятия помогли в школе, развили внимание и дисциплину.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="goal" value="olympiad" data-quiz-answer>
            <span class="quiz-option__text">Подготовиться к поступлению в вуз или олимпиадам — углубленные знания для будущих инженеров, программистов и математиков.</span>
          </label>
        </div>
        <div class="quiz-actions">
          <button class="btn btn--secondary quiz-btn-back" type="button">Назад</button>
          <button class="btn btn--primary quiz-btn-next" type="button" disabled>Далее</button>
        </div>
      </div>

      <!-- Шаг 4: Стиль мышления -->
      <div class="quiz-step" data-step="4" hidden>
        <h2 class="modal-quiz__title">Как ребенок обычно решает сложные задачи?</h2>
        <div class="quiz-options">
          <label class="quiz-option">
            <input type="radio" name="thinking" value="hands" data-quiz-answer>
            <span class="quiz-option__text">Действует руками — пробует, конструирует, экспериментирует.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="thinking" value="research" data-quiz-answer>
            <span class="quiz-option__text">Ищет информацию, копает в настройках — не боится технологий, смотрит обучающие видео, пробует разные варианты.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="thinking" value="creative" data-quiz-answer>
            <span class="quiz-option__text">Подходит творчески — ищет нестандартное решение, думает образами, старается сделать красиво.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="thinking" value="plan" data-quiz-answer>
            <span class="quiz-option__text">Действует по плану — анализирует, строит алгоритмы, следует инструкциям.</span>
          </label>
          <label class="quiz-option">
            <input type="radio" name="thinking" value="perfect" data-quiz-answer>
            <span class="quiz-option__text">Стремится к идеалу — перепроверяет, старается сделать всё тщательно и без ошибок.</span>
          </label>
        </div>
        <div class="quiz-actions">
          <button class="btn btn--secondary quiz-btn-back" type="button">Назад</button>
          <button class="btn btn--primary quiz-btn-next" type="button" disabled>Узнать рекомендацию</button>
        </div>
      </div>

      <!-- Шаг 5: Результат + Форма -->
      <div class="quiz-step quiz-step--result" data-step="5" hidden>
        <h2 class="modal-quiz__title">Рекомендации для вашего ребенка</h2>
        <div class="quiz-results" id="quiz-results"></div>
        <div class="modal-quiz__cta-text">Рекомендация — это лишь отправная точка. Увидеть интерес в глазах ребёнка — лучше любых тестов!<br>Запишитесь на бесплатный пробный урок на любом курсе и дайте ему попробовать себя в деле.</div>
        <div class="modal-quiz__form">
          <?php echo do_shortcode('[contact-form-7 id="6c52f0a" title="Основная форма"]'); ?>
        </div>
      </div>
    </div>
  </div>

  <?php
  $privacy_pdf = 'https://kamprogram.ru/privacy.pdf';
  ?>
  <div
    class="cookie-banner"
    id="cookie-banner"
    role="dialog"
    aria-label="<?php echo esc_attr('Уведомление об использовании cookie'); ?>"
    aria-live="polite"
    hidden
  >
    <div class="container cookie-banner__inner">
      <p class="cookie-banner__text">
        Мы используем файлы cookie и схожие технологии для работы сайта и улучшения сервиса.
        Нажимая «Принять», вы даёте согласие на обработку данных в соответствии с
        <a
          class="cookie-banner__link"
          href="<?php echo esc_url($privacy_pdf); ?>"
          target="_blank"
          rel="noopener noreferrer"
        >Политикой конфиденциальности</a>.
      </p>
      <button class="btn btn--primary cookie-banner__accept" type="button" id="cookie-banner-accept">
        Принять
      </button>
    </div>
  </div>

  <?php wp_footer(); ?>
</body>
</html>
