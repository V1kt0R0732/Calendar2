<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/template/assets/css/login.css">
</head>
<body>
<div class="container">
    <h1>Вход</h1>
    <form action="/user/resultLog" method="post">
        <label for="login">Email:</label>
        <input type="text" id="login" name="email" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" class="submit-button" name="send" value="Войти">
    </form>
    <a href="/user/reg" class="view-tasks-link">Еще нет аккаунта? Зарегистрироваться</a>
</div>
</body>
</html>
