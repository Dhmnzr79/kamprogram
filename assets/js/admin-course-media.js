(function () {
  const root = document;

  const bindUploader = (config) => {
    const openBtn = root.querySelector(config.openSelector);
    const removeBtn = root.querySelector(config.removeSelector);
    const input = root.querySelector(config.inputSelector);
    const preview = root.querySelector(config.previewSelector);

    if (!openBtn || !input || !preview) return;

    const render = (attachment) => {
      if (!attachment) {
        input.value = "";
        preview.innerHTML = "";
        if (removeBtn) removeBtn.hidden = true;
        return;
      }

      input.value = String(attachment.id || "");
      if (attachment.url) {
        preview.innerHTML = `<img src="${attachment.url}" alt="" style="max-width: 100%; height: auto;">`;
      } else {
        preview.innerHTML = "";
      }
      if (removeBtn) removeBtn.hidden = false;
    };

    openBtn.addEventListener("click", (e) => {
      e.preventDefault();

      const frame = wp.media({
        title: "Выберите изображение",
        button: { text: "Использовать" },
        library: { type: "image" },
        multiple: false,
      });

      frame.on("select", () => {
        const attachment = frame.state().get("selection").first().toJSON();
        render(attachment);
      });

      frame.open();
    });

    if (removeBtn) {
      removeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        render(null);
      });
    }
  };

  const bindCardUploaders = () => {
    const buttons = Array.from(root.querySelectorAll("[data-kp-card-open]"));

    buttons.forEach((btn) => {
      const idx = btn.getAttribute("data-kp-card-open");
      if (idx === null) return;

      bindUploader({
        openSelector: `[data-kp-card-open="${idx}"]`,
        removeSelector: `[data-kp-card-remove="${idx}"]`,
        inputSelector: `[data-kp-card-input="${idx}"]`,
        previewSelector: `[data-kp-card-preview="${idx}"]`,
      });
    });
  };

  const init = () => {
    if (!window.wp || !wp.media) return;

    bindUploader({
      openSelector: "[data-kp-why-photo-open]",
      removeSelector: "[data-kp-why-photo-remove]",
      inputSelector: "[data-kp-why-photo-input]",
      previewSelector: "[data-kp-why-photo-preview]",
    });

    bindCardUploaders();
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();


