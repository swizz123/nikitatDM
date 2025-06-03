<?php
session_start();

// Проверка авторизации и роли
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Остальной код админ-панели

require 'includes/db.php';

// Обработка изменения статуса
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id']) && isset($_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $request_id]);
}

// Получение всех заявок с информацией о пользователях
$stmt = $pdo->prepare("
    SELECT r.*, u.full_name, u.phone, u.email 
    FROM requests r
    JOIN users u ON r.user_id = u.id
    ORDER BY r.created_at DESC
");
$stmt->execute();
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Панель администратора</h1>
    </div>
    
    <div class="nav">
        <a href="requests.php">Мои заявки</a>
        <a href="new_request.php">Новая заявка</a>
        <a href="logout.php">Выйти</a>
    </div>
    
    <div class="container">
        <?php if (empty($requests)): ?>
            <p>Нет заявок для отображения.</p>
        <?php else: ?>
            <?php foreach ($requests as $request): ?>
            <div class="request-card">
                <div class="request-header">
                    <div>
                        <div class="request-user"><?php echo htmlspecialchars($request['full_name']); ?></div>
                        <div class="user-contacts">
                            <?php echo htmlspecialchars($request['phone']); ?><br>
                            <?php echo htmlspecialchars($request['email']); ?>
                        </div>
                    </div>
                    <div class="request-date">
                        <?php echo htmlspecialchars(date('d.m.Y H:i', strtotime($request['created_at']))); ?>
                    </div>
                </div>
                <div class="request-details">
                    <div class="detail-row">
                        <span class="detail-label">Дата перевозки:</span>
                        <span><?php echo htmlspecialchars(date('d.m.Y H:i', strtotime($request['request_date']))); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Тип груза:</span>
                        <span><?php echo htmlspecialchars($request['cargo_type']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Вес:</span>
                        <span><?php echo htmlspecialchars($request['weight']); ?> кг</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Габариты:</span>
                        <span><?php echo htmlspecialchars($request['dimensions']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Откуда:</span>
                        <span><?php echo htmlspecialchars($request['from_address']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Куда:</span>
                        <span><?php echo htmlspecialchars($request['to_address']); ?></span>
                    </div>
                </div>
                <form method="POST" class="status-control">
                    <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                    <span class="status-label">Статус:</span>
                    <select name="status">
                        <option value="Новая" <?php echo $request['status'] === 'Новая' ? 'selected' : ''; ?>>Новая</option>
                        <option value="В работе" <?php echo $request['status'] === 'В работе' ? 'selected' : ''; ?>>В работе</option>
                        <option value="Отменена" <?php echo $request['status'] === 'Отменена' ? 'selected' : ''; ?>>Отменена</option>
                    </select>
                    <button type="submit" class="update-btn">Обновить</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>