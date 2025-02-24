document.addEventListener('DOMContentLoaded', function() {
    // Получаем элементы кнопок фильтрации
    const filterTodayButton = document.getElementById('filter-today');
    const filterWeekButton = document.getElementById('filter-week');
    const filterOverdueButton = document.getElementById('filter-overdue');
    const filterAllButton = document.getElementById('filter-all');

    // Получаем список задач и заголовок
    const tasksList = document.getElementById('tasks-list');
    const tasks = tasksList.getElementsByTagName('li');
    const taskTitle = document.getElementById('task-title');

    // Создаем и добавляем элемент сообщения "Нет задач"
    const noTasksMessage = document.createElement('p');
    noTasksMessage.textContent = 'Нет задач';
    noTasksMessage.style.display = 'none'; // Скрываем сообщение по умолчанию
    tasksList.parentNode.insertBefore(noTasksMessage, tasksList);

    // Функция для фильтрации задач
    function filterTasks(filter) {
        const now = new Date(); // Текущее время
        const today = new Date(); // Сегодняшний день
        today.setHours(0, 0, 0, 0); // Начало сегодняшнего дня
        const nextWeek = new Date(today); // Начало следующей недели
        nextWeek.setDate(today.getDate() + 7);

        let hasTasks = false; // Флаг для проверки наличия задач

        // Проходим по всем задачам
        for (let i = 0; i < tasks.length; i++) {
            const taskDate = new Date(tasks[i].getAttribute('data-date')); // Дата задачи
            const taskTime = tasks[i].getAttribute('data-time'); // Время задачи
            const taskDateTime = new Date(`${taskDate.toDateString()} ${taskTime}`); // Полное время задачи

            tasks[i].style.display = 'none'; // Скрываем задачу по умолчанию
            tasks[i].classList.remove('overdue', 'today', 'upcoming'); // Убираем все классы подсветки

            // Фильтр для задач на сегодня
            if (filter === 'today' && taskDate.toDateString() === today.toDateString()) {
                if (taskDateTime >= now) { // Проверяем, что время задачи больше текущего времени
                    tasks[i].style.display = 'block'; // Показываем задачу
                    tasks[i].classList.add('today'); // Подсвечиваем зеленым цветом
                    hasTasks = true;
                }
            }

            // Фильтр для задач на ближайшие 7 дней
            if (filter === 'week' && taskDate >= today && taskDate <= nextWeek) {
                if (taskDateTime >= today && taskDateTime <= nextWeek) { // Проверяем, что время задачи в пределах недели
                    tasks[i].style.display = 'block'; // Показываем задачу
                    tasks[i].classList.add('upcoming'); // Подсвечиваем серым цветом
                    hasTasks = true;
                }
            }

            // Фильтр для просроченных задач
            if (filter === 'overdue' && taskDateTime < today) {
                tasks[i].style.display = 'block'; // Показываем задачу
                tasks[i].classList.add('overdue'); // Подсвечиваем красным цветом
                hasTasks = true;
            }

            // Фильтр для всех задач
            if (filter === 'all') {
                tasks[i].style.display = 'block'; // Показываем задачу
                if (taskDateTime < today) {
                    tasks[i].classList.add('overdue'); // Подсвечиваем просроченные задачи красным цветом
                } else if (taskDate.toDateString() === today.toDateString() && taskDateTime >= now) {
                    tasks[i].classList.add('today'); // Подсвечиваем задачи на сегодня зеленым цветом
                } else if (taskDate >= today && taskDate <= nextWeek) {
                    tasks[i].classList.add('upcoming'); // Подсвечиваем задачи на ближайшую неделю серым цветом
                }
                hasTasks = true;
            }
        }

        // Меняем заголовок в зависимости от выбранного фильтра
        if (filter === 'today') {
            taskTitle.textContent = 'Задачи на сегодня';
        } else if (filter === 'week') {
            taskTitle.textContent = 'Задачи на ближайшие 7 дней';
        } else if (filter === 'overdue') {
            taskTitle.textContent = 'Просроченные задачи';
        } else {
            taskTitle.textContent = 'Все задачи';
        }

        // Показываем или скрываем сообщение "Нет задач"
        if (hasTasks) {
            noTasksMessage.style.display = 'none'; // Если задачи есть, скрываем сообщение
        } else {
            noTasksMessage.style.display = 'block'; // Если задач нет, показываем сообщение
        }
    }

    // Добавляем обработчики событий для кнопок фильтрации
    filterTodayButton.addEventListener('click', function() {
        filterTasks('today');
    });

    filterWeekButton.addEventListener('click', function() {
        filterTasks('week');
    });

    filterOverdueButton.addEventListener('click', function() {
        filterTasks('overdue');
    });

    filterAllButton.addEventListener('click', function() {
        filterTasks('all');
    });

    // По умолчанию показываем все задачи
    filterTasks('all');
});
