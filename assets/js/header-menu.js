(() => {
  const header = document.querySelector(".site-header");
  const burger = document.querySelector("[data-header-burger]");
  const drawer = document.querySelector("[data-header-drawer]");
  const closeBtn = document.querySelector("[data-header-close]");

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
    drawer.hidden = false;
    requestAnimationFrame(() => {
      drawer.classList.add("is-open");
    });
    burger.setAttribute("aria-expanded", "true");
    lockScroll(true);
  };

  const closeDrawer = () => {
    if (!drawer || !burger) return;
    drawer.classList.remove("is-open");
    burger.setAttribute("aria-expanded", "false");
    lockScroll(false);
    window.setTimeout(() => {
      drawer.hidden = true;
    }, 200);
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
    if (e.key !== "Escape") return;
    closeDrawer();
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
  setHeaderOffsetVar();
  window.addEventListener("resize", () => {
    setHeaderOffsetVar();
    // close drawer on resize to desktop
    if (window.innerWidth >= 1280) {
      closeDrawer();
    }
  });
})();


