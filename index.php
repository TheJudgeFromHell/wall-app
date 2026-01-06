<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>

<?php include 'includes/header.php'; ?>

<h1>Стена сообщений</h1>

<?php if(isLoggedIn()): ?>
    <div class="welcome">
        <p>Добро пожаловать! Вы можете <a href="create_message.php">написать сообщение</a>.</p>
    </div>
<?php else: ?>
    <div class="guest-info">
        <p>Чтобы писать сообщения, <a href="login.php">войдите</a> или <a href="register.php">зарегистрируйтесь</a>.</p>
    </div>
<?php endif; ?>

<div class="messages-list">
    <h2>Последние сообщения</h2>
    
    <?php
    $conn = connectDB();
    
    
    $query = "SELECT m.*, u.username 
              FROM messages m 
              JOIN users u ON m.user_id = u.id 
              ORDER BY m.created_at DESC";
    $result = $conn->query($query);
    
    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            
            $isOwner = isMessageOwner($row['user_id']);
            $canEdit = canEditDelete($row['created_at']);
            $canEditDelete = $isOwner && $canEdit;
            
            
    ?>
        <div class="message">
            <div class="message-header">
                <span class="author"><?php echo htmlspecialchars($row['username']); ?></span>
                <span class="date"><?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></span>
            </div>
            <div class="message-content">
                <?php echo nl2br(htmlspecialchars($row['content'])); ?>
            </div>
            
            <?php if($canEditDelete): ?>
                <div class="message-actions">
                    <a href="edit_message.php?id=<?php echo $row['id']; ?>" class="btn-edit">Редактировать</a>
                    <a href="delete_message.php?id=<?php echo $row['id']; ?>" class="btn-delete" 
                       onclick="return confirm('Удалить это сообщение?')">Удалить</a>
                </div>
            <?php endif; ?>
        </div>
    <?php
        endwhile;
    else:
    ?>
        <p>Пока нет сообщений. Будьте первым!</p>
    <?php
    endif;
    
    $conn->close();
    ?>
</div>

<?php include 'includes/footer.php'; ?>