<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проекти</title>
    <link rel="stylesheet" href="/template/assets/css/admin_tasks.css">
</head>
<body>
<div class="container">
    <h1 id="task-title">Проекти</h1>
    <h3>Пошук за назвою:</h3>
    <form action="/all/project" method="post">
        <input type="text" name="title" <?php if(isset($_POST['title']) && !empty($_POST['title'])) echo "value='{$_POST['title']}'";else{?>placeholder="Title"<?php } ?>>
        <input type="submit" name="send" value="Пошук">
    </form>
    <h3>Пошук за Робітниками</h3>
    <form action="/all/project" method="post">
        <input type="text" name="nick" <?php if(isset($_POST['nick']) && !empty($_POST['nick'])) echo "value='{$_POST['nick']}'";else{?>placeholder="Nick"<?php } ?>>
        <input type="submit" name="send" value="Пошук">
    </form>

    <!--
    <div class="filter-buttons">
        <button id="filter-today">Сегодня</button>
        <button id="filter-week">Ближайшие 7 дней</button>
        <button id="filter-overdue">Просроченные</button>
        <button id="filter-all">Все задачи</button>
    </div>
    -->
    <?php if(isset($projects) && !empty($projects)){ ?>
    <ul id="tasks-list">
        <!-- Примеры задач -->
        <?php foreach($projects as $task): ?>
            <li>
                <div class="task-content">
                    <div class="task-info">
                        <h3><?=$task['name']?></h3>
                        <p>Завдання: <?=$task['count']?></p>
                    </div>
                    <form class="task-actions" action="/manage/add" method="post">

                        <?php if(!empty($task['count'])){ ?>
                            <label for="assign">Задачі Проекта:</label>
                        <a href="/show/project/<?=$task['id']?>" class="assign-button">Click</a>
                        <?php } else { ?>
                            <label for="assign">Створити задачу</label>
                        <a href="/index" class="assign-button">Click</a>
                        <?php } ?>
                        <label for="assign">Full Info:</label>
                        <a href="/project/detail/<?=$task['id']?>" class="assign-button">Click</a>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
        <?php } else{ ?>
            <h3>Проектів не знайдено</h3>
        <?php } ?>
    <div style="display: flex;justify-content: space-around;">
        <a href="/projects/all" class="view-tasks-link">Сводка по всем проектам</a>
        <a href="/index" class="view-tasks-link">Назад к созданию задач</a>
    </div>
</div>
<!--<script src="/template/assets/js/task.js"></script>-->
</body>
</html>
