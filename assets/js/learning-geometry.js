(() => {
  const shapes = {
    'solid-square': '<rect x="17" y="17" width="66" height="66" rx="12" transform="rotate(-18 50 50)" fill="currentColor" stroke="none"/>',
    diamond: '<rect x="22" y="22" width="56" height="56" rx="7" transform="rotate(34 50 50)" stroke-width="12"/>',
    triangle: '<path d="M22 14Q18 7 13 16L6 82Q5 91 14 88L88 55Q96 50 87 45Z" fill="currentColor" stroke="none"/>',
    ring: '<circle cx="50" cy="50" r="33" stroke-width="16"/>',
    'soft-square': '<rect x="18" y="18" width="64" height="64" rx="12" transform="rotate(20 50 50)" fill="currentColor" stroke="none"/>',
    'soft-disc': '<circle cx="50" cy="50" r="34" fill="currentColor" stroke="none"/>'
  };
  const placements = [
    ['.page-home .home-courses-cards', 'diamond'],
    ['.page-home .home-courses-cards', 'soft-square'],
    ['.page-home .center-advantages', 'triangle'],
    ['.page-home .reviews', 'ring'],
    ['.page-home .reviews', 'soft-disc'],
    ['.free-course-benefits', 'ring'],
    ['.free-course-benefits', 'soft-disc'],
    ['.free-course-place', 'diamond'],
    ['.free-course-steps', 'triangle'],
    ['.free-course-steps', 'soft-square'],
    ['.page-course .course-for-whom', 'triangle'],
    ['.page-course .course-why__media', 'solid-square'],
    ['.page-course .course-lessons', 'ring'],
    ['.page-course .course-lessons', 'soft-disc'],
    ['.page-course .course-results', 'diamond'],
    ['.page-course .course-results', 'soft-square'],
    ['.page-about .about-for-whom', 'diamond'],
    ['.page-about .about-for-whom', 'soft-disc'],
    ['.page-about .center-advantages', 'ring'],
    ['.page-about .reviews', 'triangle'],
    ['.page-about .reviews', 'soft-square']
  ];
  const items = [];
  for (const [selector, shape] of placements) {
    document.querySelectorAll(selector).forEach(host => {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', `learning-geometry learning-geometry--${shape}`);
      svg.setAttribute('viewBox', '0 0 100 100');
      svg.setAttribute('aria-hidden', 'true');
      svg.setAttribute('focusable', 'false');
      svg.setAttribute('fill', 'none');
      svg.setAttribute('stroke', 'currentColor');
      svg.setAttribute('stroke-width', '2');
      svg.setAttribute('stroke-linecap', 'round');
      svg.setAttribute('stroke-linejoin', 'round');
      svg.innerHTML = shapes[shape];
      host.classList.add('learning-geometry-host');
      host.append(svg);
      items.push({ host, svg, offset: null, speed: shape.startsWith('soft') ? .12 : .2 });
    });
  }
  const media = matchMedia('(min-width: 1280px) and (prefers-reduced-motion: no-preference)');
  let frame = 0;
  const paint = () => {
    frame = 0;
    let moving = false;
    for (const item of items) {
      const { host, svg, speed } = item;
      const top = host.getBoundingClientRect().top;
      const target = media.matches ? Math.max(-40, Math.min(64, (innerHeight * .55 - top) * speed)) : 0;
      if (item.offset === null || !media.matches) item.offset = target;
      const delta = target - item.offset;
      item.offset = Math.abs(delta) < .1 ? target : item.offset + delta * .14;
      if (Math.abs(delta) >= .1) moving = true;
      svg.style.transform = `translate3d(0, ${item.offset.toFixed(2)}px, 0)`;
    }
    if (moving) schedule();
  };
  const schedule = () => { if (!frame) frame = requestAnimationFrame(paint); };
  const configure = () => {
    removeEventListener('scroll', schedule);
    if (media.matches) addEventListener('scroll', schedule, { passive: true });
    schedule();
  };
  media.addEventListener('change', configure);
  addEventListener('resize', schedule, { passive: true });
  configure();
})();
