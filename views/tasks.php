<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр задач</title>
    <link rel="stylesheet" href="/template/assets/css/tasks.css">
</head>
<body>
<div class="container">
    <h1 id="task-title"></h1>
    <div class="filter-buttons">
        <button id="filter-today">Сегодня</button>
        <button id="filter-week">Ближайшие 7 дней</button>
        <button id="filter-overdue">Просроченные</button>
        <button id="filter-all">Все задачи</button>
    </div>
    <ul id="tasks-list">
        <!-- Примеры задач -->
        <?php foreach($tasks as $task): ?>
            <li data-date="<?=$task['deadline_day']?>" data-time="<?=$task['deadline_time']?>">
                <div class="task-content">
                    <div class="task-info">
                        <h3><?=$task['title']?></h3>
                        <p>Дата и время: <?=$task['ua_time']?> <?=$task['deadline_time']?></p>
                        <p>Описание: <?=$task['text']?>.</p>
                    </div>
                    <form class="task-actions" method="post" action="/complete/task">
<!--                        <a href="" class="task-action-link">Редактировать</a>-->
<!--                        <a href="" class="task-action-link">Удалить</a>-->
                        <input type="hidden" name="id" value="<?=$task['id']?>">
                        <?php if(isset($task['num']) && !empty($task['num'])){ ?>
                            <input type="hidden" name="num" value="<?=$task['num']?>">
                        <?php } ?>
                        <input class="task-action-link" type="submit" name="send" value="Выполнить">
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
        <!-- Здесь можно добавить больше задач -->
    </ul>
    <div style="display: flex;justify-content: space-around;">
        <a href="/complete/task/show/1" class="view-tasks-link">Выполненые Задачи</a>
        <a href="/index" class="view-tasks-link">Назад к созданию задач</a>
    </div>

</div>
<script src="/template/assets/js/task.js"></script>
</body>
</html>
