<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if(isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($username) || empty($email) || empty($password)) {
        $error = 'Все поля обязательны';
    } elseif($password !== $confirm_password) {
        $error = 'Пароли не совпадают';
    } else {
        $conn = connectDB();
        
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0) {
            $error = 'Пользователь уже существует';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            
            if($stmt->execute()) {
                $success = 'Регистрация успешна! <a href="login.php">Войдите</a>';
            } else {
                $error = 'Ошибка регистрации';
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Регистрация</h2>

<?php if($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<?php if($success): ?>
    <div class="success"><?php echo $success; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label>Имя пользователя:</label>
        <input type="text" name="username" required>
    </div>
    
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required minlength="6">
    </div>
    
    <div class="form-group">
        <label>Подтвердите пароль:</label>
        <input type="password" name="confirm_password" required minlength="6">
    </div>
    
    <button type="submit">Зарегистрироваться</button>
    <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
</form>

<?php include 'includes/footer.php'; ?>