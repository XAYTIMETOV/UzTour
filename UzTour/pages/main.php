<?php

    include '../includes/connect.php';
    session_start();

    // Tilni aniqlash (agar mavjud bo‘lmasa, 'uz' bo‘lsin)
    $lang = $_SESSION['lang'] ?? 'uz';

    // Til faylini chaqirish
    $lang_texts = include "../lang/$lang.php"; 

    // Sahifani aniqlash
    $page = $_GET['page'] ?? 'home'; 
    $allowed_pages = ['home', 'places', 'artifacts', 'posts', 'map', 'contact', 'about'];
    if (!in_array($page, $allowed_pages)) {
        $page = '404'; 
    }
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>UzTour | Uzbek Tourism</title>
</head>
<body>
    <main>
        <?php include '../includes/header.php'; ?>

        <?php 
            // Agar "home" tanlangan bo‘lsa, barcha sahifalar yuklanadi
            if ($page === 'home') {
                include '../pages/home.php';
                include '../pages/places.php';
                echo '<div id="places-show-more-container">
                        <button id="places-show-more-btn" class="show-more-btn">Show More</button>
                    </div>';
                include '../pages/artifacts.php';
                echo '<div id="artifacts-show-more-container">
                        <button id="artifacts-show-more-btn" class="show-more-btn">Show More</button>
                    </div>';
                include '../pages/posts.php';
                include '../pages/map.php';
                include '../pages/about.php';
                include '../pages/contact.php';
            } else {
                // Boshqa sahifa tanlansa, faqat o‘sha sahifa yuklanadi
                include "../pages/$page.php";
            }
        ?>

        <?php include '../includes/footer.php'; ?>
    </main>
    <script src="../assets/js/script.js" defer></script>
</body>
</html>