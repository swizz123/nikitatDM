<?php
session_start();
require 'includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    
    // Валидация
    if (empty($full_name)) $errors[] = 'ФИО обязательно для заполнения';
    if (empty($phone)) $errors[] = 'Телефон обязателен для заполнения';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Некорректный email';
    if (strlen($login) < 6 || !preg_match('/^[а-яА-ЯёЁ]+$/u', $login)) {
        $errors[] = 'Логин должен содержать только кириллицу и быть не менее 6 символов';
    }
    if (strlen($password) < 6) $errors[] = 'Пароль должен быть не менее 6 символов';
    
    // Проверка уникальности логина
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) $errors[] = 'Этот логин уже занят';
    
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (login, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$login, $hashed_password, $full_name, $phone, $email]);
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['login'] = $login;
        $_SESSION['full_name'] = $full_name;
        header('Location: admin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        
        <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="form-group">
                <label>ФИО</label>
                <input type="text" name="full_name" placeholder="Введите ФИО" required>
            </div>
            
            <div class="form-group">
                <label>Телефон</label>
                <input type="tel" name="phone" placeholder="+7(XXX)-XXX-XX-XX" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Введите email" required>
            </div>

            <div class="form-group">
                <label>Логин (кириллица, ≥6 символов)</label>
                <input type="text" name="login" placeholder="Введите логин" required>
            </div>
            
            <div class="form-group">
                <label>Пароль (≥6 символов)</label>
                <input type="password" name="password" placeholder="Введите пароль" required>
            </div>
            
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <div class="login-link">
            Уже зарегистрированы? <a href="login.php">Войти</a>
        </div>
    </div>
</body>
</html>