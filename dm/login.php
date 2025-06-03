<?php
session_start();
require 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role']; // Сохраняем роль в сессии
        
        // Проверяем роль и перенаправляем
        if ($user['role'] === 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: profile.php'); // Для обычных пользователей
        }
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Вход в систему</h1>
        
        <?php if ($error): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" placeholder="Введите логин" required>
            </div>
            
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль" required>
            </div>
            
            <button type="submit">Войти</button>
        </form>
        
        <div class="register-link">
            Еще не зарегистрированы? <a href="register.php">Зарегистрироваться</a>
        </div>
    </div>
</body>
</html>