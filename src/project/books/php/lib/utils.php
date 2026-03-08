<?php
// utils.php - simple helper functions

// Escape HTML output
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit;
}

// Flash message helpers (optional, if using sessions)
function setFlashMessage($type, $message) {
    if (!isset($_SESSION)) session_start();
    $_SESSION['flash'][$type] = $message;
}

function getFlashMessage($type) {
    if (!isset($_SESSION)) session_start();
    if (!empty($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}
?>