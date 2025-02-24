<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение</title>
    <link rel="stylesheet" href="/template/assets/css/result-style.css">
</head>
<body>
<div class="container">
    <div id="message" <?php if(isset($class) && !empty($class)) echo "class='$class'"; else { ?>class="success"<?php } ?>><?=$text?></div>
</div>
</body>
</html>
