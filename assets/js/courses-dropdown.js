(() => {
  const toggles = document.querySelectorAll("[data-courses-toggle]");

  const closeAll = () => {
    toggles.forEach((toggle) => {
      const item = toggle.closest(".site-nav__courses");
      const menu = item?.querySelector("[data-courses-menu]");
      if (!menu) return;
      toggle.setAttribute("aria-expanded", "false");
      menu.hidden = true;
    });
  };

  toggles.forEach((toggle) => {
    const item = toggle.closest(".site-nav__courses");
    const menu = item?.querySelector("[data-courses-menu]");
    if (!menu) return;

    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      const isOpen = toggle.getAttribute("aria-expanded") === "true";
      closeAll();
      toggle.setAttribute("aria-expanded", isOpen ? "false" : "true");
      menu.hidden = isOpen;
    });
  });

  document.addEventListener("click", (e) => {
    const target = e.target;
    if (!(target instanceof Element)) return;
    if (target.closest(".site-nav__courses")) return;
    closeAll();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeAll();
  });
})();




