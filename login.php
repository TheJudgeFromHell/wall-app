<?php

session_start();


require_once 'config/database.php';
require_once 'includes/functions.php';


if(isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = 'Введите email и пароль';
    } else {
        $conn = connectDB();
        
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();
            
            if(password_verify($password, $hashed_password)) {
                
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                
                
                echo "<script>alert('Авторизация успешна! ID: $id, Имя: $username');</script>";
                
                header('Location: index.php');
                exit;
            } else {
                $error = 'Неверный пароль';
            }
        } else {
            $error = 'Пользователь с таким email не найден';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Вход в систему</h2>

<?php if($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    
    <button type="submit">Войти</button>
    <p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
</form>

<?php include 'includes/footer.php'; ?>