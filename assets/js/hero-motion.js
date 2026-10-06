(() => {
  const root = document.documentElement;
  const reduced = matchMedia('(prefers-reduced-motion: reduce)');
  if (reduced.matches) return;
  root.classList.add('hero-motion');
  // If setup fails, no content remains hidden.
  const safety = setTimeout(() => root.classList.remove('hero-motion'), 2500);
  let observer;
  const finish = () => {
    clearTimeout(safety);
    observer?.disconnect();
    root.classList.remove('hero-motion');
  };
  const setup = () => {
    const hero = document.querySelector('.hero--unified');
    const card = hero?.querySelector('.hero__indexes--unified');
    if (!hero || !card) { finish(); return; }
    if ('IntersectionObserver' in window) {
      observer = new IntersectionObserver(entries => {
        if (!entries.some(entry => entry.isIntersecting)) return;
        card.classList.add('hero-card-enter');
        observer.disconnect();
      }, { threshold: 0, rootMargin: '0px 0px 24px 0px' });
      observer.observe(card);
    } else card.classList.add('hero-card-enter');
    hero.addEventListener('focusin', () => {
      hero.classList.add('hero-motion-skip');
      observer?.disconnect();
    }, { once: true });
    clearTimeout(safety);
  };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', setup, { once: true });
  else setup();
  reduced.addEventListener('change', finish, { once: true });
  addEventListener('pageshow', event => { if (event.persisted) finish(); });
})();
