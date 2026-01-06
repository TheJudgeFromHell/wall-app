<?php

session_start();
require_once 'config/database.php';


if(!isset($_SESSION['user_id'])) {
    echo "Вы не авторизованы! <a href='login.php'>Войдите</a>";
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = trim($_POST['content']);
    
    if(empty($content)) {
        $error = 'Сообщение не может быть пустым';
    } else {
        $conn = new mysqli('localhost', 'root', '', 'wall_app_db');
        
        
        $sql = "INSERT INTO messages (user_id, content) VALUES (" . $_SESSION['user_id'] . ", '" . $conn->real_escape_string($content) . "')";
        
        if($conn->query($sql)) {
            header('Location: index.php');
            exit;
        } else {
            $error = 'Ошибка: ' . $conn->error;
        }
        
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Создать сообщение</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        textarea { width: 100%; padding: 10px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div style="background: #333; color: white; padding: 1rem; margin-bottom: 2rem;">
        <a href="index.php" style="color: white;">← На главную</a>
        <span style="float: right;">Привет, <?php echo $_SESSION['username']; ?>!</span>
    </div>
    
    <h2>Создание нового сообщения</h2>
    
    <?php if($error): ?>
        <div style="color: red; padding: 10px; background: #fee;"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Сообщение:</label><br>
            <textarea name="content" rows="5" required placeholder="Введите ваше сообщение..."></textarea>
        </div>
        
        <button type="submit">Опубликовать</button>
        <a href="index.php" style="margin-left: 10px;">Отмена</a>
    </form>
</body>
</html>