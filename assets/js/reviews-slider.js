(() => {
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
      dragging = true;
      startX = e.clientX;
      startY = e.clientY;
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

    const onResize = () => {
      buildDots();
      apply();
    };

    window.addEventListener("resize", onResize);

    buildDots();
    apply();
  });
})();




