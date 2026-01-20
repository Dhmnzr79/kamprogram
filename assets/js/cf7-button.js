(function () {
  const iconSvg = '<svg class="btn__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.75 7.75L0.75 7.75M14.75 7.75L7.75 14.75M14.75 7.75L7.75 0.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  const processSubmitButtons = () => {
    const submitInputs = document.querySelectorAll('input[type="submit"].wpcf7-submit, input[type="submit"][name*="submit"]');
    
    submitInputs.forEach((input) => {
      // Пропускаем, если уже обработан
      if (input.dataset.processed === 'true') {
        return;
      }

      // Создаём button
      const button = document.createElement('button');
      button.type = 'submit';
      button.className = 'btn btn-primary';
      
      // Копируем атрибуты
      if (input.name) button.name = input.name;
      if (input.id) button.id = input.id;
      
      // Создаём текстовый узел для текста кнопки
      const text = input.value || 'Отправить заявку';
      button.appendChild(document.createTextNode(text));
      
      // Добавляем иконку (без пробелов, чтобы избежать <br>)
      button.insertAdjacentHTML('beforeend', iconSvg);
      
      // Удаляем возможные <br> внутри кнопки
      const brTags = button.querySelectorAll('br');
      brTags.forEach(br => br.remove());
      
      // Заменяем input на button
      input.parentNode.replaceChild(button, input);
      
      // Помечаем как обработанный
      button.dataset.processed = 'true';
    });
  };

  const init = () => {
    // Обрабатываем кнопки при загрузке
    processSubmitButtons();

    // Обрабатываем кнопки после AJAX-отправки формы CF7
    if (typeof wpcf7 !== 'undefined') {
      document.addEventListener('wpcf7mailsent', processSubmitButtons);
      document.addEventListener('wpcf7mailfailed', processSubmitButtons);
      document.addEventListener('wpcf7invalid', processSubmitButtons);
      document.addEventListener('wpcf7spam', processSubmitButtons);
    }

    // Обрабатываем при динамической загрузке форм
    const observer = new MutationObserver(() => {
      processSubmitButtons();
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
