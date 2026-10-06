(() => {
  const root = document.querySelector('.free-course');
  if (!root) return;

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  root.querySelectorAll('a[href="#course-signup"], a[href="#course-form"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const target = document.querySelector(link.getAttribute('href'));
      if (!target) return;
      event.preventDefault();
      target.scrollIntoView({ behavior: reducedMotion.matches ? 'instant' : 'smooth', block: 'start' });
      const input = document.querySelector('#course-form input[name="parent-name"]');
      if (input) input.focus({ preventScroll: true });
      history.replaceState(null, '', link.getAttribute('href'));
    });
  });
})();
