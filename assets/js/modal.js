(function () {
  const init = () => {
    let activeModal = null;
    let opener = null;
    const focusable = 'a[href], button:not([disabled]), input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex="0"]';

    document.querySelectorAll('.modal .form').forEach(form => {
      const actions = form.querySelector('.form__actions');
      if (actions) form.appendChild(actions);
    });

    document.querySelectorAll('.modal .form__field').forEach((field, index) => {
      const input = field.querySelector('input');
      const label = field.querySelector('label');
      if (!input || !label) return;
      input.id = input.id || `modal-field-${index}`;
      label.htmlFor = input.id;
      if (input.name === 'your-name') {
        label.textContent = 'Имя и фамилия';
        input.placeholder = 'Как к вам обращаться';
        input.autocomplete = 'name';
      }
      if (input.name === 'your-phone') input.autocomplete = 'tel';
    });

    const closeModal = (restoreFocus = true) => {
      if (!activeModal) return;
      activeModal.classList.remove('is-open');
      activeModal.setAttribute('aria-hidden', 'true');
      activeModal = null;
      document.body.classList.remove('is-modal-open');
      if (restoreFocus && opener?.isConnected) opener.focus({ preventScroll: true });
    };

    const openModal = (id, trigger) => {
      const modal = document.getElementById(id);
      if (!modal) return;
      closeModal(false);
      opener = trigger;
      activeModal = modal;
      document.body.classList.add('is-modal-open');
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      const content = modal.querySelector('.modal__content');
      content.scrollTop = 0;
      modal.dispatchEvent(new CustomEvent('modal:open'));
      // Keep the phone keyboard closed so the form is visible in full.
      const firstField = modal.id === 'modal-signup' && matchMedia('(min-width: 769px)').matches
        ? modal.querySelector('input:not([type="hidden"])') : null;
      (firstField || content).focus({ preventScroll: true });
    };

    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-modal]');
      if (trigger) {
        event.preventDefault();
        openModal(`modal-${trigger.dataset.modal}`, trigger);
        return;
      }
      if (event.target.closest('[data-modal-close]') || event.target.classList.contains('modal__overlay')) {
        event.preventDefault();
        closeModal();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (!activeModal) return;
      if (event.key === 'Escape') {
        event.preventDefault();
        closeModal();
      }
      if (event.key !== 'Tab') return;
      const elements = [...activeModal.querySelectorAll(focusable)].filter(el => el.getClientRects().length);
      const first = elements[0];
      const last = elements[elements.length - 1];
      if (!first) return;
      const current = document.activeElement;
      if (event.shiftKey && (current === first || !elements.includes(current))) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && (current === last || !elements.includes(current))) {
        event.preventDefault();
        first.focus();
      }
    });
  };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
