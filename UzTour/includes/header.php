<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<header>
    <nav>
        <a href="../pages/main.php" id="logo"><img src="" alt=""></a>
        <ul id="menu">
            <li><a href="../pages/main.php?page=home"><?= $lang_texts['home'] ?></a></li>
            <li><a href="../pages/main.php?page=places"><?= $lang_texts['places'] ?></a></li>
            <li><a href="../pages/main.php?page=artifacts"><?= $lang_texts['artifacts'] ?></a></li>
            <li><a href="../pages/main.php?page=posts"><?= $lang_texts['posts'] ?></a></li>
            <li><a href="../pages/main.php?page=map"><?= $lang_texts['map'] ?></a></li>
            <li></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="../pages/add_post.php"><?= $lang_texts['add_post']?></a></li>
            <?php endif; ?>
        </ul>

        <div id="funcs">
            <!-- Til tanlash formasi -->
            <form action="../lang/set_lang.php" method="get" id="lang_form">
                <select name="lang" id="lang" onchange="this.form.submit()">
                    <option value="uz" <?= ($_SESSION['lang'] ?? 'uz') === 'uz' ? 'selected' : '' ?>>Uzbek</option>
                    <option value="en" <?= ($_SESSION['lang'] ?? 'uz') === 'en' ? 'selected' : '' ?>>English</option>
                    <option value="ru" <?= ($_SESSION['lang'] ?? 'uz') === 'ru' ? 'selected' : '' ?>>Russian</option>
                </select>
            </form>

            <!-- Profil yoki Login tugmasi -->
            <?php if (isset($_SESSION['user'])): ?>
                <?php
                    $firstname = $_SESSION['user_firstname'] ?? '';
                    $lastname = $_SESSION['user_lastname'] ?? '';
                    $lastnameInitial = $lastname !== '' ? strtoupper(mb_substr($lastname, 0, 1)) : '';
                    $displayName = trim($lastnameInitial . '. ' . htmlspecialchars($firstname));
                ?>
                <a href="../pages/auth/logout.php" id="profile">
                    <img src="../assets/images/user.png" alt="">
                    <p><?= $displayName ?></p>
                </a>
            <?php else: ?>
                <a href="../pages/auth/login.php" id="login_btn">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
