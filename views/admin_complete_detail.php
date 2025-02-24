<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детальней про задачу</title>
    <link rel="stylesheet" href="/template/assets/css/admin_complete_detail.css">
</head>
<body>
<div class="task-details-container">
    <h1 class="task-title"><?=$task['title']?></h1>
    <h2 class="task-sub-title">Завдання Виконано</h2>
    <div class="task-info">
        <p><strong>Описание:</strong> <?=$task['text']?></p>
        <p><strong>Дата истечения:</strong> <?=$task['ua_time']?> <?=$task['deadline_time']?></p>
        <?php if(!empty($task['employees_str'])){ ?>
            <p><strong>Сотрудники:</strong> <span id="assigned-employees"><?=$task['employees_str']?></span></p>
        <?php } else { ?>
            <p><strong>Сотрудикин:</strong> <span id="assigned-employees">Нету</span></p>
        <?php } ?>
    </div>

    <ul id="employee-list">
        <!-- Список сотрудников с возможностью удаления -->
        <?php User::print($task['employees_arr']); ?>
    </ul>
    <div class="admin-actions">
        <form method="post" action="/dell/task">
            <input type="hidden" name="id" value="<?=$task['id']?>">
            <input type="hidden" name="title" value="<?=$task['title']?>">
            <input class="action-button delete-task-button" value="Удалить задачу" name="send" type="submit">
        </form>
    </div>
    <a href="/complete/task/show/1" class="back-link">Назад к списку задач</a>
</div>
<script>


</script>
</body>
</html>
