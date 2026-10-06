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
            $img_src = get_stylesheet_directory_uri() . $review['img'];
            ?>
            <article class="reviews__slide" data-reviews-slide>
              <div class="reviews__card">
                <div class="reviews__identity"><img class="reviews__photo" src="<?php echo esc_url($img_src); ?>" alt=""><div><div class="reviews__name"><?php echo esc_html($review['name']); ?></div>
                <?php if (!empty($review['date'])) : ?>
                  <div class="reviews__date"><?php echo esc_html($review['date']); ?></div>
                <?php endif; ?>
                </div><span class="reviews__quote" aria-hidden="true">“</span></div>
                <div class="reviews__text" id="review-text-<?php echo (int) $review_index; ?>"><?php echo esc_html($review['text']); ?></div>
                <button class="reviews__expand" type="button" data-review-expand aria-expanded="false" aria-controls="review-text-<?php echo (int) $review_index; ?>" hidden>Читать полностью <span aria-hidden="true">↗&#xfe0e;</span></button>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="reviews__dots" data-reviews-dots></div>
    </div>
  </div>
</section>
