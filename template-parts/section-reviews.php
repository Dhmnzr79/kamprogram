<section class="section reviews">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <span class="reviews__eyebrow">Опыт, которым делятся</span>
        <h2 class="reviews__title">Что говорят о нас родители и дети</h2>
      </div>
    </div>

    <div class="reviews__slider" data-reviews-slider>
      <div class="reviews__controls">
        <button class="reviews__arrow reviews__arrow--prev" type="button" aria-label="Предыдущий отзыв" data-reviews-prev>←</button>
        <button class="reviews__arrow reviews__arrow--next" type="button" aria-label="Следующий отзыв" data-reviews-next>→</button>
      </div>

      <div class="reviews__viewport" data-reviews-viewport>
        <div class="reviews__track" data-reviews-track>
          <?php
          $reviews = [
            [
              'name' => 'Георгий Кульков',
              'date' => '06.10.2026',
              'screenshot' => '/assets/img/review-code-future-student.jpg',
              'text' => 'Поступил в РЭУ имени Плеханова на специальность «Компьютерные системы и программирование». Сейчас дополнительно изучаю JavaScript. Скучаю по занятиям 1С и нашей группе. Желаю преподавателю и ребятам успехов и найти себя в жизни!',
            ],
            [
              'name' => 'Андрей Левченко',
              'date' => '06.10.2026',
              'screenshot' => '/assets/img/review-code-future-admission.jpg',
              'text' => 'Спасибо за чудесные уроки по программированию! За них мне дали 5 баллов за индивидуальные достижения при поступлении. Поступил на бюджет в КамГУ имени Витуса Беринга на прикладную информатику. Сумма — 176 баллов, больше всех в моём классе.',
            ],
            [
              'img' => '/assets/img/otz-1.jpg',
              'name' => 'Ольга М',
              'date' => '28 марта 2025',
              'text' => 'Провели шикарные весенние каникулы, была очень насыщенная программа, детям не давали скучать, каждый день был новый мастер класс, прогулки, выезды. Это лучшее, чем можно занять детей на каникулах. Спасибо☺️ До встречи во время летних каникул♥️',
            ],
            [
              'img' => '/assets/img/otz-2.jpg',
              'name' => 'Наталья Матвеева',
              'date' => '6 ноября 2023',
              'text' => 'Огромное спасибо за организацию занятий и развлечений для детей в период осенних каникул! Столько активных, полезных занятий👍🏻 Здесь и занятия английским языком с носителем, пальчиковая вязка, мастер-классы, библиотека и не просто поход, а интереснейшими лекциями и познавательной анимацией. Ребенок в восторге!',
            ],
            [
              'img' => '/assets/img/otz-3.jpg',
              'name' => 'Елена Петрова',
              'date' => '13 июня 2023',
              'text' => 'Спасибо за такую классную организацию досуга для наших детей! Дети под присмотром, всегда заняты делом и общением со сверстниками, а родители спокойно работают☺️',
            ],
            [
              'img' => '/assets/img/otz-4.jpg',
              'name' => 'Ирина Никитина',
              'date' => '27 октября 2022',
              'text' => 'Сын во время осенних каникул ходил в лагерь от Центра профессий. Ему очень понравилось: интересные мероприятия, активные занятия в течение дня, новые знакомства. Мы, как родители, довольны, что ребёнок был при деле и получил новые навыки и просто с интересом провел свободное время. Спасибо организаторам!',
            ],
            [
              'img' => '/assets/img/otz-5.jpg',
              'name' => 'Maya Alexandra',
              'date' => '31 марта 2023',
              'text' => 'Это были супер каникулы для моего ребёнка) Каждый день был наполнен новыми событиями и знакомствами. За 5 дней было посещение Вулканариума, библиотеки, художественного музея, мастер класс лепка из глины. Дочка с большим удовольствием и гордостью показывала что она сделала своими руками.',
            ],
          ];

          foreach ($reviews as $review_index => $review) :
            $img_src = !empty($review['img']) ? get_stylesheet_directory_uri() . $review['img'] : '';
            ?>
            <article class="reviews__slide" data-reviews-slide>
              <div class="reviews__card">
                <div class="reviews__identity"><?php if ($img_src) : ?><img class="reviews__photo" src="<?php echo esc_url($img_src); ?>" alt=""><?php else : ?><span class="reviews__avatar" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><circle cx="16" cy="11" r="5"/><path d="M6 27v-2a10 10 0 0 1 20 0v2"/></svg></span><?php endif; ?><div><div class="reviews__name"><?php echo esc_html($review['name']); ?></div>
                <?php if (!empty($review['date'])) : ?>
                  <div class="reviews__date"><?php echo esc_html($review['date']); ?></div>
                <?php endif; ?>
                <?php if (!empty($review['anonymous'])) : ?><div class="reviews__source-note">Имя изменено · по переписке</div><?php endif; ?>
                </div><span class="reviews__quote" aria-hidden="true">“</span></div>
                <div class="reviews__text" id="review-text-<?php echo (int) $review_index; ?>"><?php echo esc_html($review['text']); ?></div>
                <?php if (!empty($review['screenshot'])) : ?><a class="reviews__expand reviews__original" href="<?php echo esc_url(get_stylesheet_directory_uri() . $review['screenshot']); ?>" data-review-image aria-haspopup="dialog">Посмотреть отзыв <span aria-hidden="true">↗&#xfe0e;</span></a><?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="reviews__dots" data-reviews-dots></div>
    </div>
  </div>
</section>
<dialog class="review-image-dialog" aria-label="Скриншот отзыва" data-review-image-dialog>
  <div class="review-image-dialog__content">
    <button class="review-image-dialog__close" type="button" aria-label="Закрыть скриншот">×</button>
    <img class="review-image-dialog__image" alt="Переписка с отзывом об обучении">
  </div>
</dialog>
