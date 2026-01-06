<?php

if (!function_exists('isLoggedIn')) {

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if(isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ];
    }
    return null;
}

function isMessageOwner($messageUserId) {
    return isLoggedIn() && $_SESSION['user_id'] == $messageUserId;
}

function canEditDelete($createdAt) {
    if (empty($createdAt)) return false;
    
    $messageTime = strtotime($createdAt);
    $currentTime = time();
    $hoursDiff = ($currentTime - $messageTime) / 3600;
    
    return $hoursDiff <= 24;
}

} 
?>