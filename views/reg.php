<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/template/assets/css/reg.css">
</head>
<body>
<div class="container">
    <h1>Регистрация</h1>
    <form action="/user/resultReg" method="post">
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password1">Пароль:</label>
        <input type="password" id="password1" name="password_1" required>

        <label for="password2">Повторите пароль:</label>
        <input type="password" id="password2" name="password_2" required>

        <input type="submit" class="submit-button" name="send" value="Зарегистрироваться">
    </form>
    <a href="/user/login" class="view-tasks-link">Уже есть аккаунт? Войти</a>
</div>
</body>
</html>
