document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.js-phone').forEach((input) => {
    input.addEventListener('input', () => {
      let x = input.value.replace(/\D/g, '').substring(0, 11);
      if (x.startsWith('8')) x = '7' + x.substring(1);
      if (!x.startsWith('7')) x = '7' + x;

      let formatted = '+7';
      if (x.length > 1) formatted += '(' + x.substring(1, 4);
      if (x.length >= 4) formatted += ') ' + x.substring(4, 7);
      if (x.length >= 7) formatted += '-' + x.substring(7, 9);
      if (x.length >= 9) formatted += '-' + x.substring(9, 11);

      input.value = formatted;
    });
  });
});


