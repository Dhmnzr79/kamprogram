(() => {
  const wrap = document.querySelector('.course-why__media-wrap');
  const image = document.querySelector('.course-why__media-img');
  if (!wrap || !image) return;
  const motion = matchMedia('(min-width: 1280px) and (prefers-reduced-motion: no-preference)');
  let frame = 0;
  const update = () => {
    frame = 0;
    if (!motion.matches) {
      image.style.transform = '';
      return;
    }
    const rect = wrap.getBoundingClientRect();
    const progress = Math.max(0, Math.min(1, 1 - rect.bottom / (innerHeight + rect.height)));
    image.style.transform = 'translateY(' + (-16 * progress) + '%)';
  };
  const schedule = () => { if (!frame) frame = requestAnimationFrame(update); };
  addEventListener('scroll', schedule, { passive: true });
  addEventListener('resize', schedule);
  motion.addEventListener('change', schedule);
  update();
})();
