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
    <h1>Загальна інформація про проекти</h1>
    <div class="project-summary">
        <p>Загальна кількість витраченого часу: <span><?php echo number_format($allTime,'2',',')?> годин</span></p>
    </div>
    <div class="project-info">
        <div class="project-chart">
            <h3>Діаграма продуктивності</h3>
            <img src="/views/project_diagram.php" class="chart-placeholder">

        </div>
        <div>
            <h3 class="tasks-title">Проекти</h3>
            <div class="tasks-section">
                <ul class="tasks-list">
                    <?php foreach($project_list as $id=>$name): ?>
                    <li class="task-item">
                        <h4><?=$name?></h4>
                        <p></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
