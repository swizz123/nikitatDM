<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Вход в систему</h1>
        
        <div class="error">
            Неверный логин или пароль
        </div>
        
        <div class="form-group">
            <label>Логин</label>
            <input type="text" placeholder="Введите логин" required>
        </div>
        
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" placeholder="Введите пароль" required>
        </div>
        
        <button type="submit">Войти</button>
        
        <div class="register-link">
            Еще не зарегистрированы? <a href="register.html">Зарегистрироваться</a>
        </div>
    </div>
</body>
</html>