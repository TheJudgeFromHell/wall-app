<?php

session_start();
?>
<!DOCTYPE html>
<html>
<body>
<h1>Тест всех ссылок</h1>

<h2>Сессия:</h2>
<pre><?php print_r($_SESSION); ?></pre>

<h2>Доступные страницы:</h2>
<ul>
    <li><a href="index.php">index.php</a></li>
    <li><a href="login.php">login.php</a></li>
    <li><a href="register.php">register.php</a></li>
    <li><a href="logout.php">logout.php</a></li>
    <li><a href="create_message.php">create_message.php</a></li>
</ul>

<h2>Проверка файлов:</h2>
<ul>
    <li>config/database.php: <?php echo file_exists('config/database.php') ? '✅ Существует' : '❌ Не найден'; ?></li>
    <li>includes/header.php: <?php echo file_exists('includes/header.php') ? '✅ Существует' : '❌ Не найден'; ?></li>
    <li>includes/functions.php: <?php echo file_exists('includes/functions.php') ? '✅ Существует' : '❌ Не найден'; ?></li>
    <li>css/style.css: <?php echo file_exists('css/style.css') ? '✅ Существует' : '❌ Не найден'; ?></li>
</ul>

<h2>Текущий путь:</h2>
<p><?php echo __DIR__; ?></p>
</body>
</html>