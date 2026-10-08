(() => {
  const imageDialog = document.querySelector('[data-review-image-dialog]');
  if (imageDialog && typeof imageDialog.showModal === 'function') {
    let previousOverflow = '';
    document.querySelectorAll('[data-review-image]').forEach(link => {
      link.addEventListener('click', event => {
        event.preventDefault();
        imageDialog.querySelector('img').src = link.href;
        previousOverflow = document.documentElement.style.overflow;
        imageDialog.showModal();
        document.documentElement.style.overflow = 'hidden';
      });
    });
    imageDialog.querySelector('button').addEventListener('click', () => imageDialog.close());
    imageDialog.addEventListener('click', event => {
      if (event.target === imageDialog) imageDialog.close();
    });
    imageDialog.addEventListener('close', () => {
      document.documentElement.style.overflow = previousOverflow;
      imageDialog.querySelector('img').removeAttribute('src');
    });
  }
  const sliders = document.querySelectorAll("[data-reviews-slider]");

  const getVisibleCount = () => {
    const w = window.innerWidth;
    if (w >= 1280) return 3;
    if (w >= 768) return 2;
    return 1;
  };

  const clamp = (n, min, max) => Math.max(min, Math.min(max, n));

  sliders.forEach((root) => {
    const viewport = root.querySelector("[data-reviews-viewport]");
    const track = root.querySelector("[data-reviews-track]");
    const slides = Array.from(root.querySelectorAll("[data-reviews-slide]"));
    const prevBtn = root.querySelector("[data-reviews-prev]");
    const nextBtn = root.querySelector("[data-reviews-next]");
    const dotsRoot = root.querySelector("[data-reviews-dots]");

    if (!viewport || !track || slides.length === 0) return;

    let index = 0;
    let startX = 0;
    let startY = 0;
    let dragging = false;
    viewport.tabIndex = 0;
    viewport.setAttribute('role', 'region');
    viewport.setAttribute('aria-label', 'Отзывы. Используйте стрелки влево и вправо для просмотра.');

    const updateExcerpts = () => {
      slides.forEach(slide => {
        const card = slide.querySelector('.reviews__card');
        const copy = slide.querySelector('.reviews__text');
        const button = slide.querySelector('[data-review-expand]');
        if (!card || !copy || !button) return;
        const long = copy.scrollHeight > parseFloat(getComputedStyle(copy).lineHeight) * 5 + 2;
        card.classList.toggle('is-collapsible', long);
        button.hidden = !long;
      });
    };

    root.querySelectorAll('[data-review-expand]').forEach(button => {
      button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') !== 'true';
        button.closest('.reviews__card').classList.toggle('is-expanded', expanded);
        button.setAttribute('aria-expanded', String(expanded));
        button.replaceChildren(document.createTextNode(expanded ? 'Свернуть отзыв ' : 'Читать полностью '));
        const arrow = document.createElement('span');
        arrow.setAttribute('aria-hidden', 'true');
        arrow.textContent = expanded ? '\u2199\uFE0E' : '\u2197\uFE0E';
        button.appendChild(arrow);
      });
    });

    const getStep = () => {
      const first = slides[0];
      const rect = first.getBoundingClientRect();
      const style = window.getComputedStyle(track);
      const gap = parseFloat(style.columnGap || style.gap || "0") || 0;
      return rect.width + gap;
    };

    const getMaxIndex = () => {
      const visible = getVisibleCount();
      return Math.max(0, slides.length - visible);
    };

    const apply = () => {
      index = clamp(index, 0, getMaxIndex());
      const step = getStep();
      track.style.transform = `translateX(${-index * step}px)`;

      if (prevBtn) prevBtn.disabled = index === 0;
      if (nextBtn) nextBtn.disabled = index === getMaxIndex();
      slides.forEach((slide, i) => {
        const outside = i < index || i >= index + getVisibleCount();
        slide.inert = outside;
        slide.setAttribute('aria-hidden', String(outside));
      });

      const dots = Array.from(dotsRoot?.querySelectorAll("button") || []);
      dots.forEach((btn, i) => {
        btn.setAttribute("aria-current", i === index ? "true" : "false");
      });
    };

    const buildDots = () => {
      if (!dotsRoot) return;
      dotsRoot.innerHTML = "";
      for (let i = 0; i <= getMaxIndex(); i++) {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.setAttribute("aria-label", `Перейти к отзыву ${i + 1}`);
        btn.addEventListener("click", () => {
          index = i;
          apply();
        });
        dotsRoot.appendChild(btn);
      }
    };

    prevBtn?.addEventListener("click", () => {
      index -= 1;
      apply();
    });

    nextBtn?.addEventListener("click", () => {
      index += 1;
      apply();
    });

    viewport.addEventListener("pointerdown", (e) => {
      if (e.button !== 0 || e.target.closest('button, a')) return;
      dragging = true;
      startX = e.clientX;
      startY = e.clientY;
      viewport.setPointerCapture(e.pointerId);
    });

    viewport.addEventListener("pointerup", (e) => {
      if (!dragging) return;
      dragging = false;

      const dx = e.clientX - startX;
      const dy = e.clientY - startY;
      if (Math.abs(dx) < 30 || Math.abs(dx) < Math.abs(dy)) return;

      if (dx < 0) index += 1;
      if (dx > 0) index -= 1;
      apply();
    });

    viewport.addEventListener('pointercancel', () => { dragging = false; });
    viewport.addEventListener('keydown', (event) => {
      if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
      event.preventDefault();
      index += event.key === 'ArrowRight' ? 1 : -1;
      apply();
    });

    const onResize = () => {
      buildDots();
      apply();
      updateExcerpts();
    };

    window.addEventListener("resize", onResize);

    buildDots();
    apply();
    updateExcerpts();
    document.fonts?.ready.then(updateExcerpts);
  });
})();






