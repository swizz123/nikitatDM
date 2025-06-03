<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';

$error = '';
$success = '';

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_date = $_POST['request_date'];
    $weight = $_POST['weight'];
    $dimensions = $_POST['dimensions'];
    $cargo_type = $_POST['cargo_type'];
    $from_address = $_POST['from_address'];
    $to_address = $_POST['to_address'];
    
    // Валидация данных
    if (empty($request_date) || empty($weight) || empty($dimensions) || empty($cargo_type) || 
        empty($from_address) || empty($to_address)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif (!is_numeric($weight) || $weight <= 0) {
        $error = 'Вес должен быть положительным числом';
    } else {
        try {
            // Добавление заявки в БД
            $stmt = $pdo->prepare("INSERT INTO requests (user_id, request_date, weight, dimensions, cargo_type, from_address, to_address, status) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, 'Новая')");
            $stmt->execute([
                $_SESSION['user_id'],
                $request_date,
                $weight,
                $dimensions,
                $cargo_type,
                $from_address,
                $to_address
            ]);
            
            $success = 'Заявка успешно создана!';
            
            // Очистка полей формы после успешной отправки
            $_POST = array();
        } catch (PDOException $e) {
            $error = 'Ошибка при сохранении заявки: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Новая заявка</h1>
    </div>
    
    <div class="nav">
        <a href="admin.php">Главная</a>
        <a href="requests.php">Мои заявки</a>
        <a href="logout.php">Выйти</a>
    </div>
    
    <div class="container">
        <?php if ($error): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="success">
            <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="new_request.php">
            <div class="form-group">
                <label>Дата и время перевозки</label>
                <input type="datetime-local" name="request_date" value="<?php echo isset($_POST['request_date']) ? htmlspecialchars($_POST['request_date']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Вес груза (кг)</label>
                <input type="number" step="0.1" name="weight" placeholder="Пример: 50.5" 
                       value="<?php echo isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Габариты груза</label>
                <input type="text" name="dimensions" placeholder="Пример: 1.5м x 0.8м x 0.5м" 
                       value="<?php echo isset($_POST['dimensions']) ? htmlspecialchars($_POST['dimensions']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Тип груза</label>
                <select name="cargo_type" required>
                    <option value="">Выберите тип груза</option>
                    <option value="хрупкое" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'хрупкое') ? 'selected' : ''; ?>>Хрупкое</option>
                    <option value="скоропортящееся" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'скоропортящееся') ? 'selected' : ''; ?>>Скоропортящееся</option>
                    <option value="требуется рефрижератор" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'требуется рефрижератор') ? 'selected' : ''; ?>>Требуется рефрижератор</option>
                    <option value="животные" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'животные') ? 'selected' : ''; ?>>Животные</option>
                    <option value="жидкость" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'жидкость') ? 'selected' : ''; ?>>Жидкость</option>
                    <option value="мебель" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'мебель') ? 'selected' : ''; ?>>Мебель</option>
                    <option value="мусор" <?php echo (isset($_POST['cargo_type']) && $_POST['cargo_type'] === 'мусор') ? 'selected' : ''; ?>>Мусор</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Адрес отправления</label>
                <textarea name="from_address" placeholder="Введите полный адрес" required><?php echo isset($_POST['from_address']) ? htmlspecialchars($_POST['from_address']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Адрес доставки</label>
                <textarea name="to_address" placeholder="Введите полный адрес" required><?php echo isset($_POST['to_address']) ? htmlspecialchars($_POST['to_address']) : ''; ?></textarea>
            </div>
            
            <button type="submit">Отправить заявку</button>
        </form>
    </div>
</body>
</html>