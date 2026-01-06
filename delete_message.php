<?php
session_start();

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

if($message) {
   
    if($message['user_id'] == $_SESSION['user_id']) {
        
        $messageTime = strtotime($message['created_at']);
        $currentTime = time();
        $hoursDiff = ($currentTime - $messageTime) / 3600;
        
        if($hoursDiff <= 24) {
            
            $conn->query("DELETE FROM messages WHERE id = $message_id");
            $_SESSION['success'] = 'Сообщение удалено';
        } else {
            $_SESSION['error'] = 'Удаление возможно только в течение 24 часов';
        }
    } else {
        $_SESSION['error'] = 'Вы не можете удалить это сообщение';
    }
}

$conn->close();
header('Location: index.php');
exit;
?>