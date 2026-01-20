(function () {
  const init = () => {
    const mediaWrap = document.querySelector('.course-why__media-wrap');
    const mediaImg = document.querySelector('.course-why__media-img');
    
    if (!mediaWrap || !mediaImg) {
      return;
    }

    // Рассчитываем максимальное смещение (20% от высоты картинки)
    // Картинка 120% высоты, обертка 100%, значит можно сдвинуть на 20%
    const maxOffset = 0.20;

    const updateParallax = () => {
      const rect = mediaWrap.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      
      // Вычисляем прогресс видимости элемента (0 - когда элемент внизу экрана, 1 - когда вверху)
      const elementTop = rect.top;
      const elementHeight = rect.height;
      const elementBottom = elementTop + elementHeight;
      
      // Когда элемент виден на экране
      if (elementBottom > 0 && elementTop < windowHeight) {
        // Вычисляем прогресс от 0 до 1
        // 0 = элемент только появился снизу, 1 = элемент полностью проскроллен вверх
        const scrollProgress = 1 - (elementBottom / (windowHeight + elementHeight));
        
        // Ограничиваем от 0 до 1
        const clampedProgress = Math.max(0, Math.min(1, scrollProgress));
        
        // Применяем смещение (0% в начале, -16.67% в конце)
        const translateY = -maxOffset * clampedProgress * 100;
        mediaImg.style.transform = `translateY(${translateY}%)`;
      }
    };

    // Обновляем при скролле
    let ticking = false;
    const onScroll = () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          updateParallax();
          ticking = false;
        });
        ticking = true;
      }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    
    // Инициализируем начальное состояние
    updateParallax();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
