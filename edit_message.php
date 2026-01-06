<?php
session_start();
require_once 'config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($message_id == 0) {
    header('Location: index.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'wall_app_db');


$result = $conn->query("SELECT * FROM messages WHERE id = $message_id");
$message = $result->fetch_assoc();


if(!$message) {
    die("Сообщение не найдено");
}

if($message['user_id'] != $_SESSION['user_id']) {
    die("Вы не можете редактировать это сообщение");
}


$messageTime = strtotime($message['created_at']);
$currentTime = time();
$hoursDiff = ($currentTime - $messageTime) / 3600;

if($hoursDiff > 24) {
    die("Редактирование возможно только в течение 24 часов");
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = trim($_POST['content']);
    
    if(!empty($content)) {
        $conn->query("UPDATE messages SET content = '" . $conn->real_escape_string($content) . "' WHERE id = $message_id");
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редактирование</title>
</head>
<body>
    <div style="background: #333; color: white; padding: 1rem; margin-bottom: 2rem;">
        <a href="index.php" style="color: white;">← На главную</a>
    </div>
    
    <h2>Редактирование сообщения</h2>
    
    <form method="POST">
        <textarea name="content" rows="5" style="width: 100%;"><?php echo htmlspecialchars($message['content']); ?></textarea><br><br>
        <button type="submit">Сохранить</button>
        <a href="index.php">Отмена</a>
    </form>
</body>
</html>