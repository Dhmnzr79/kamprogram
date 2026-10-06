(() => {
  const dividers = [...document.querySelectorAll('.course-lessons__divider')];
  if (!dividers.length) return;
  const reduced = matchMedia('(prefers-reduced-motion: reduce)');
  const timers = new Set();
  let observer;
  const update = () => {
    observer?.disconnect();
    timers.forEach(clearTimeout);
    timers.clear();
    if (reduced.matches || !('IntersectionObserver' in window)) {
      dividers.forEach(el => el.classList.add('is-animated'));
      return;
    }
    observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        observer.unobserve(entry.target);
        const delay = Math.min(300, Math.max(0, Number(entry.target.dataset.delay) * 1000 || 0));
        const timer = setTimeout(() => {
          entry.target.classList.add('is-animated');
          timers.delete(timer);
        }, delay);
        timers.add(timer);
      });
    }, { threshold: 0, rootMargin: '0px 0px -10% 0px' });
    dividers.filter(el => !el.classList.contains('is-animated')).forEach(el => observer.observe(el));
  };
  reduced.addEventListener('change', update);
  update();
})();
