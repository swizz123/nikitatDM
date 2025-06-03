<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <h1>Мои заявки</h1>
    </div>
    
    <div class="nav">
        <a href="admin.php">Главная</a>
        <a href="new_request.php">Новая заявка</a>
        <a href="login.php">Выйти</a>
    </div>
    
    <div class="container">
        <a href="new_request.php" class="new-request-btn">Создать новую заявку</a>
        
        <div class="request-card">
            <div class="request-header">
                <span class="request-date">15.06.2025 14:00</span>
                <span class="request-status status-in-progress">В работе</span>
            </div>
            <div class="request-details">
                <div class="detail-row">
                    <span class="detail-label">Тип груза:</span>
                    <span>Мебель</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Вес:</span>
                    <span>150 кг</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Откуда:</span>
                    <span>ул. Ленина, 10</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Куда:</span>
                    <span>ул. Гагарина, 25</span>
                </div>
            </div>
        </div>
        
        <div class="request-card">
            <div class="request-header">
                <span class="request-date">10.06.2025 10:30</span>
                <span class="request-status status-new">Новая</span>
            </div>
            <div class="request-details">
                <div class="detail-row">
                    <span class="detail-label">Тип груза:</span>
                    <span>Хрупкое</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Вес:</span>
                    <span>50 кг</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Откуда:</span>
                    <span>ул. Мира, 5</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Куда:</span>
                    <span>ул. Садовая, 15</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>