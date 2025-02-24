<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр задач</title>
    <link rel="stylesheet" href="/template/assets/css/admin_tasks.css">
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
                        <h3><?php if(isset($task['id']) && !empty($task['id'])){ ?><a href="/show/task/<?=$task['id']?>"><?php } ?><?=$task['title']?></a></h3>
                        <p>Дата и время: <?=$task['ua_time']?> <?=$task['deadline_time']?></p>
                        <p>Описание: <?=$task['text']?>.</p>
                        <?php if(isset($task['employees_str']) && !empty($task['employees_str'])){ ?>
                        <p>Назначено сотрудникам: <b><span class="assigned-employees"><?=$task['employees_str']?></span></b></p>
                        <?php } else { ?>
                        <p>Пустая задача</p>
                        <?php } ?>
                    </div>
                    <form class="task-actions" action="/manage/add" method="post">
                        <label for="assign">Назначить:</label>
                        <select id="assign" class="assign-select" name="worker">
                            <?php foreach($workers as $worker):
                                if(!empty($task['employees_arr'])){
                                    $tmp = true;
                                    foreach($task['employees_arr'] as $employ){
                                        if($worker['name'] == $employ['nick']){
                                            $tmp = false;
                                        }
                                    }
                                    if($tmp){
                            ?>
                            <option value="<?=$worker['id']?>"><?=$worker['name']?></option>
                            <?php } } else {?>
                            <option value="<?=$worker['id']?>"><?=$worker['name']?></option>
                            <?php } endforeach; ?>
                        </select>
                        <input type="hidden" name="id" value="<?=$task['id']?>">
                        <?php if(isset($task['num']) && !empty($task['num'])){ ?>
                        <input type="hidden" name="num" value="<?=$task['num']?>">
                        <?php } ?>
                        <input type="hidden" name="time" value="<?php echo $task['deadline_day'].' '.$task['deadline_time'].':00'?>">
                        <input class="assign-button" value="Назначить задачу" name="send" type="submit">
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
