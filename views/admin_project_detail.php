<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детальна інформація про проект</title>
    <link rel="stylesheet" href="/template/assets/css/admin-project.css">
</head>
<body>
<div class="admin-container">
    <h1>Інформація про проект</h1>
    <div class="project-summary">
        <h2>Назва проекту: <span><?=$projectName?></span></h2>
        <p>Загальна кількість витраченого часу: <span>100 годин</span></p>
    </div>
    <div class="project-info">
        <div class="project-chart">
            <h3>Діаграма продуктивності</h3>
                <img src="/views/diagram.php" class="chart-placeholder">
        </div>
        <div>
            <h3 class="tasks-title">Задачі проекту</h3>
            <div class="tasks-section">
                <ul class="tasks-list">
                    <?php Task::print($tasks); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
