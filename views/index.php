<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планер задач</title>
    <link rel="stylesheet" href="/template/assets/css/style.css">
    <style>
        #project{
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container" >
    <h1>Планер задач</h1>
    <form id="task-form" action="add/task" method="post">
        <label for="title">Заголовок задачи</label>
        <input type="text" id="title" name="title" placeholder="Title" required>

        <label for="project">Выберите проект:</label>
        <select id="project" name="project" required>
            <option value="0" disabled selected>Выберите проект</option>
            <?php foreach($projects as $project): ?>
            <option value="<?=$project['id']?>"><?=$project['name']?></option>
            <?php endforeach; ?>

        </select>

        <label for="date-time">Дата и время</label>
        <input type="datetime-local" id="date-time" name="data" required>

        <label for="description">Описание задачи</label>
        <textarea id="description" name="text" rows="4" placeholder="Detail" required></textarea>
        <?php if(!isset($_SESSION['user'])){ ?>
            <a href="/user/login" class="view-tasks-link">Увійдіть для створення завдання</a>
        <?php } else { ?>
            <button type="submit">Создать задачу</button>
        <?php } ?>
    </form>
    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ ?>
    <a href="/all/task" class="view-tasks-link">Просмотреть все задачи</a>
    <a href="/all/project" class="view-tasks-link">Просмотреть все Проекти</a>
    <?php if($_SESSION['user']['lvl'] == 1){ ?>
        <a href="/user/reg" class="view-tasks-link">Зареєструвати робітника</a>
        <a href="/add/project" class="view-tasks-link">Створити Проект</a>
        <?php } ?>
    <a href="/user/exit" class="view-tasks-link">Exit</a>

    <?php } ?>
</div>
</body>
</html>
