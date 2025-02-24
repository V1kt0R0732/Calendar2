<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Створення Проекту</title>
    <link rel="stylesheet" href="/template/assets/css/style.css">
</head>
<body>
<div class="container" >
    <h1>Створити Проект</h1>
    <form id="task-form" action="/add/project" method="post">
        <label for="title">Назва Проекту</label>
        <input type="text" id="title" name="name" placeholder="Title" required>
        <?php if(!isset($_SESSION['user']) || $_SESSION['user']['lvl'] != 1){ ?>
            <a href="/user/login" class="view-tasks-link">Увійдіть для створення Проекту</a>
        <?php } else { ?>
            <button type="submit" name="send" value="Создать проект">Создать Проект</button>
        <?php } ?>
    </form>
    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ ?>
        <a href="/all/task" class="view-tasks-link">Просмотреть все задачи</a>
        <?php if($_SESSION['user']['lvl'] == 1){ ?>
            <a href="/user/reg" class="view-tasks-link">Зареєструвати робітника</a>
            <a href="/index" class="view-tasks-link">Створити задачу</a>
        <?php } ?>
        <a href="/user/exit" class="view-tasks-link">Exit</a>

    <?php } ?>
</div>
</body>
</html>
