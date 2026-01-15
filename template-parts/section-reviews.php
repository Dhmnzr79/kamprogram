<section class="section reviews">
  <div class="container">
    <div class="row">
      <div class="col-12">
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
              'img' => '/assets/img/face-bg-01.jpg',
              'name' => 'Анна',
              'text' => 'Ребёнок ходит с удовольствием. Занятия понятные, много практики и поддержка преподавателя.',
            ],
            [
              'img' => '/assets/img/face-bg-02.jpg',
              'name' => 'Игорь',
              'text' => 'Понравилось, что всё объясняют спокойно и по шагам. Видим прогресс уже через пару недель.',
            ],
            [
              'img' => '/assets/img/face-bg-01.jpg',
              'name' => 'Мария',
              'text' => 'Отличная атмосфера и небольшие группы. Ребёнок стал увереннее и больше интересуется IT.',
            ],
            [
              'img' => '/assets/img/face-bg-02.jpg',
              'name' => 'Дмитрий',
              'text' => 'Круто, что есть проекты. Не просто теория — ребёнок реально делает результат своими руками.',
            ],
            [
              'img' => '/assets/img/face-bg-01.jpg',
              'name' => 'Ольга',
              'text' => 'Удобный формат и понятная программа. Первый урок помог понять, что направление подходит.',
            ],
          ];

          foreach ($reviews as $review) :
            $img_src = get_stylesheet_directory_uri() . $review['img'];
            ?>
            <article class="reviews__slide" data-reviews-slide>
              <div class="reviews__card">
                <img class="reviews__photo" src="<?php echo esc_url($img_src); ?>" alt="">
                <div class="reviews__name"><?php echo esc_html($review['name']); ?></div>
                <div class="reviews__text"><?php echo esc_html($review['text']); ?></div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="reviews__dots" data-reviews-dots></div>
    </div>
  </div>
</section>


