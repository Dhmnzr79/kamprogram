(function () {
  const init = () => {
    const dividers = document.querySelectorAll('.course-lessons__divider');
    
    if (dividers.length === 0) {
      return;
    }

    const observerOptions = {
      root: null,
      rootMargin: '-20% 0px -20% 0px',
      threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !entry.target.classList.contains('is-animated')) {
          const delay = parseFloat(entry.target.dataset.delay) || 0;
          
          setTimeout(() => {
            entry.target.classList.add('is-animated');
          }, delay * 1000);
        }
      });
    }, observerOptions);

    dividers.forEach((divider) => {
      observer.observe(divider);
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
