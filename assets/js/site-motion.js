(() => {
  const motion = matchMedia('(min-width: 1280px) and (prefers-reduced-motion: no-preference)');
  if (!('IntersectionObserver' in window) || !Element.prototype.animate) return;
  const selector = '.section h2, .home-courses-cards__card, .home-quiz__content, .course-cta__content, .center-advantages__card, .about-for-whom__card, .course-results__card, .intensivy-directions__card, [data-course-reveal]';
  const candidates = [...document.querySelectorAll(selector)].filter(el => !el.closest('.hero') && !el.parentElement.closest(selector));
  const played = new WeakSet();
  const active = new Map();
  let observer;

  const show = el => el.classList.remove('motion-pending');
  const update = () => {
    observer?.disconnect();
    active.forEach(animation => animation.cancel());
    active.clear();
    candidates.forEach(show);
    if (!motion.matches) return;
    observer = new IntersectionObserver(entries => {
      let order = 0;
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        observer.unobserve(el);
        played.add(el);
        const animation = el.animate([
          { opacity: 0, translate: '0 28px' },
          { opacity: 1, translate: '0 0' }
        ], { duration: 760, delay: Math.min(order++ * 80, 240), easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'both' });
        active.set(el, animation);
        const finish = () => {
          show(el);
          active.delete(el);
          animation.onfinish = animation.oncancel = null;
          animation.cancel();
        };
        animation.onfinish = animation.oncancel = finish;
      });
    }, { threshold: 0, rootMargin: '0px 0px 60px 0px' });
    candidates.forEach(el => {
      if (played.has(el)) return;
      const rect = el.getBoundingClientRect();
      // Prepare offscreen blocks before they enter, never hide visible content.
      if (rect.top <= innerHeight + 60) played.add(el);
      else {
        el.classList.add('motion-pending');
        observer.observe(el);
      }
    });
  };
  motion.addEventListener('change', update);
  // Keyboard focus must reveal a prepared block immediately.
  document.addEventListener('focusin', event => {
    const el = event.target.closest('.motion-pending');
    if (!el) return;
    observer?.unobserve(el);
    played.add(el);
    active.get(el)?.cancel();
    show(el);
  });
  addEventListener('pageshow', event => { if (event.persisted) update(); });
  update();
})();
