<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планер задач</title>
    <link rel="stylesheet" href="/template/assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Планер задач</h1>
    <form id="task-form">
        <label for="title">Заголовок задачи</label>
        <input type="text" id="title" name="title" required>

        <label for="date-time">Дата и время</label>
        <input type="datetime-local" id="date-time" name="date-time" required>

        <label for="description">Описание задачи</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Создать задачу</button>
    </form>
    <form action="add/task" method="post">
        <h2>Оберіть дату та добавте задачу</h2>
        <input type="text" name="title" placeholder="Заголов">
        <input type="datetime-local" name="data">
        <textarea name="text" placeholder="Опис Задачі"></textarea>
        <input type="submit" name="send" value="Додати">
    </form>
</div>
</body>
</html>
