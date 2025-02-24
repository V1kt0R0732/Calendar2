<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр задач</title>
    <link rel="stylesheet" href="/template/assets/css/complete.css">
</head>
<body>
<div class="container">
    <h1 id="task-title">Выполненые задачи</h1>
    <!--    <div class="filter-buttons">-->
    <!--        <button id="filter-today">Сегодня</button>-->
    <!--        <button id="filter-week">Ближайшие 7 дней</button>-->
    <!--        <button id="filter-overdue">Просроченные</button>-->
    <!--        <button id="filter-all">Все задачи</button>-->
    <!--    </div>-->
    <ul id="tasks-list">
        <!-- Примеры задач -->
        <?php foreach($tasks as $task): ?>
            <li data-date="<?=$task['deadline_day']?>" data-time="<?=$task['deadline_time']?>" class="today">
                <div class="task-content">
                    <div class="task-info">
                        <h3><?php if(isset($task['id']) && !empty($task['id']) && $_SESSION['user']['lvl'] == 1){ ?><a href="/show/complete/task/<?=$task['id']?>"><?php } ?><?=$task['title']?></a></h3>
                        <p>Дата и время: <?=$task['ua_time']?> <?=$task['deadline_time']?></p>
                        <p>Описание: <?=$task['text']?>.</p>
                    </div>
                    <div class="task-info-2">
                        <span>Виконав за : <?=$task['time_spend']?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        <!-- Здесь можно добавить больше задач -->
    </ul>
    <div class="pagination">
        <?php if($_SESSION['page']['active_page'] == 1){ ?>
            <a class="page-number"> < </a>
        <?php } else { ?>
            <a href="<?php echo $_SESSION['page']['active_page']-1; ?>" class="page-number"> < </a>
        <?php } ?>
        <?php for($i = 1; $i <= $_SESSION['page']['count']; $i++){ ?>
            <?php if($i == $_SESSION['page']['active_page']){ ?>
                <a class="page-number.active"><?=$i?></a>
            <?php } else { ?>
                <a href="<?=$i?>" class="page-number"><?=$i?></a>
            <?php } ?>
        <?php } ?>
        <?php if($_SESSION['page']['active_page'] == $_SESSION['page']['count']){ ?>
            <a class="page-number"> > </a>
        <?php } else { ?>
            <a href="<?php echo $_SESSION['page']['active_page']+1; ?>" class="page-number"> > </a>
        <?php } ?>
    </div>
    <div style="display: flex;justify-content: space-around;">
        <a href="/all/task" class="view-tasks-link">Назад к не Выполненым Задачам</a>
        <a href="/index" class="view-tasks-link">Назад к созданию задач</a>
    </div>
</div>
<script src="/template/assets/js/task.js"></script>
</body>
</html>
