(function () {
  const init = () => {
    const body = document.body;
    const closeButtons = document.querySelectorAll('[data-modal-close]');

    // Функция открытия модалки
    const openModal = (modalId) => {
      const modal = document.getElementById(modalId);
      if (!modal) {
        console.warn(`Modal: Modal #${modalId} not found`);
        return;
      }
      body.classList.add('is-modal-open');
      modal.classList.add('is-open');
    };

    // Функция закрытия модалки
    const closeModal = (modalId) => {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove('is-open');
      }
      body.classList.remove('is-modal-open');
    };

    // Обработчики для кнопок открытия
    document.addEventListener('click', (e) => {
      const button = e.target.closest('[data-modal]');
      if (button) {
        const modalId = 'modal-' + button.dataset.modal;
        e.preventDefault();
        openModal(modalId);
      }
    });

    // Обработчики для кнопок закрытия
    closeButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        // Закрываем все открытые модалки
        const openModals = document.querySelectorAll('.modal.is-open');
        openModals.forEach((modal) => {
          closeModal(modal.id);
        });
      });
    });

    // Закрытие по Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal.is-open');
        openModals.forEach((modal) => {
          closeModal(modal.id);
        });
      }
    });

    // Закрытие по клику на overlay
    document.addEventListener('click', (e) => {
      if (e.target.classList.contains('modal__overlay')) {
        const modal = e.target.closest('.modal');
        if (modal) {
          closeModal(modal.id);
        }
      }
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();


