<?php
session_start();
session_unset(); // Sessiyani tozalash
session_destroy(); // Sessiyani yo'q qilish

    header("Location: ../main.php"); // Bosh sahifaga qaytarish
exit();
?>