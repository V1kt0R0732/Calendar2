<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детальней про задачу</title>
    <link rel="stylesheet" href="/template/assets/css/admin_detail.css">
</head>
<body>
<div class="task-details-container">
    <h1 class="task-title"><?=$task['title']?></h1>
    <h2 class="task-sub-title"><span id="time-left"></span></h2>
    <div class="task-info">
        <p><strong>Описание:</strong> <?=$task['text']?></p>
        <p><strong>Дата истечения:</strong> <?=$task['ua_time']?> <?=$task['deadline_time']?></p>
        <?php if(!empty($task['employees_str'])){ ?>
        <p><strong>Сотрудники:</strong> <span id="assigned-employees"><?=$task['employees_str']?></span></p>
        <?php } else { ?>
        <p><strong>Сотрудиники:</strong> <span id="assigned-employees">Нету</span></p>
        <?php } ?>
    </div>

    <form class="task-actions" action="/manage/add" method="post">
        <label for="assign-select">Добавить сотрудника:</label>
        <select id="assign-select" class="assign-select" name="worker">
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
        <input type="hidden" name="name" value="<?=$task['title']?>">
        <input type="hidden" name="time" value="<?php echo $task['deadline_day'].' '.$task['deadline_time'].':00'?>">
        <input class="action-button" value="Назначить задачу" name="send" type="submit">
    </form>
    <ul id="employee-list">
        <!-- Список сотрудников с возможностью удаления -->
        <?php foreach($task['employees_arr'] as $employee): ?>
            <li class="employee-item">
                <span><?=$employee['nick']?></span>
                <form method="post" action="/user/dell">
                    <input type="hidden" name="id" value="<?=$employee['id']?>">
                    <input type="hidden" name="task_id" value="<?=$task['id']?>">
                    <input type="hidden" name="title" value="<?=$task['title']?>">
                    <input type="submit" name="send" value="Удалить" class="remove-employee-button">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="admin-actions">
        <button class="action-button complete-task-button">Завершить задачу</button>
        <form method="post" action="/dell/task">
            <input type="hidden" name="id" value="<?=$task['id']?>">
            <input type="hidden" name="title" value="<?=$task['title']?>">
            <input class="action-button delete-task-button" value="Удалить задачу" name="send" type="submit">
        </form>
    </div>
    <a href="javascript:history.back();" class="back-link">Вернуться назад</a>
</div>
<script>
     document.addEventListener('DOMContentLoaded', function () {
        const deadlineDate = '<?=$task['deadline_day']?>';
        const deadlineTime = '<?=$task['deadline_time']?>';

        // Функция для обновления таймера
        function updateTimer() {
            const deadline = new Date(`${deadlineDate}T${deadlineTime}`);
            const now = new Date();
            const timeDifference = deadline - now;

            if (timeDifference > 0) {
                const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDifference / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((timeDifference / (1000 * 60)) % 60);
                const seconds = Math.floor((timeDifference / 1000) % 60);

                document.getElementById('time-left').textContent =
                    `Осталось: ${days}д ${hours}ч ${minutes}м ${seconds}с`;
            } else {
                document.getElementById('time-left').textContent = 'Задача просрочена';
            }
        }

        // Обновляем таймер каждую секунду
        setInterval(updateTimer, 1000);
        updateTimer(); // Первый вызов для немедленного отображения
    });

</script>
</body>
</html>
