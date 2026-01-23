(function () {
  'use strict';

  // Состояние квиза
  const quizState = {
    age: '',
    interests: '',
    goal: '',
    thinking: '',
    recommendedCourses: []
  };

  // База данных курсов с критериями
  const coursesDatabase = {
    'Робототехника LEGO': {
      ages: ['5-7', '8-11'],
      interests: ['constructors', 'logic'],
      goals: ['logic', 'career'],
      thinking: ['hands', 'plan'],
      description: 'Развитие логики и технического мышления через конструирование и программирование роботов.'
    },
    'Мастерская Scratch': {
      ages: ['8-11', '12-14'],
      interests: ['creative', 'tech'],
      goals: ['creative', 'logic'],
      thinking: ['creative', 'research'],
      description: 'Создание игр, мультфильмов и интерактивных историй с помощью визуального программирования.'
    },
    'Программирование на Python': {
      ages: ['12-14', '15-18'],
      interests: ['tech', 'logic'],
      goals: ['career', 'olympiad'],
      thinking: ['research', 'plan'],
      description: 'Изучение одного из самых популярных языков программирования для создания реальных проектов.'
    },
    'Системное администрирование': {
      ages: ['12-14', '15-18'],
      interests: ['tech'],
      goals: ['career'],
      thinking: ['research'],
      description: 'Освоение работы с операционными системами, сетями и серверами.'
    },
    'Компьютерная графика': {
      ages: ['8-11', '12-14', '15-18'],
      interests: ['creative'],
      goals: ['creative', 'career'],
      thinking: ['creative', 'perfect'],
      description: 'Создание цифровых иллюстраций, дизайна и визуального контента.'
    },
    'Мультипликация': {
      ages: ['8-11', '12-14'],
      interests: ['creative'],
      goals: ['creative'],
      thinking: ['creative'],
      description: 'Создание анимационных роликов и мультфильмов с использованием современных инструментов.'
    },
    'HTML и JavaScript': {
      ages: ['12-14', '15-18'],
      interests: ['tech', 'creative'],
      goals: ['career'],
      thinking: ['research', 'plan'],
      description: 'Разработка веб-сайтов и интерактивных веб-приложений.'
    },
    'Олимпиадная математика': {
      ages: ['12-14', '15-18'],
      interests: ['logic'],
      goals: ['olympiad', 'logic'],
      thinking: ['plan'],
      description: 'Углубленное изучение математики для подготовки к олимпиадам и поступлению в вуз.'
    },
    'Каллиграфия и красивый почерк': {
      ages: ['5-7', '8-11'],
      interests: ['perfection'],
      goals: ['performance'],
      thinking: ['perfect'],
      description: 'Развитие аккуратности, внимания к деталям и красивого почерка.'
    },
    'Черчение': {
      ages: ['12-14', '15-18'],
      interests: ['logic', 'perfection'],
      goals: ['olympiad', 'career'],
      thinking: ['plan', 'perfect'],
      description: 'Изучение технического черчения для будущих инженеров и архитекторов.'
    }
  };

  /**
   * Инициализация квиза
   */
  const init = () => {
    const quizModal = document.getElementById('modal-quiz');
    if (!quizModal) {
      console.warn('Quiz: Modal #modal-quiz not found');
      return;
    }

    // Инициализация: показываем только первый шаг
    const steps = quizModal.querySelectorAll('.quiz-step');
    steps.forEach((step, index) => {
      if (index === 0) {
        step.hidden = false;
        step.classList.remove('hidden');
      } else {
        step.hidden = true;
        step.classList.add('hidden');
      }
    });

    // Обработчики для радиокнопок
    const radioInputs = quizModal.querySelectorAll('input[type="radio"][data-quiz-answer]');
    radioInputs.forEach(input => {
      input.addEventListener('change', handleAnswerChange);
    });

    // Кнопки навигации
    const nextButtons = quizModal.querySelectorAll('.quiz-btn-next');
    const backButtons = quizModal.querySelectorAll('.quiz-btn-back');

    nextButtons.forEach(btn => {
      btn.addEventListener('click', handleNext);
    });

    backButtons.forEach(btn => {
      btn.addEventListener('click', handleBack);
    });

    // Сброс квиза при открытии модалки
    const openButtons = document.querySelectorAll('[data-modal="quiz"]');
    openButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        // Небольшая задержка, чтобы модалка успела открыться
        setTimeout(resetQuiz, 100);
      });
    });

    // Также отслеживаем открытие модалки через наблюдение за классом
    let lastState = quizModal.classList.contains('is-open');
    const observer = new MutationObserver(() => {
      const currentState = quizModal.classList.contains('is-open');
      if (currentState && !lastState) {
        // Модалка только что открылась
        resetQuiz();
      }
      lastState = currentState;
    });

    observer.observe(quizModal, {
      attributes: true,
      attributeFilter: ['class']
    });
  };

  /**
   * Обработка изменения ответа
   */
  const handleAnswerChange = (e) => {
    const step = e.target.closest('.quiz-step');
    if (!step) return;

    const stepNumber = parseInt(step.dataset.step, 10);
    const nextButton = step.querySelector('.quiz-btn-next');
    
    if (nextButton) {
      nextButton.disabled = false;
    }

    // Убираем класс checked со всех опций в этом шаге
    const allOptions = step.querySelectorAll('.quiz-option');
    allOptions.forEach(option => {
      option.classList.remove('quiz-option--checked');
    });

    // Добавляем класс checked к выбранной опции (для поддержки старых браузеров)
    const selectedOption = e.target.closest('.quiz-option');
    if (selectedOption) {
      selectedOption.classList.add('quiz-option--checked');
    }

    // Сохраняем ответ в состояние
    const name = e.target.name;
    const value = e.target.value;
    
    if (name === 'age') {
      quizState.age = value;
    } else if (name === 'interests') {
      quizState.interests = value;
    } else if (name === 'goal') {
      quizState.goal = value;
    } else if (name === 'thinking') {
      quizState.thinking = value;
    }
  };

  /**
   * Переход к следующему шагу
   */
  const handleNext = (e) => {
    const quizModal = document.getElementById('modal-quiz');
    if (!quizModal) return;

    const currentStep = e.target.closest('.quiz-step');
    if (!currentStep) return;

    const currentStepNumber = parseInt(currentStep.dataset.step, 10);
    const nextStepNumber = currentStepNumber + 1;

    // Если это последний шаг с вопросами, показываем результаты
    if (currentStepNumber === 4) {
      showResults();
      return;
    }

    // Переход к следующему шагу
    const nextStep = quizModal.querySelector(`.quiz-step[data-step="${nextStepNumber}"]`);
    if (nextStep) {
      currentStep.hidden = true;
      currentStep.classList.add('hidden');
      nextStep.hidden = false;
      nextStep.classList.remove('hidden');
    }
  };

  /**
   * Возврат к предыдущему шагу
   */
  const handleBack = (e) => {
    const quizModal = document.getElementById('modal-quiz');
    if (!quizModal) return;

    const currentStep = e.target.closest('.quiz-step');
    if (!currentStep) return;

    const currentStepNumber = parseInt(currentStep.dataset.step, 10);
    const prevStepNumber = currentStepNumber - 1;

    if (prevStepNumber >= 1) {
      const prevStep = quizModal.querySelector(`.quiz-step[data-step="${prevStepNumber}"]`);
      if (prevStep) {
        currentStep.hidden = true;
        currentStep.classList.add('hidden');
        prevStep.hidden = false;
        prevStep.classList.remove('hidden');
      }
    }
  };

  /**
   * Подбор курсов на основе ответов
   */
  const getRecommendedCourses = () => {
    const scores = {};

    // Проходим по всем курсам и считаем баллы
    Object.keys(coursesDatabase).forEach(courseName => {
      const course = coursesDatabase[courseName];
      let score = 0;

      // Возраст - основной фильтр (обязательное условие)
      if (!course.ages.includes(quizState.age)) {
        return; // Пропускаем курсы, не подходящие по возрасту
      }

      // Остальные критерии добавляют баллы
      if (course.interests.includes(quizState.interests)) {
        score += 3;
      }
      if (course.goals.includes(quizState.goal)) {
        score += 3;
      }
      if (course.thinking.includes(quizState.thinking)) {
        score += 2;
      }

      if (score > 0) {
        scores[courseName] = score;
      }
    });

    // Сортируем по баллам и берем топ-3
    const sorted = Object.entries(scores)
      .sort((a, b) => b[1] - a[1])
      .slice(0, 3)
      .map(([name]) => name);

    return sorted.length > 0 ? sorted : getDefaultCourses();
  };

  /**
   * Получить курсы по умолчанию, если нет точных совпадений
   */
  const getDefaultCourses = () => {
    const ageDefaults = {
      '5-7': ['Робототехника LEGO', 'Каллиграфия и красивый почерк', 'Мастерская Scratch'],
      '8-11': ['Мастерская Scratch', 'Робототехника LEGO', 'Компьютерная графика'],
      '12-14': ['Программирование на Python', 'HTML и JavaScript', 'Олимпиадная математика'],
      '15-18': ['Программирование на Python', 'Системное администрирование', 'HTML и JavaScript']
    };

    return ageDefaults[quizState.age] || ['Мастерская Scratch', 'Программирование на Python', 'Компьютерная графика'];
  };

  /**
   * Показать результаты и форму
   */
  const showResults = () => {
    const resultsContainer = document.getElementById('quiz-results');
    const step4 = document.querySelector('#modal-quiz .quiz-step[data-step="4"]');
    const step5 = document.querySelector('#modal-quiz .quiz-step[data-step="5"]');

    if (!resultsContainer || !step4 || !step5) {
      console.warn('Quiz: Results container or steps not found');
      return;
    }

    // Получаем рекомендованные курсы
    quizState.recommendedCourses = getRecommendedCourses();

    // Очищаем контейнер результатов
    resultsContainer.innerHTML = '';

    // Добавляем карточки курсов
    quizState.recommendedCourses.forEach(courseName => {
      const course = coursesDatabase[courseName];
      if (!course) {
        console.warn(`Quiz: Course "${courseName}" not found in database`);
        return;
      }
      const card = document.createElement('div');
      card.className = 'quiz-result-item';
      card.innerHTML = `
        <h3 class="quiz-result-item__title">${courseName}</h3>
        <p class="quiz-result-item__description">${course.description}</p>
      `;
      resultsContainer.appendChild(card);
    });

    // Переходим к шагу с результатами
    step4.hidden = true;
    step4.classList.add('hidden');
    step5.hidden = false;
    step5.classList.remove('hidden');

    // Заполняем скрытые поля формы
    fillHiddenFields();
  };

  /**
   * Заполнение скрытых полей Contact Form 7
   */
  const fillHiddenFields = () => {
    // Ждем, пока форма CF7 загрузится
    setTimeout(() => {
      const form = document.querySelector('#modal-quiz .wpcf7-form');
      if (!form) return;

      // Создаем или обновляем скрытые поля
      const fields = {
        'quiz-age': quizState.age,
        'quiz-interests': quizState.interests,
        'quiz-goal': quizState.goal,
        'quiz-thinking': quizState.thinking,
        'quiz-courses': quizState.recommendedCourses.join(', ')
      };

      Object.entries(fields).forEach(([name, value]) => {
        let input = form.querySelector(`input[name="${name}"]`);
        if (!input) {
          input = document.createElement('input');
          input.type = 'hidden';
          input.name = name;
          form.appendChild(input);
        }
        input.value = value;
      });
    }, 100);
  };

  /**
   * Сброс квиза при открытии
   */
  const resetQuiz = () => {
    // Сбрасываем состояние
    quizState.age = '';
    quizState.interests = '';
    quizState.goal = '';
    quizState.thinking = '';
    quizState.recommendedCourses = [];

    // Сбрасываем форму
    const quizModal = document.getElementById('modal-quiz');
    if (!quizModal) return;

    // Сбрасываем все радиокнопки
    const radioInputs = quizModal.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(input => {
      input.checked = false;
    });

    // Убираем класс checked со всех опций
    const allOptions = quizModal.querySelectorAll('.quiz-option');
    allOptions.forEach(option => {
      option.classList.remove('quiz-option--checked');
    });

    // Отключаем кнопки "Далее"
    const nextButtons = quizModal.querySelectorAll('.quiz-btn-next');
    nextButtons.forEach(btn => {
      btn.disabled = true;
    });

    // Показываем первый шаг, скрываем остальные
    const steps = quizModal.querySelectorAll('.quiz-step');
    steps.forEach((step, index) => {
      if (index === 0) {
        step.hidden = false;
        step.classList.remove('hidden');
      } else {
        step.hidden = true;
        step.classList.add('hidden');
      }
    });
  };

  // Инициализация при загрузке DOM
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
