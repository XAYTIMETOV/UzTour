<?php
session_start();

// Ruxsat berilgan tillar
$allowed_langs = ['uz', 'en', 'ru'];

// GET orqali kelgan tilni tekshiramiz va saqlaymiz
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Foydalanuvchini oldingi sahifaga qaytarish
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../pages/main.php'));
exit;
?>