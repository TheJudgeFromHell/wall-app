
<?php
session_start();

$base_url = '/';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стена сообщений</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Стена сообщений</div>
            <div class="nav-links">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span>Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="<?php echo $base_url; ?>">Главная</a>
                    <a href="<?php echo $base_url; ?>create_message.php">Новое сообщение</a>
                    <a href="<?php echo $base_url; ?>logout.php">Выход</a>
                <?php else: ?>
                    <a href="<?php echo $base_url; ?>">Главная</a>
                    <a href="<?php echo $base_url; ?>login.php">Вход</a>
                    <a href="<?php echo $base_url; ?>register.php">Регистрация</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>