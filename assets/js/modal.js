(function () {
  const init = () => {
    const openButtons = document.querySelectorAll('[data-modal="signup"]');
    const closeButtons = document.querySelectorAll('[data-modal-close]');
    const body = document.body;

    if (openButtons.length === 0) {
      console.warn('Modal: No buttons with data-modal="signup" found');
      return;
    }

    const modal = document.getElementById('modal-signup');
    if (!modal) {
      console.warn('Modal: Modal #modal-signup not found');
      return;
    }

    const openModal = () => {
      body.classList.add('is-modal-open');
      modal.classList.add('is-open');
    };

    const closeModal = () => {
      modal.classList.remove('is-open');
      body.classList.remove('is-modal-open');
    };

    openButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        openModal();
      });
    });

    closeButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal();
      });
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeModal();
      }
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();


