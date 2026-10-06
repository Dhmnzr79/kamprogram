(() => {
  const header = document.querySelector(".site-header");
  const burger = document.querySelector("[data-header-burger]");
  const drawer = document.querySelector("[data-header-drawer]");
  const closeBtn = document.querySelector("[data-header-close]");
  let closeTimer;

  const setHeaderOffsetVar = () => {
    if (!header) return;
    const h = header.getBoundingClientRect().height;
    document.documentElement.style.setProperty("--site-header-h", `${Math.round(h)}px`);
  };

  const lockScroll = (locked) => {
    document.body.classList.toggle("is-drawer-open", locked);
  };

  const openDrawer = () => {
    if (!drawer || !burger) return;
    clearTimeout(closeTimer);
    drawer.hidden = false;
    drawer.getBoundingClientRect();
    requestAnimationFrame(() => {
      drawer.classList.add("is-open");
      closeBtn?.focus({ preventScroll: true });
    });
    burger.setAttribute("aria-expanded", "true");
    lockScroll(true);
  };

  const closeDrawer = () => {
    if (!drawer || !burger) return;
    const wasOpen = burger.getAttribute('aria-expanded') === 'true';
    drawer.classList.remove("is-open");
    burger.setAttribute("aria-expanded", "false");
    lockScroll(false);
    clearTimeout(closeTimer);
    closeTimer = window.setTimeout(() => {
      drawer.hidden = true;
    }, 200);
    if (wasOpen && drawer.contains(document.activeElement)) burger.focus({ preventScroll: true });
  };

  burger?.addEventListener("click", (e) => {
    e.preventDefault();
    const isOpen = burger.getAttribute("aria-expanded") === "true";
    if (isOpen) closeDrawer();
    else openDrawer();
  });

  closeBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    closeDrawer();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === 'Tab' && burger?.getAttribute('aria-expanded') === 'true') {
      const items = [...drawer.querySelectorAll('a[href], button')].filter(el => el.getClientRects().length);
      const first = items[0];
      const last = items[items.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last?.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first?.focus(); }
    }
    if (e.key !== "Escape") return;
    closeDrawer();
    document.querySelectorAll('.menu-item-has-children > a[aria-expanded="true"]').forEach(link => {
      const submenu = link.parentElement.querySelector('ul.sub-menu');
      if (submenu?.contains(document.activeElement)) link.focus();
      link.setAttribute('aria-expanded', 'false');
      if (submenu) submenu.hidden = true;
    });
  });

  // Submenu toggles (no hover): work for both desktop and drawer.
  document.addEventListener("click", (e) => {
    const target = e.target;
    if (!(target instanceof Element)) return;

    const link = target.closest("a");
    if (!link) return;

    const li = link.closest(".menu-item-has-children");
    if (!li) return;

    const submenu = li.querySelector("ul.sub-menu");
    if (!submenu) return;

    // Проверяем, является ли ссылка родительской (прямой дочерней ссылкой li)
    // или ссылкой внутри подменю
    const isParentLink = link.parentElement === li;
    
    // Если это ссылка внутри подменю - разрешаем переход
    if (!isParentLink) return;

    e.preventDefault();

    const expanded = link.getAttribute("aria-expanded") === "true";
    link.setAttribute("aria-expanded", expanded ? "false" : "true");
    submenu.hidden = expanded;
  });

  // Close submenu when clicking outside
  document.addEventListener("click", (e) => {
    const target = e.target;
    if (!(target instanceof Element)) return;

    const clickedInsideMenu = target.closest(".menu-item-has-children");
    if (clickedInsideMenu) return;

    // Close all open submenus
    document.querySelectorAll(".menu-item-has-children > a[aria-expanded='true']").forEach((link) => {
      link.setAttribute("aria-expanded", "false");
      const submenu = link.closest(".menu-item-has-children")?.querySelector("ul.sub-menu");
      if (submenu) {
        submenu.hidden = true;
      }
    });
  });

  // Init: hide all submenus by default and set aria-expanded.
  const initSubmenus = () => {
    document.querySelectorAll(".menu-item-has-children > a").forEach((a) => {
      a.setAttribute("aria-expanded", "false");
    });
    document.querySelectorAll("ul.sub-menu").forEach((ul) => {
      ul.hidden = true;
    });
  };

  initSubmenus();
  document.addEventListener('click', event => {
    if (burger?.getAttribute('aria-expanded') === 'true' && !drawer.contains(event.target) && !burger.contains(event.target)) closeDrawer();
  });
  setHeaderOffsetVar();
  const updateScrollState = () => header?.classList.toggle('is-scrolled', window.scrollY > 12);
  updateScrollState();
  window.addEventListener('scroll', updateScrollState, { passive: true });
  window.addEventListener("resize", () => {
    setHeaderOffsetVar();
    // close drawer on resize to desktop
    if (window.innerWidth >= 1280) {
      closeDrawer();
    }
  });
})();
